<?php

namespace App\Http\Requests\Client;

use App\Http\Traits\ResponsesTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use App\Http\Constants\FormRequestRulesConstant;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreRequest extends FormRequest
{

    use ResponsesTrait;


    public function __construct()
    {

    }

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

        return [

            'name'      =>  'required|string|max:255',
            'email'     =>  'required|string|email|max:255|unique:clients,email',
            'phone'     =>  'required|string|max:255|unique:clients,phone',
            'password'  =>  'required|string|min:6',
            "active"    => 'sometimes|numeric|in:0,1',
            "avatar"        => 'sometimes|' . FormRequestRulesConstant::ImageValidation,
            'country_id'    =>  'required|exists:countries,id',
        ];
    }

    public function messages(): array {

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

        throw new HttpResponseException($this->apiResponse(null,false,$validator->errors()->first()));
    }

    public function failedAuthorization()
    {

        throw new HttpResponseException($this->apiResponse(data: null, status: false, message: __('auth.authorization.not_authorized')));
    }

}
