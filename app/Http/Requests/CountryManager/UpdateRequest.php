<?php

namespace App\Http\Requests\CountryManager;

use App\Http\Traits\ResponsesTrait;
use App\Http\Requests\User\UserUpdateRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateRequest extends UserUpdateRequest
{
    use ResponsesTrait;
    public function __construct()
    {

        parent::__construct(request('id'));
    }
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {

        return parent::authorize();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {

        return array_merge($this->userRules, [
            'id'                => 'required|numeric', // checked for existence in constructor
            'country_id'    =>  'required|numeric|exists:countries,id'
        ]);
    }

    public function messages(): array
    {

        return array_merge($this->userMessages, [
            'id.required'  => __('validation.id.required'),
            'id.exists'  => __('validation.id.exists'),
            'country_id.required'  => __('validation.id.required'),
            'country_id.exists'  => __('validation.id.exists'),
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
