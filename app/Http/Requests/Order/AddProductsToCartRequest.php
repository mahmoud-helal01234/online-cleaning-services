<?php

namespace App\Http\Requests\Order;

use App\Http\Traits\ResponsesTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use App\Rules\IsProductOptionBelongToCompanyRule;
use Illuminate\Http\Exceptions\HttpResponseException;

class AddProductsToCartRequest extends FormRequest
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
                'company_id' => 'required|numeric|exists:companies,user_id',
                'items' => 'required|array',
                'items.*.product_option_id' => [new IsProductOptionBelongToCompanyRule(request('company_id')), "required","integer", "exists:product_options,id"],
                'items.*.quantity' => 'required|integer|min:1',
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
