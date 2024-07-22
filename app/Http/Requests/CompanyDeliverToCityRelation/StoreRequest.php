<?php

namespace App\Http\Requests\CompanyDeliverToCityRelation;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Http\Traits\ResponsesTrait;

class StoreRequest extends FormRequest
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

            'company_id'      => 'required|numeric|exists:companies,user_id',
            'city_id'      => 'required|numeric|exists:cities,id',
        ];
    }

    public function messages(): array
    {

        return [
            'company_id.required'      => __('validation.id.required'),
            'company_id.exists'        => __('validation.id.exists'),
            'city_id.required'      => __('validation.id.required'),
            'city_id.exists'        => __('validation.id.exists'),
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
