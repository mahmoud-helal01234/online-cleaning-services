<?php

namespace App\Http\Requests\TransportationPeriodsAssignedToDriver;

use App\Http\Traits\ResponsesTrait;
use App\Http\Traits\LoggedInUserTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Http\Services\Orders\TransportationPeriodsAssignedToDriversService;

class UpdateRequest extends FormRequest
{
    use ResponsesTrait, LoggedInUserTrait;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {

        $transportationPeriodsAssignedToDriversService = new TransportationPeriodsAssignedToDriversService();

        return $transportationPeriodsAssignedToDriversService->canLoggedInUserUpdateDriverAssignedToTransportationPeriod($transportationPeriodsAssignedToDriversService->getById(request('id')));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [

            'id' => 'required', // checked in authorize
            'capacity' => 'required|numeric'
        ];
    }

    public function messages(): array
    {
        return [
            'id.required' => __('vlaidation.id.required'),
            'id.exists' => __('vlaidation.id.exists'),
            'capacity.required' => __('vlaidation.capacity.required'),
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
