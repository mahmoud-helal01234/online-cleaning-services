<?php

namespace App\Http\Requests\OrderComment;

use App\Http\Traits\ResponsesTrait;
use App\Http\Services\Orders\OrdersService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use App\Http\Constants\FormRequestRulesConstant;
use App\Http\Traits\LoggedInUserTrait;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreRequest extends FormRequest
{
    use ResponsesTrait,LoggedInUserTrait;

    // protected $stopOnFirstFailure = true;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // authorize user
        $ordersService = new OrdersService();
        return $ordersService->canUserUpdateOrder($this->getLoggedInUser(),request('order_id'));

    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [

            'order_id'      =>  'required',
            'text'          =>  'required|string|max:500',
            'img_path'      =>  'required|' . FormRequestRulesConstant::ImageValidation
        ];
    }

    public function messages(): array {
        return [
            'order_id.required' => __('validation.id.required'),
            'text.required' => __('validation.text.required'),
            'img_path.required' => __('validation.img_path.required'),
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



