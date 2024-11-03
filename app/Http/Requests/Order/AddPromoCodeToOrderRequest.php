<?php

namespace App\Http\Requests\Order;

use App\Http\Traits\ResponsesTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use App\Rules\PromoCodeForCompanyOrCountryRule;
use Illuminate\Http\Exceptions\HttpResponseException;

class AddPromoCodeToOrderRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {

        return
            [
                'promo_code' => ['required', 'exists:promo_codes,code', new PromoCodeForCompanyOrCountryRule(request('company_id'))],
                'order_id' => ['required', 'numeric', 'exists:orders,id'],
                'company_id' => 'required|numeric|exists:companies,user_id',
            ];
    }

    public function messages(): array
    {

        return [];
    }

    public function failedValidation(Validator $validator)
    {

        throw new HttpResponseException($this->apiResponse(null, false, $validator->errors()->first()));
    }

    public function failedAuthorization()
    {

        throw new HttpResponseException($this->apiResponse(null, false, "not authorized to access this"));
    }
}
