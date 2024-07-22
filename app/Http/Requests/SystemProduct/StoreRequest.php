<?php

namespace App\Http\Requests\SystemProduct;

use App\Http\Traits\ResponsesTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use App\Http\Constants\FormRequestRulesConstant;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreRequest extends FormRequest
{
    use ResponsesTrait;

    // protected $stopOnFirstFailure = true;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
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

            'name_ar'       =>  'required|string',
            'name_en'       =>  'required|string',
            'category_id'   =>  "required|numeric|exists:categories,id",
            'img_path'      =>  "required|".FormRequestRulesConstant::ImageValidation,
        ];
    }

    public function messages(): array
    {

        return [
            'name_ar.required' =>  __('validation.name_ar.required'),
            'name_en.required' =>  __('validation.name_en.required'),
            'category_id.required' =>  __('validation.id.required'),
            'category_id.exists' =>  __('validation.id.exists'),
            'img_path.required' =>  __('validation.img_path.required')
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
