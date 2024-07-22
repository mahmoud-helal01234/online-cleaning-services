<?php

namespace App\Http\Requests\CooperationWithUsReason;

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
            'id'        => 'required|numeric|exists:cooperation_with_us_reasons,id',
            'title_ar' =>             'required|string|max:255',
            'title_en' =>             'required|string|max:255',
            'img_path'  => 'sometimes|' . FormRequestRulesConstant::ImageValidation,
            'active'          => 'sometimes|numeric|in:0,1'
        ];
    }

    public function messages(): array {
        return [
            'id.required'  => __('validation.id.required'),
            'id.numeric'  => __('validation.id.numeric'),
            'img_path.required'  => __('validation.img_path.required'),
            'title_ar.required'  => __('validation.title_ar.required'),
            'title_en.required'  => __('validation.title_en.required'),
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
