<?php

namespace App\Http\Requests\PromoCode;

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

            'code'          =>  'required|string|max:20|unique:promo_codes,code',
            'value'         =>  'required|numeric',
            'value_type'	=>  'required|in:percentage,constant',
            'type'          =>  'required|in:countries,companies,products',
            'from' =>             'required|date_format:Y-m-d H:i',
            'to' =>             'required|date_format:Y-m-d H:i',
            'active'        =>  'sometimes|numeric|in:0,1',
            'companies_ids'          =>  'required_if:type,companies|array',
            'companies_ids.*'          =>  'required_if:type,companies|exists:companies,user_id',
            'countries_ids'          =>  'required_if:type,countries|array',
            'countries_ids.*'          =>  'required_if:type,countries|exists:countries,id',
            'products_ids'          =>  'required_if:type,products|array',
            'products_ids.*'          =>  'required_if:type,products|exists:products,id'

        ];
    }

    public function messages(): array {

        return [
            'code.required'             =>  __('validation.code.required'),
            'value.required'            =>  __('validation.value.required'),
            'value_type.required'       =>  __('validation.value_type.required'),
            'type.required'             =>  __('validation.type.required'),
            'from.required'             =>  __('validation.from.required'),
            'to.required'               =>  __('validation.to.required'),
            'active.in'                 =>  __('validation.active.in'),
            'companies_ids.*'           =>  __('validation.id.required'),
            'countries_ids.*'           =>  __('validation.id.required'),
            'products_ids.*'           =>  __('validation.id.required'),
            'companies_ids.*.exists'    =>  __('validation.id.exists'),
            'countries_ids.*.exists'    =>  __('validation.id.exists'),
            'products_ids.*.exists'     =>  __('validation.id.exists'),
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



