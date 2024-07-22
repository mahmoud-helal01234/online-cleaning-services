<?php

namespace App\Http\Requests\Client;

use App\Http\Traits\ResponsesTrait;
use App\Http\Traits\LoggedInUserTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use App\Http\Constants\FormRequestRulesConstant;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateProfileRequest extends FormRequest
{
    use ResponsesTrait;

    use LoggedInUserTrait;
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {

        $clientId = $this->getLoggedInUser()->id;

        return [
        
            'id'            => 'required|numeric|exists:clients,id',
            'name'          => 'sometimes|nullable|string|max:255',
            'email'         => 'sometimes|nullable|string|email|max:255|unique:clients,email,'.$clientId,
            'phone'         => 'sometimes|nullable|string|max:255|unique:clients,phone,'.$clientId,
            'country_id'    =>  'sometimes|nullable|exists:countries,id',
            'avatar'        => 'sometimes|nullable|' . FormRequestRulesConstant::ImageValidation,
            'password'      => 'sometimes|nullable|string|min:6',
        ];
    }

    public function messages(): array
    {

        return [

            'name.required' => __('validation.name.required'),
            'email.required' => __('validation.email.required'),
            'phone.required' => __('validation.phone.required'),
            'age.required' => __('validation.age.required'),
            'address.required' => __('validation.address.required'),
            'gender.required' => __('validation.gender.required'),
            'country_id.required' => __('validation.country_id.required'),
            'country_id.exists' => __('validation.country_id.exists'),
            'password.required' => __('validation.password.required'),
            'password.min' => __('validation.password.min'),
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException($this->apiResponse(null, false, $validator->errors()->first()));
    }
    public function failedAuthorization()
    {
        throw new HttpResponseException($this->apiResponse(data: null, status: false, message: __('auth.authorization.not_authorized')));
    }
}
