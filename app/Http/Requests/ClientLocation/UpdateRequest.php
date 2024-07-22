<?php

namespace App\Http\Requests\ClientLocation;

use App\Http\Traits\ResponsesTrait;
use App\Http\Traits\LoggedInUserTrait;
use App\Rules\CanClientUpdateLocationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use App\Http\Services\Users\ClientLocationsService;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateRequest extends FormRequest
{

    use ResponsesTrait, LoggedInUserTrait;
    protected $user;
    public function __construct() {
        $this->user = $this->getLoggedInUser();
    }
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user =$this->user;
        $clientLocationsService = new ClientLocationsService();
        $clientLocation = $clientLocationsService->getById(request('id'));
        if($user->id == $clientLocation->client_id || $user->role == 'admin')
            return true;
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {

        return [
            'client_id'                 =>  [$this->user->role == 'admin' ? ['required','exists:clients,id']: new CanClientUpdateLocationRule(request('id'))],
            'id'                        =>  'required|exists:client_locations,id',
            'lat'                       =>  'sometimes|nullable|numeric|between:-90.00000000,90.00000000',
            'long'                      =>  "sometimes|nullable|numeric|between:-180.00000000,180.00000000",
            'phone_number'              =>  "sometimes|nullable|string|max:20",
            'location_type'             =>  "sometimes|nullable|in:apartment,office,house",
            'street'                    =>  "sometimes|nullable|string|max:30",
            'building'                  =>  "sometimes|nullable|string|max:10",
            'floor'                     =>  "sometimes|nullable|string|max:10",
            'apartment'                 =>  "sometimes|nullable|string|max:10",
            'detailed_address'          =>  "sometimes|nullable|string|max:200",
            'additional_instructions'   =>  "sometimes|nullable|string|max:200",
            'telephone'                 =>  "sometimes|nullable|string|max:20"
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
