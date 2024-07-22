<?php

namespace App\Http\Requests\NavbarFooterContent;

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

            'whatsapp_number'=>  'required|string|max:20',
            'phone_number'=>  'required|string|max:20',
            'facebook_link'=>  'required|string|max:100',
            'instagram_link'=>  'required|string|max:100',
            'twitter_link'=>  'required|string|max:100',
            'footer_title_ar'=>  'required|string|max:100',
            'footer_title_en'=>  'required|string|max:100',
            'footer_content_ar'=>  'required|string|max:200',
            'footer_content_en'=>  'required|string|max:200'
        ];
    }

    public function messages(): array
    {

        return [
            'whatsapp_number.required' => __('validation.navbar_footer.whatsapp_number.required'),
            'phone_number.required' => __('validation.navbar_footer.phone_number.required'),
            'facebook_link.required' => __('validation.navbar_footer.facebook_link.required'),
            'instagram_link.required' => __('validation.navbar_footer.instagram_link.required'),
            'twitter_link.required' => __('validation.navbar_footer.twitter_link.required'),
            'footer_title_ar.required' => __('validation.title_ar.required'),
            'footer_title_en.required' => __('validation.title_en.required'),
            'footer_content_ar.required' => __('validation.content_ar.required'),
            'footer_content_en.required' => __('validation.content_en.required')
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
