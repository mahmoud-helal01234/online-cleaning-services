<?php

namespace App\Http\Requests\ClientLocation;

use App\Http\Traits\LoggedInUserTrait;
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
        // authorize user
        return true;
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

            'client_id'                 =>  $user->role != 'client' ? 'required|exists:clients,id':'',
            'lat'                       =>  'required|numeric|between:-90.00000000,90.00000000',
            'long'                      =>  "required|numeric|between:-180.00000000,180.00000000",
            'phone_number'              =>  "required|string|max:20",
            'location_type'             =>  "required|in:apartment,office,house",
            'street'                    =>  "required|string|max:30",
            'building'                  =>  "required|string|max:10",
            'floor'                     =>  "required|string|max:10",
            'apartment'                 =>  "required|string|max:10",
            'detailed_address'          =>  "required|string|max:200",
            'additional_instructions'   =>  "sometimes|nullable|string|max:200",
            'telephone'                 =>  "sometimes|nullable|string|max:20"
        ];
    }

    public function messages(): array {

        return [

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



