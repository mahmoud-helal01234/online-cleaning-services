<?php

namespace App\Http\Requests\Product;

use Illuminate\Support\Facades\DB;
use App\Http\Traits\ResponsesTrait;
use App\Http\Traits\LoggedInUserTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use App\Http\Constants\FormRequestRulesConstant;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreRequest extends FormRequest
{
    use ResponsesTrait, LoggedInUserTrait;

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



        return
            [
                'name_ar'           =>  'required|string',
                'name_en'           =>  'required|string',
                'category_id'       =>  "required|numeric|exists:categories,id",

                'options'                   =>  'required|array',
                'options.*.option_id'         =>  'required|exists:options,id',

                'options.*.price'           =>  'required|numeric|min:0'
            ];
    }

    public function messages(): array
    {

        return [
            'name_ar.required'  => __('validation.name_ar.required'),
            'name_en.required'  => __('validation.name_en.required'),
            'category_id.required'  => __('validation.id.required'),
            'category_id.exists'  => __('validation.id.exists'),
            'company_id.required'  => __('validation.id.required'),
            'company_id.exists'  => __('validation.id.exists'),
            'img_path.required'       => __('validation.img_path.required'),

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

        throw new HttpResponseException($this->apiResponse(null, false, $validator->errors()->first()));
    }

    public function failedAuthorization()
    {

        throw new HttpResponseException($this->apiResponse(data: null, status: false, message: __('auth.authorization.not_authorized')));
    }
}
