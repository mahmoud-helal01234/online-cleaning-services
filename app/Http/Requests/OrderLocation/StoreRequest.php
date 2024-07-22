<?php

namespace App\Http\Requests\OrderLocation;

use App\Http\Traits\LoggedInUserTrait;
use App\Models\Order;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Http\Traits\ResponsesTrait;

class StoreRequest extends FormRequest
{
    use ResponsesTrait;
    use LoggedInUserTrait;

    // protected $stopOnFirstFailure = true;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $loggedInUserId = $this->getLoggedInUser()->id;
        // authorize user
        return Order::where('id',request('order_id'))->where(request('status') .'_driver_id',$loggedInUserId)->count() > 0;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $user = $this->getLoggedInUser();

        return [
            'order_id'                  =>  'required',
            'status'                    =>  'required',
            'lat'                       =>  'required|numeric',
            'long'                      =>  "required|numeric",
        ];
    }

    public function messages(): array {

        return [
            'order_id.required' => __('validation.id.required'),
            'status.required' => __('validation.status.required'),
            'lat.required' => __('validation.latitude.required'),
            'long.required' => __('validation.longitude.required'),
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException($this->apiResponse(null,false,$validator->errors()->first()));
    }

    public function failedAuthorization()
    {
        throw new HttpResponseException($this->apiResponse(data: null, status: false, message: __('auth.authorization.not_authorized')));
    }


}



