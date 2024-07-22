<?php

namespace App\Http\Requests\Driver;

use App\Rules\DriverManagerRule;
use App\Http\Traits\ResponsesTrait;
use App\Http\Requests\User\UserUpdateRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateRequest extends UserUpdateRequest
{
    public function __construct( )
    {

        parent::__construct(request('id'));
    }
    use ResponsesTrait;
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
        $user = $this->getLoggedinUser();

        $manager = ($user->role == "admin" || $user->role == "country_manager")
        ? ["manager_id" => ["required", "numeric", new DriverManagerRule]]
        : [];

        return array_merge($this->userRules,$manager,[

        'id'                    =>  'required|numeric', // checked for existence in constructor
        "capacity_per_hour"     =>  "sometimes|numeric"

        ]);

    }
    public function messages(): array
    {

        return array_merge($this->userMessages,[
            'manager_id.required'  =>  __('validation.id.required'),
            'id.required'  =>  __('validation.id.required'),
            'id.exists'  =>  __('validation.id.exists'),
            'capacity_per_hour.numeric'  =>  __('validation.capacity_per_hour.numeric'),
        ]);
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
