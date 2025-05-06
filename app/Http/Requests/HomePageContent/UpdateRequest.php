<?php

namespace App\Http\Requests\HomePageContent;

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
          
            'section1_title'          =>  'required|string|max:400',
            'section1_desc'          =>  'required|string|max:2000',
            'google_play_link'        =>  'required|string|max:400',
            'app_store_link'        =>  'required|string|max:400',
            'about_title'    =>  'required|string|max:500',
            'about_description'    =>  'required|string|max:2000',
            'about_image'    =>  'required|string|max:400',

            'services_title'    =>  'required|string|max:400',

            'services_description'    =>  'required|string|max:2000',

            'our_clients_reviews_title'    =>  'required|string|max:400'


        ];

    }

    public function messages(): array
    {

        return [
            'title_ar.required' => __('validation.title_ar.required'),
            'title_en.required' => __('validation.title_en.required'),
            'content_ar.required' => __('validation.content_ar.required'),
            'content_en.required' => __('validation.content_en.required'),
            'button_text_ar.required' => __('validation.button_text_ar.required'),
            'button_text_en.required' => __('validation.button_text_en.required'),
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
