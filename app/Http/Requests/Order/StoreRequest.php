<?php

namespace App\Http\Requests\Order;

use Carbon\Carbon;
use App\Http\Traits\ResponsesTrait;
use App\Http\Traits\LoggedInUserTrait;
use App\Http\Services\Orders\OrdersService;
use App\Rules\IsLocationBelongToClientRule;
use Illuminate\Foundation\Http\FormRequest;
use App\Rules\PickupTransportationPeriodRule;
use Illuminate\Contracts\Validation\Validator;
use App\Rules\PromoCodeForCompanyOrCountryRule;
use App\Rules\DeliveryTypeTransportionPeriodRule;
use App\Rules\IsProductOptionBelongToCompanyRule;
use App\Rules\IsDriversManagerWorkingWithCompanyRule;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Rules\CapacityOfTransportationPeriodAssignedToDriverRule;
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
    public function __construct()
    {

        $this->loggedInUser = $this->getLoggedInUser();
        $this->ordersService = new OrdersService();
    }
    private $loggedInUser;
    private $ordersService;

    public function authorize()
    {

        $transportationPeriodsAssignedToDriversService = new TransportationPeriodsAssignedToDriversService();
        switch(request('role')){

            case "client":
                // pickup_driver_assigned_to_transportation_period_id from same company or for one of drivers managers working with company
                if (request('pickup_driver_assigned_to_transportation_period_id') != null) {

                    if (!$transportationPeriodsAssignedToDriversService->isDriverBelongToChoosenCompanyOrDriversManagerWorkingWith(request('pickup_driver_assigned_to_transportation_period_id'), request('company_id')))
                        return false;
                }

                if (request('delivery_driver_assigned_to_transportation_period_id') != null) {

                    if (!$transportationPeriodsAssignedToDriversService->isDriverBelongToChoosenCompanyOrDriversManagerWorkingWith(request('delivery_driver_assigned_to_transportation_period_id'), request('company_id')))
                        return false;
                }
                ///// CHECK IF THE CHOOSEN COMPNAY COUNTRY IS IN THE CLIENT COUNTRY
                $this->ordersService->isChoosenCompanyCountryInClientCountry(companyId: request('company_id'),clientId: request('client_id'));

                    break;
            case "drivers_app":
                 // authorize user
                if (!$this->ordersService->canUserRoleCreateOrderRole($this->loggedInUser->role, request('role')))
                return false;


                if (request('pickup_driver_assigned_to_transportation_period_id') != null) {

                    if (!$transportationPeriodsAssignedToDriversService->canLoggedInUserAddOrderToDriverAssignedToTransportationPeriod(request('pickup_driver_assigned_to_transportation_period_id')))
                        return false;
                }

                if (request('delivery_driver_assigned_to_transportation_period_id') != null) {

                    if (!$transportationPeriodsAssignedToDriversService->canLoggedInUserAddOrderToDriverAssignedToTransportationPeriod(request('delivery_driver_assigned_to_transportation_period_id')))
                        return false;
                }

                if (request('drivers_manager_id')) {

                    $transportationPeriodsAssignedToDriversService = new TransportationPeriodsAssignedToDriversService();
                    return $transportationPeriodsAssignedToDriversService->canLoggedInUserAddOrderToDriversManagerId(request('drivers_manager_id'));
                }
                break;
        }
        if(!$this->ordersService->canUserRoleCreateOrderRole($this->loggedInUser->role , request('role')))
        return false;

        // authorize that pickup_driver_assigned_to_transportation_period
        // have valid transportation_period according to the requested company
        // and have valid driver working for it

        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        $rulesBasedOnType = [];

        switch (request('role')) {

                case "client":

                    $user = $this->getLoggedInUser();
                    switch($user->role){
                        case "admin":

                            $rulesBasedOnType['drivers_manager_id'] = ['sometimes', 'numeric', new IsDriversManagerWorkingWithCompanyRule(request('company_id'))];
                            $rulesBasedOnType['price'] = 'sometimes|numeric';
                            $rulesBasedOnType['discount_value'] = 'sometimes|nullable|numeric|max:99999';
                            $rulesBasedOnType['discount_value_type'] = (request('discount_value') != null ? 'required' : 'sometimes|nullable').'|string|in:constant,percentage';

                            break;
                        }
                    $rulesBasedOnType['client_id'] = 'required|exists:clients,id';
                    $rulesBasedOnType['client_location_id'] = ['required', new IsLocationBelongToClientRule(request('client_id'))];
                    $rulesBasedOnType['delivery_type_id'] = 'required|exists:delivery_types,id';
                    $rulesBasedOnType['company_id'] = 'required|exists:companies,user_id';
                    $rulesBasedOnType['promo_code'] = ['sometimes','exists:promo_codes,code', new PromoCodeForCompanyOrCountryRule(request('company_id'))];

                    // validate (choosen delivery transportation period and date - (pickup transportation period and date if set or (now() + 2 hours) if not set) in hours <= delivery type after_hours)
                        // 1- request transportation period assigned to driver for pickup and delivery
                        // 2- check if the delivery type has after_hours < period between (transportation period assigned to driver for pickup and delivery)
                        // 3- if 'transportation period assigned to driver for delivery' == null - check if 'transportation period assigned to driver for pickup' += 2 hours

                    $rulesBasedOnType['pickup_driver_assigned_to_transportation_period_id'] = [
                        'sometimes',
                        'numeric',
                        'exists:transportation_periods_assigned_to_drivers,id',
                        new PickupTransportationPeriodRule(request('pickup_date')),
                        new CapacityOfTransportationPeriodAssignedToDriverRule(request('pickup_date'), request('company_id'))];
                    $rulesBasedOnType['delivery_driver_assigned_to_transportation_period_id'] = [
                        'sometimes',
                        'numeric',
                        'exists:transportation_periods_assigned_to_drivers,id',
                        new DeliveryTypeTransportionPeriodRule(request('pickup_driver_assigned_to_transportation_period_id'), request('delivery_type_id'), request('pickup_date'), request('delivery_date')),
                        new CapacityOfTransportationPeriodAssignedToDriverRule(request('delivery_date'),request('company_id')),
                    ];// validate it exists for same company user ordered fron

                    // validate if same day and transportation period after now() + 2 hours
                    $rulesBasedOnType['pickup_date'] = (request('pickup_driver_assigned_to_transportation_period_id') != null ?
                    "required": "sometimes") . "|date_format:Y-m-d|after:" . Carbon::now()->subDay()->format('Y-m-d');
                    $rulesBasedOnType['delivery_date'] = (request('delivery_driver_assigned_to_transportation_period_id') != null ?
                    "required": "sometimes") . "|date_format:Y-m-d|after:" . Carbon::now()->subDay()->format('Y-m-d'). "|after_or_equal:".request('pickup_date');


                    // change hours (23) based on delivery type
                    // $rulesBasedOnType['delivery_start_date_time'] = "sometimes|nullable|date_format:Y-m-d H:i" . (request('pickup_start_date_time') ?
                    //     ("|after:" . Carbon::createFromFormat("Y-m-d H:i", request('pickup_start_date_time'))->addHours(23)->format("Y-m-d H:i")) : "");
                    // $rulesBasedOnType['delivery_end_date_time'] = (request('delivery_start_date_time') ? "required|after:" . Carbon::createFromFormat(
                    //     "Y-m-d H:i",
                    //     request('delivery_start_date_time')
                    // )->addHours(2) : "sometimes|nullable") . '|date_format:Y-m-d H:i';

                    break;

            case "drivers_app":

                $rulesBasedOnType['discount_value'] = 'sometimes|nullable|numeric|max:99999';
                $rulesBasedOnType['discount_value_type'] = (request('discount_value') != null ? 'required' : 'sometimes|nullable').'|string|in:constant,percentage';

                $rulesBasedOnType['delivery_type'] = 'required|in:normal,fast';
                $rulesBasedOnType['drivers_app_client_id'] = 'required|exists:drivers_app_clients,id';//,user_id,' . $this->loggedInUser->id;
                $rulesBasedOnType['pickup_date'] = (request('pickup_driver_assigned_to_transportation_period_id') != null ?
                 "required": "sometimes") . "|date_format:Y-m-d|after:" . Carbon::now()->subDay()->format('Y-m-d');
                $rulesBasedOnType['delivery_date'] = (request('delivery_driver_assigned_to_transportation_period_id') != null ?
                 "required": "sometimes") . "|date_format:Y-m-d|after:" . Carbon::now()->subDay()->format('Y-m-d');
                $rulesBasedOnType['delivery_driver_assigned_to_transportation_period_id'] = 'sometimes|numeric|exists:transportation_periods_assigned_to_drivers,id';
                $rulesBasedOnType['pickup_driver_assigned_to_transportation_period_id'] = 'sometimes|numeric|exists:transportation_periods_assigned_to_drivers,id';
                break;
        }

        switch (request('type')) {
            case "easy":


                $rulesBasedOnType['content'] = 'required|string|max:500';

                break;
            case "items":
                switch (request('role')) {
                    case "client":
                        $rulesBasedOnType = array_merge($rulesBasedOnType, [

                            'items' => 'required|array',
                            'items.*.product_option_id' => [new IsProductOptionBelongToCompanyRule(request('company_id')), "required", "exists:product_options,id"],
                            'items.*.quantity' => 'required|integer|min:1',
                        ]);
                        break;
                    case "drivers_app":
                        $rulesBasedOnType = array_merge($rulesBasedOnType, [

                            'items' => 'sometimes|array',
                            'items.*.name' => 'required|string|max:100',
                            'items.*.quantity' => 'required|integer|min:1',
                            'items.*.price' => 'required|numeric|min:0'
                        ]);
                        break;
                }

                break;
        }

        return array_merge(
            [

                'price' => 'sometimes|nullable|numeric',
                'role' => 'required|in:client,drivers_app',
                'type' => 'required|in:items,easy',
                'discount_value' => 'sometimes|nullable|numeric',
                'discount_value_type' => 'sometimes|nullable|in:constant,percentage',
                'special_instructions' => 'sometimes|nullable|string|max:500',
                'comment' => 'sometimes|nullable|string|max:200',

            ],
            $rulesBasedOnType

        );
    }

    public function messages(): array
    {

        return [];
    }

    public function failedValidation(Validator $validator)
    {

        throw new HttpResponseException($this->apiResponse(null, false, $validator->errors()->first()));
    }

    public function failedAuthorization()
    {

        throw new HttpResponseException($this->apiResponse(null, false, "not authorized to access this"));
    }
}
