<?php

namespace App\Http\Requests\DriversManager;

use App\Http\Traits\ResponsesTrait;
use App\Http\Requests\User\UserStoreRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreRequest extends UserStoreRequest
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

        return array_merge($this->userRules,[

            'country_id' => 'required|exists:countries,id'
        ]);
    }

    public function messages(): array
    {

        return array_merge($this->userMessages,[
            'country_id.required'  =>  __('validation.id.required'),
            'country_id.exists'  =>  __('validation.id.exists')

        ]);
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
