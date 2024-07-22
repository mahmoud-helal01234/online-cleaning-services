<?php

namespace App\Http\Requests\DriversApp\Client;

use App\Http\Traits\ResponsesTrait;
use App\Http\Traits\LoggedInUserTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use App\Http\Services\DriversApp\ClientsService;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreRequest extends FormRequest
{
    use ResponsesTrait,LoggedInUserTrait;

    private $loggedInUser;
    private $clientsService;
    public function __construct()
    {

        $this->loggedInUser = $this->getLoggedInUser();
        $this->clientsService = new ClientsService();
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

        return [

            'name'          =>  "sometimes|string",
            'address'       => 'sometimes|string',
            'phone'         => 'sometimes|string|max:20',
            'long'          => (request('lat') != null ? 'required':'sometimes') . '|numeric',
            'lat'           => (request('long') != null ? 'required':'sometimes') . '|numeric'
        ];
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



