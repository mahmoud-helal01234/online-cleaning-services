<?php

namespace App\Http\Requests\Setting;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Http\Traits\ResponsesTrait;

class UpdateRequest extends FormRequest
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

            'first_order_cash_back_value'       =>  'required|numeric',
            'first_order_cash_back_value_type'       =>  'required|in:constant,percentage',
            'invitation_code_owner_cash_value'       =>  'required|numeric',
            'invitation_code_owner_cash_value_type'       =>  'required|in:constant,percentage',
            'invitation_code_user_cash_value'       =>  'required|numeric',
            'invitation_code_user_cash_value_type'       =>  'required|in:constant,percentage'
        ];
    }

    public function messages(): array
    {

        return [
            'first_order_cash_back_value.required'       =>  __('validation.first_order_cash_back_value.required'),
            'first_order_cash_back_value_type.required'       =>  __('validation.first_order_cash_back_value_type.required'),
            'invitation_code_owner_cash_value.required'       =>  __('validation.invitation_code_owner_cash_value.required'),
            'invitation_code_owner_cash_value_type.required'       =>  __('validation.invitation_code_owner_cash_value_type.required'),
            'invitation_code_user_cash_value.required'       =>  __('validation.invitation_code_user_cash_value.required'),
            'invitation_code_user_cash_value_type.required'       =>  __('validation.invitation_code_user_cash_value_type.required')
        ];
    }

    public function failedValidation(Validator $validator)
    {

        throw new HttpResponseException($this->apiResponse(null, false, $validator->errors()->first()));
    }

    public function failedAuthorization()
    {

        throw new HttpResponseException($this->apiResponse(null, false, "not authorized to access this"));
    }
}
