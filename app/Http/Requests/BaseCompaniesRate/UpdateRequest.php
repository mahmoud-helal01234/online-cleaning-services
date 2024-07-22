<?php

namespace App\Http\Requests\BaseCompaniesRate;

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

            'id'            =>  'required|numeric|exists:base_companies_rates,id',
            'name_ar'       =>  'required|string',
            'name_en'       =>  'required|string'
        ];
    }

    public function messages(): array
    {

        return [
            'id'      => __('validation.id.required'),
            'name_ar' => __('validation.name_ar.required'),
            'name_en' => __('validation.name_en.required'),
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
