<?php

namespace App\Http\Requests\Country;

use Illuminate\Validation\Rule;
use App\Http\Traits\ResponsesTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use App\Http\Constants\FormRequestRulesConstant;
use Illuminate\Http\Exceptions\HttpResponseException;

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
            'id'                => 'required|numeric|exists:countries,id',
            'name_ar'           => ['sometimes', 'nullable', 'string', Rule::unique('countries', 'name_ar')->ignore(request('id'))],
            'name_en'           => ['sometimes', 'nullable', 'string', Rule::unique('countries', 'name_en')->ignore(request('id'))],
            'img_path'          => 'sometimes|nullable|' . FormRequestRulesConstant::ImageValidation,
            'active'            => 'sometimes|nullable|numeric|in:0,1'
        ];
    }

    public function messages(): array {
        return [
            'id.required'  => __('validation.id.required'),
            'id.exists'  => __('validation.id.exists'),
            'name_ar.required'  => __('validation.name_ar.required'),
            'name_en.required'  => __('validation.name_en.required'),
            'img_path.required'  => __('validation.img_path.required'),
            'active.in'  => __('validation.active.in'),
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
