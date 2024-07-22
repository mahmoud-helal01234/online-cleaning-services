<?php

namespace App\Http\Requests\User;

use App\Http\Traits\ResponsesTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserStoreRequest extends FormRequest
{

    use ResponsesTrait;

    protected $userRules;

    protected $userMessages;

    public function __construct()
    {
        $this->userRules = [
            'name'      => 'required|string',
            'email'     => 'required|email|unique:users,email',
            'phone'     => 'required|string|min:10|max:15|unique:users,phone',
            'password'  => 'required|string',
        ];

        $this->userMessages = [
            'email.unique'  => __('validation.distinct'),
            'phone.unique'  => __('validation.distinct'),
        ];
    }

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

        return $this->userRules;
    }

    public function messages(): array {

        return [

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
