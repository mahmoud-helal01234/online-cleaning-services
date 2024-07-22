<?php

namespace App\Http\Requests\PromoCode;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Http\Traits\ResponsesTrait;

class StorePromoCodeCountriesRequest extends FormRequest
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

            'promo_code_id'         =>  'required|exists:promo_codes,id,type,countries',
            'countries_ids'          =>  'required|array',
            'countries_ids.*'          =>  'numeric|exists:countries,id'
        ];
    }

    public function messages(): array {

        return [
            'promo_code_id.required'    =>  __('validation.id.required'),
            'promo_code_id.exists'      =>  __('validation.id.exists'),
            'countries_ids.*'    =>  __('validation.id.required'),
            'countries_ids.*.exists'    =>  __('validation.id.exists'),
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


