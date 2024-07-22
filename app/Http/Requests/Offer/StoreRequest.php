<?php

namespace App\Http\Requests\Offer;

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
        //'img_path', 'value', 'value_type', 'type', 'start', 'end', 'active', 'deleted_at'
        return [

            'value'                     =>  'required|numeric',
            'value_type'                =>  'required|string|in:constant,percentage',
            'start'                     =>  'required|date_format:Y-m-d H:i',
            'end'                       =>  'required|date_format:Y-m-d H:i',
            'img_path'                  =>  "required|" .FormRequestRulesConstant::ImageValidation,
            'active'                    =>  "sometimes|numeric|in:0,1",
            'companies.*'               =>  'required|array',
            'companies.*.company_id'    =>  'required|exists:companies,user_id'
        ];
    }

    public function messages(): array {

        return [
           //
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



