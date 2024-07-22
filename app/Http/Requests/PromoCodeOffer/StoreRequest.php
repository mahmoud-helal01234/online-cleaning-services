<?php

namespace App\Http\Requests\PromoCodeOffer;

use App\Http\Traits\ResponsesTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use App\Http\Constants\FormRequestRulesConstant;
use Illuminate\Http\Exceptions\HttpResponseException;

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

            'promo_code_id'    =>  "required|numeric|exists:promo_codes,id",

            'img_path'    =>  "required|".FormRequestRulesConstant::ImageValidation,
            'active'        =>  "sometimes|numeric|in:0,1"
        ];
    }

    public function messages(): array {

        return [
            'promo_code_id.required'    =>  __('validation.id.required'),
            'promo_code_id.exists'      =>  __('validation.id.exists'),
            'img_path.required'         =>  __('validation.img_path.required'),
            'active.in'                 =>  __('validation.active.in'),
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



