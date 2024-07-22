<?php

namespace App\Http\Requests\OffersPageContent;

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

            'title_ar'          =>  'required|string|max:200',
            'title_en'          =>  'required|string|max:200',
            'second_title_ar'   =>  'required|string|max:150',
            'second_title_en'   =>  'required|string|max:150',
            'logo_path'         =>  'required|'.FormRequestRulesConstant::ImageValidation,
            'img_path'          =>  'required|'.FormRequestRulesConstant::ImageValidation,
            'google_play_link'  =>  'required|string|max:100',
            'app_store_link'    =>  'required|string|max:100',
            'content_ar'        =>  'required|string|max:500',
            'content_en'        =>  'required|string|max:500'
        ];
    }

    public function messages(): array
    {

        return [
            'title_ar.required' => __('validation.title_ar.required'),
            'title_en.required' => __('validation.title_en.required'),
            'second_title_ar.required' => __('validation.title_ar.required'),
            'second_title_en.required' => __('validation.title_en.required'),
            'logo_path.required' => __('validation.img_path.required'),
            'img_path.required' => __('validation.img_path.required'),
            'content_ar.required' => __('validation.content_ar.required'),
            'content_en.required' => __('validation.content_en.required'),
            'google_play_link.required' => __('validation.google_play_link.required'),
            'app_store_link.required' => __('validation.app_store_link.required'),
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
