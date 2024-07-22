<?php

namespace App\Http\Requests\PromoCodeOffer;

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

            'id'                =>  'required|exists:promo_code_offers,id',
            'promo_code_id'     =>  "sometimes|numeric|exists:promo_codes,id",

            'img_path'          =>  "sometimes|".FormRequestRulesConstant::ImageValidation,
            'active'            =>  "sometimes|numeric|in:0,1"
        ];
    }

    public function messages(): array
    {

        return [
            'id.required'               =>  __('validation.id.required'),
            'id.exists'                 =>  __('validation.id.exists'),
            'promo_code_id.required'    =>  __('validation.id.required'),
            'promo_code_id.exists'      =>  __('validation.id.exists'),
            'img_path.required'         =>  __('validation.img_path.required'),
            'active.in'                 =>  __('validation.active.in'),
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
