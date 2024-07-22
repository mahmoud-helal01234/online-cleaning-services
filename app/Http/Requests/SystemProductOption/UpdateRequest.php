<?php

namespace App\Http\Requests\SystemProductOption;

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

            'id'        => 'required|numeric',
            'name_ar' =>             'required|string',
            'name_en' =>             'required|string',
            'system_product_id'    =>  "required|numeric|exists:system_products,id",
        ];
    }

    public function messages(): array
    {

        return [
            'id.required' =>  __('validation.id.required'),
            'id.exists' =>  __('validation.id.exists'),
            'name_ar.required' =>  __('validation.name_ar.required'),
            'name_en.required' =>  __('validation.name_en.required'),
            'system_product_id.required' =>  __('validation.id.required'),
            'system_product_id.exists' =>  __('validation.id.exists'),
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