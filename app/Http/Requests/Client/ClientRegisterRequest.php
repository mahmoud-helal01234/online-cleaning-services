<?php

namespace App\Http\Requests\Client;

use Illuminate\Validation\Rule;
use App\Http\Traits\ResponsesTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ClientRegisterRequest extends FormRequest
{
    use ResponsesTrait;

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

        return [

            'name'          => 'required|string|max:255',
            'email'         => 'required|string|email|max:255|unique:clients',
            'phone'         => 'required|string|max:255|unique:clients',
            'password'      => 'required|string|min:6',
        ];
    }

    public function messages(): array
    {

        return [
            'name.required' => __('validation.name.required'),
            'email.required' => __('validation.email.required'),
            'phone.required' => __('validation.phone.required'),
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
