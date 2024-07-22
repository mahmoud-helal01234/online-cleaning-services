<?php

namespace App\Http\Requests\Driver;

use App\Http\Traits\ResponsesTrait;
use App\Http\Traits\LoggedInUserTrait;
use App\Http\Requests\User\UserStoreRequest;
use App\Rules\DriverManagerRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreRequest extends UserStoreRequest
{
    use ResponsesTrait, LoggedInUserTrait;

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
        $user = $this->getLoggedInUser();

        $manager = ($user->role == "admin" || $user->role == "country_manager")
        ? ["manager_id" => ["required", "numeric", new DriverManagerRule]]
        : [];

        $rules = array_merge($this->userRules,$manager,[
            "capacity_per_hour"     =>  "sometimes|numeric"
        ]);
        //dd($rules);
        return $rules;
    }

    public function messages(): array
    {

        return array_merge($this->userMessages,[
            'manager_id.required'  =>  __('validation.id.required'),
            'capacity_per_hour.numeric'  =>  __('validation.capacity_per_hour.numeric'),
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
