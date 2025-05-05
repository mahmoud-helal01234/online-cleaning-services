<?php

namespace App\Http\Requests\ProductOption;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Http\Traits\ResponsesTrait;

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
            'product_id'    =>  "required|numeric|exists:products,id",
            'price'         =>  'required|numeric',

        ];
    }

    public function messages(): array {

        return [
            'options.*.name_ar.required'  => __('validation.name_ar.required'),
            'options.*.name_en.required'  => __('validation.name_en.required'),
            'options.*.price_unit_ar.required'  => __('validation.price_unit_ar.required'),
            'options.*.price_unit_en.required'  => __('validation.price_unit_en.required'),
            'options.*.price.required'  => __('validation.options.price.required'),
            'options.*.active.in' => __('validation.active.in')
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



