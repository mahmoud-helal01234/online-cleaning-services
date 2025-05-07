<?php

namespace App\Http\Requests\HomePageContent;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Http\Traits\ResponsesTrait;
use App\Http\Constants\FormRequestRulesConstant;

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

            'section1_title_en'          =>  'required|string|max:400',
            'section1_title_ar'          =>  'required|string|max:400',

            'section1_sub_title_en'          =>  'required|string|max:400',
            'section1_sub_title_ar'          =>  'required|string|max:400',

            'section1_desc_en'          =>  'required|string|max:2000',
            'section1_desc_ar'          =>  'required|string|max:2000',

            'google_play_link'        =>  'required|string|max:400',
            'app_store_link'        =>  'required|string|max:400',

            'about_title_en'    =>  'required|string|max:500',

            'about_title_ar'    =>  'required|string|max:500',
            'about_description_en'    =>  'required|string|max:2000',
            'about_description_ar'    =>  'required|string|max:2000',

            'about_image'       =>  'sometimes|' . FormRequestRulesConstant::ImageValidation,

            'services_title_ar'    =>  'required|string|max:400',
            'services_title_en'    =>  'required|string|max:400',

            'services_description_ar'    =>  'required|string|max:2000',
            'services_description_en'    =>  'required|string|max:2000',

            'our_clients_reviews_title_ar'    =>  'required|string|max:400',
            'our_clients_reviews_title_en'    =>  'required|string|max:400'

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
