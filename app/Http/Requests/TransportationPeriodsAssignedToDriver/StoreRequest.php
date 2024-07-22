<?php

namespace App\Http\Requests\TransportationPeriodsAssignedToDriver;

use App\Http\Traits\ResponsesTrait;
use App\Http\Traits\LoggedInUserTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Http\Services\Orders\TransportationPeriodsAssignedToDriversService;

class StoreRequest extends FormRequest
{
    use ResponsesTrait, LoggedInUserTrait;

    // protected $stopOnFirstFailure = true;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {

        // authorize user
        $transportationPeriodsAssignedToDriversService = new TransportationPeriodsAssignedToDriversService();

        return $transportationPeriodsAssignedToDriversService->canLoggedInUserAssignDriverToTransportationPeriod(request('driver_id'),request('transportation_period_id'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {


        return [

            'driver_id'                 => 'required|exists:drivers,user_id',
            'transportation_period_id'  => 'required|exists:transportation_periods,id',
            'capacity'                  =>  'required|numeric'
        ];
    }

    public function messages(): array
    {
        return [
            'driver_id.required' => __('vlaidation.id.required'),
            'driver_id.exists' => __('vlaidation.id.exists'),
            'transportation_period_id.required' => __('vlaidation.id.required'),
            'transportation_period_id.exists' => __('vlaidation.id.exists'),
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
