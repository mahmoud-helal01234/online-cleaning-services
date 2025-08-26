<?php

namespace App\Http\Requests\Option;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Http\Traits\ResponsesTrait;

class AddOptionToProductRequest extends FormRequest
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
            'product_id' =>             'required|exists:products,id',
            'option_id'  => 'required|exists:options,id',
            'price'
        ];
    }
    public function messages(): array
    {

        return [
            'product_id.required' => __('validation_id.product_id.required'),
            'option_id.required' => __('validation_id.option_id.required'),
            'product_id.required' => __('validation_id.product_id.required'),
            'option_id.required' => __('validation_id.option_id.required'),
        ];
    }
    public function failedValidation(Validator $validator){
        throw new HttpResponseException($this->apiResponse(null,false,$validator->errors()->first()));
    }
    public function failedAuthorization()
    {
        throw new HttpResponseException($this->apiResponse(data: null, status: false, message: __('auth.authorization.not_authorized')));
    }
}
