<?php

namespace App\Http\Requests\StatisticsTag;

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

            'title_ar'  =>  'required|string|max:100',
            'title_en'  =>  'required|string|max:100',
            'percentage'=>  'required|numeric',
            'img_path'  =>  'required|'.FormRequestRulesConstant::ImageValidation,
        ];
    }

    public function messages(): array {
        return [
            'title_ar.required' =>  __('validation.title_ar.required'),
            'title_en.required' =>  __('validation.title_en.required'),
            'percentage.required' =>  __('validation.percentage.required'),
            'img_path.required' =>  __('validation.img_path.required')
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



