<?php

namespace App\Http\Requests\PromoCode;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Http\Traits\ResponsesTrait;

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

            'id'                =>  'required|exists:promo_codes,id',
            'code'          =>  'required|string|max:20|unique:promo_codes,code,'.request('id'),
            'value'         =>  'required|numeric',
            'value_type'	=>  'required|in:percentage,constant',
            'from' =>             'required|date_format:Y-m-d H:i',
            'to' =>             'required|date_format:Y-m-d H:i',
            'active'        =>  'sometimes|numeric|in:0,1',
            'companies_ids'          =>  'sometimes|array',
            'companies_ids.*'          =>  'required|exists:companies,user_id',
            'countries_ids'          =>  'sometimes|array',
            'countries_ids.*'          =>  'required|exists:countries,id',
            'products_ids'          =>  'sometimes|array',
            'products_ids.*'          =>  'required|exists:products,id'
        ];
    }

    public function messages(): array {

        return [
            'id.required'               =>  __('validation.id.required'),
            'id.exists'                 =>  __('validation.id.exists'),
            'code.required'             =>  __('validation.code.required'),
            'value.required'            =>  __('validation.value.required'),
            'value_type.required'       =>  __('validation.value_type.required'),
            'type.required'             =>  __('validation.type.required'),
            'from.required'             =>  __('validation.from.required'),
            'to.required'               =>  __('validation.to.required'),
            'active.in'                 =>  __('validation.active.in'),
            'companies_ids.*'           =>  __('validation.id.required'),
            'companies_ids.*.exists'    =>  __('validation.id.exists'),
            'countries_ids.*.exists'    =>  __('validation.id.exists'),
            'products_ids.*.exists'     =>  __('validation.id.exists'),
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
