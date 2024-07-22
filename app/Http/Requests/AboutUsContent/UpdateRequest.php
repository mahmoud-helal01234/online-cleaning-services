<?php

namespace App\Http\Requests\AboutUsContent;

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

            'title_ar'       =>  'required|string|max:200',
            'title_en'       =>  'required|string|max:200',
            'content_ar'       =>  'required|string|max:500',
            'content_en'       =>  'required|string|max:500',
            // 'long'         =>  'required|float',
            // 'lat'         =>   'required|float',
        ];
    }

    public function messages(): array
    {

        return [
            'title_ar.required' => __('auth.title_ar.required'),
            'title_en.required' => __('auth.title_en.required'),
            'content_ar.required' => __('auth.content_ar.required'),
            'content_en.required' => __('auth.content_en.required'),
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
