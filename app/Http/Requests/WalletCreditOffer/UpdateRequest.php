<?php

namespace App\Http\Requests\WalletCreditOffer;

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

            'id'                =>  'required|exists:wallet_credit_offers,id',
            'name_ar'           =>  'required|string',
            'name_en'           =>  'required|string',
            'description_ar'	=>  'required|string',
            'description_en'	=>  'required|string',
            'img_path'          =>  'sometimes|'.FormRequestRulesConstant::ImageValidation,
            'value'             =>  'required|numeric',
            'value_type'        =>  'required|in:constant,percentage',
        	'min_amount'        =>  'required|numeric',
        	'max_amount'        =>  'required|numeric',
        ];
    }

    public function messages(): array
    {

        return [
            'id.required'  =>  __('validation.id.required'),
            'id.exists'  =>  __('validation.id.exists'),
            'name_ar.required'  =>  __('validation.name_ar.required'),
            'name_en.required'  =>  __('validation.name_en.required'),
            'description_ar.required'  =>  __('validation.description_ar.required'),
            'description_en.required'  =>  __('validation.description_en.required'),
            'img_path.required'  =>  __('validation.img_path.required'),
            'value.required'  =>  __('validation.value.required'),
            'value_type.required'  =>  __('validation.value_type.required'),
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
