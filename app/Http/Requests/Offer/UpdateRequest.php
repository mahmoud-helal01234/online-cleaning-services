<?php

namespace App\Http\Requests\Offer;

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

            'id'             =>  'required|exists:offers,id',
            'value'          =>  'sometimes|nullable|numeric',
            'value_type'     =>  'sometimes|nullable|string|in:constant,percentage',
            'start'          =>  'sometimes|nullable|date_format:Y-m-d H:i',
            'end'            =>  'sometimes|nullable|date_format:Y-m-d H:i',
            'img_path'       =>  "sometimes|nullable|" .FormRequestRulesConstant::ImageValidation,
            'active'         =>  "sometimes|nullable|numeric|in:0,1",
            'companies.*'    =>  'sometimes|nullable|array',
        ];
    }

    public function messages(): array
    {

        return [
            'id.required'       => __('validation.id.required'),
            'id.exists'         => __('validation.id.exists'),
            'from.required'     => __('validation.from.required'),
            'to.required'       => __('validation.to.required'),
            'img_path.required' => __('validation.img_path.required'),
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