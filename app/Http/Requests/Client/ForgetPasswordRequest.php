<?php

namespace App\Http\Requests\Client;

use App\Http\Traits\LoggedInUserTrait;
use App\Http\Traits\ResponsesTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ForgetPasswordRequest extends FormRequest
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

        return [

            'email' => 'required|string|email|exists:clients,email'
        ];
    }

    public function messages(): array
    {

        return [
            'email.required' => __('validation.email.required'),
            'email.exists' => __('validation.email.exists'),
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
