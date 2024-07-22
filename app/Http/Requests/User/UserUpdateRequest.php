<?php

namespace App\Http\Requests\User;

use App\Http\Traits\ResponsesTrait;
use App\Http\Traits\LoggedInUserTrait;
use App\Http\Services\Users\UsersService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserUpdateRequest extends FormRequest
{

    use ResponsesTrait,LoggedInUserTrait;

    protected $userRules;

    protected $userMessages;

    protected $userId;

    public function __construct($userId = null)
    {

        $userId ??= request('id');
         $this->userRules = [

            'name'      =>  'sometimes|nullable|max:255',
            'phone'     =>  'sometimes|nullable|min:10|max:15|unique:users,phone,' . $userId,
            'email'     =>  'sometimes|nullable|email|max:255|unique:users,email,' . $userId,
            'password'  =>  'sometimes|nullable|string|min:4',
            'active'    =>  'sometimes|in:0,1'
        ];

        $this->userMessages = [
            'email.unique'  => __('validation.distinct'),
            'phone.unique'  => __('validation.distinct'),
        ] ;
    }
    // protected $stopOnFirstFailure = true;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {

        // authorize user
        $usersService = new UsersService();
        return $usersService->canUserEditUser($this->getLoggedInUser(), request('id'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        return array_merge(['id' => 'required|numeric|exists:users,id'],$this->userRules);
    }

    public function messages(): array {

        return $this->userMessages;
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



