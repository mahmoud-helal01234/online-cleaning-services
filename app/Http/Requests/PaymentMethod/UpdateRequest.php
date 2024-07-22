<?php

namespace App\Http\Requests\PaymentMethod;

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

            'id'                =>  'required|exists:payment_methods,id',
            'title_ar'           =>  'required|string|max:50',
            'title_en'           =>  'required|string|max:50',
            'active'             =>  'required|numeric|in:0,1',
            'img_path'          =>  'sometimes|'.FormRequestRulesConstant::ImageValidation,
        ];
    }

    public function messages(): array
    {

        return [
            'id.required'        => __('validation.id.required'),
            'id.exists'          => __('validation.id.exists'),
            'title_ar.required'  => __('validation.title_ar.required'),
            'title_en.required'  => __('validation.title_en.required'),
            'img.required'       => __('validation.img_path.required'),
            'active.in' => __('validation.active.in'),
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
