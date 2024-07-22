<?php

namespace App\Http\Requests\ClientFeedback;

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
            'id'                    =>  'required|numeric|exists:client_feedback,id',
            'feedback_message'       =>  'required|string',
            'value'                  => 'required|numeric|between:1,10',

        ];
    }

    public function messages(): array
    {

        return [
            'id.required' => __('validation.id.required'),
            'id.exists' => __('validation.id.exists'),
            'feedback_message.required' => __('validation.feedback_message.required'),
            'value.required' => __('validation.value.required'),
            'value.numeric' => __('validation.value.numeric'),
            'value.between' =>  __('validation.value.between'),
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
