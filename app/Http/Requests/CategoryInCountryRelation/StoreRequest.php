<?php

namespace App\Http\Requests\CategoryInCountryRelation;

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

            'country_id'      => 'required|numeric|exists:countries,id',
            'category_id'      => 'required|numeric|exists:categories,id',
        ];
    }

    public function messages(): array
    {

        return [
            'country_id.required' => __('validation.id.required'),
            'category_id.required' => __('validation.id.required'),
            'country_id.exists' => __('validation.id.exists'),
            'category_id.exists' => __('validation.id.exists'),
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
