<?php

namespace App\Http\Requests\TransportationPeriod;

use App\Http\Traits\ResponsesTrait;
use App\Http\Traits\LoggedInUserTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use App\Http\Services\Orders\TransportationPeriodsService;
use Illuminate\Http\Exceptions\HttpResponseException;

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
        $transportationPeriodsService = new TransportationPeriodsService();

        return $transportationPeriodsService->canUserIdHaveTransportationPeriod(request('user_id')) && $transportationPeriodsService->canLoggedInUserAddTransortationPeriodToUserId(request('user_id'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rulesBasedOnRole = [];
        switch ($this->getLoggedInUserRole()) {

            case "admin":
            case "country_manager":
                $rulesBasedOnRole['user_id'] = 'required';
                break;
        }

        return [

            'from' => 'required|date_format:H:i',
            'to' => 'required|date_format:H:i',
            ...$rulesBasedOnRole
            // and may check if role for user_id is company or drivers_manager
        ];
    }

    public function messages(): array
    {
        return [
            'user_id.required' => __('vlaidation.id.required'),
            'user_id.exists' => __('vlaidation.id.exists'),
            'from.required' => __('vlaidation.from.required'),
            'to.required' => __('vlaidation.to.required'),
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
