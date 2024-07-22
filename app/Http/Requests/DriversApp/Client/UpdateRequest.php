<?php

namespace App\Http\Requests\DriversApp\Client;

use App\Http\Traits\ResponsesTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use App\Http\Services\DriversApp\ClientsService;
use App\Http\Traits\LoggedInUserTrait;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateRequest extends FormRequest
{

    use ResponsesTrait,LoggedInUserTrait;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {


        $driversAppClientsService = new ClientsService();
        return $driversAppClientsService->canUserUpdateClient($this->getLoggedInUser(),request('id'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {

        return [

            'id'        => 'required|numeric|exists:drivers_app_clients,id',
            'name'      => "sometimes|nullable|string",
            'address'   => 'sometimes|nullable|string',
            'phone'     => 'sometimes|nullable|string|max:20',
            'long'      => (request('lat') != null ? 'required':'sometimes') . '|numeric',
            'lat'       => (request('long') != null ? 'required':'sometimes') . '|numeric'
        ];
    }

    public function messages(): array {

        return [
            'id.required' => __('validation.id.required'),
            'id.exists' => __('validation.id.exists'),

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
