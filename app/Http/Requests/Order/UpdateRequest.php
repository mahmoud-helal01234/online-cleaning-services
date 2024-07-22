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
use App\Rules\IsDriversManagerWorkingWithCompanyRule;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Rules\CapacityOfTransportationPeriodAssignedToDriverRule;
use App\Http\Services\Orders\TransportationPeriodsAssignedToDriversService;

class UpdateRequest extends FormRequest
{

    use ResponsesTrait, LoggedInUserTrait;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    private $loggedInUser;
    private $ordersService;

    public function __construct()
    {

        $this->loggedInUser = $this->getLoggedInUser();
        $this->ordersService = new OrdersService();

    }

    public function authorize()
    {
        $user = $this->loggedInUser;
        $order = $this->ordersService->getById(request('id'));


        $transportationPeriodsAssignedToDriversService = new TransportationPeriodsAssignedToDriversService();
        switch (request('role')) {
            case "client":
                // pickup_driver_assigned_to_transportation_period_id from same company or for one of drivers managers working with company
                if (request('pickup_driver_assigned_to_transportation_period_id') != null) {

                    if (!$transportationPeriodsAssignedToDriversService->isDriverBelongToChoosenCompanyOrDriversManagerWorkingWith(request('pickup_driver_assigned_to_transportation_period_id'), $order->clientOrder->company_id))
                        return false;
                }

                if (request('delivery_driver_assigned_to_transportation_period_id') != null) {

                    if (!$transportationPeriodsAssignedToDriversService->isDriverBelongToChoosenCompanyOrDriversManagerWorkingWith(request('delivery_driver_assigned_to_transportation_period_id'), $order->clientOrder->company_id))
                        return false;
                }
                 ///// CHECK IF THE CHOOSEN COMPNAY COUNTRY IS IN THE CLIENT COUNTRY
                $this->ordersService->isChoosenCompanyCountryInClientCountry(companyId: $order->clientOrder->company_id, clientId: $order->clientOrder->client_id);


                break;

            case "drivers_app":

                if (!$this->ordersService->canUserUpdateOrder($user, $order))
                    return false;


                if (request('pickup_driver_assigned_to_transportation_period_id') != null) {

                    if (!$transportationPeriodsAssignedToDriversService->canLoggedInUserAddOrderToDriverAssignedToTransportationPeriod(request('pickup_driver_assigned_to_transportation_period_id')))
                        return false;
                }

                if (request('delivery_driver_assigned_to_transportation_period_id') != null) {

                    if (!$transportationPeriodsAssignedToDriversService->canLoggedInUserAddOrderToDriverAssignedToTransportationPeriod(request('delivery_driver_assigned_to_transportation_period_id')))
                        return false;
                }

                if (request('drivers_manager_id') != null) {

                    return $transportationPeriodsAssignedToDriversService->canLoggedInUserAddOrderToDriversManagerId(request('drivers_manager_id'));
                }
                break;


        }
        if(!$this->ordersService->canUserRoleUpdateOrderRole($this->loggedInUser->role , request('role')))
            return false;
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $order = $this->ordersService->getById(request('id'));
        $rulesBasedOnType = [];

        switch ($order->role) {

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
                    $rulesBasedOnType['client_location_id'] = ['required', new IsLocationBelongToClientRule($order->clientOrder->client_id)];
                    $rulesBasedOnType['delivery_type_id'] = 'required|exists:delivery_types,id';
                    $rulesBasedOnType['promo_code'] = ['sometimes','exists:promo_codes,code', new PromoCodeForCompanyOrCountryRule(request('company_id'))];

                    $rulesBasedOnType['pickup_driver_assigned_to_transportation_period_id'] = [
                        'sometimes',
                        'numeric',
                        'exists:transportation_periods_assigned_to_drivers,id',
                        new PickupTransportationPeriodRule(request('pickup_date')),
                        new CapacityOfTransportationPeriodAssignedToDriverRule(request('pickup_date'), $order->clientOrder->company_id)];
                    $rulesBasedOnType['delivery_driver_assigned_to_transportation_period_id'] = [
                        'sometimes',
                        'numeric',
                        'exists:transportation_periods_assigned_to_drivers,id',
                        new DeliveryTypeTransportionPeriodRule(request('pickup_driver_assigned_to_transportation_period_id'), request('delivery_type_id'), request('pickup_date'), request('delivery_date')),
                        new CapacityOfTransportationPeriodAssignedToDriverRule(request('delivery_date'),$order->clientOrder->company_id)];

                    $rulesBasedOnType['pickup_date'] = (request('pickup_driver_assigned_to_transportation_period_id') != null ?
                    "required": "sometimes") . "|date_format:Y-m-d";
                    $rulesBasedOnType['delivery_date'] = (request('delivery_driver_assigned_to_transportation_period_id') != null ?
                    "required": "sometimes") . "|date_format:Y-m-d|after_or_equal:".request('pickup_date');



                break;

            case "drivers_app":

                $rulesBasedOnType['pickup_date'] = (request('pickup_driver_assigned_to_transportation_period_id') != null ?
                    "required" : "sometimes") . "|date_format:Y-m-d";
                $rulesBasedOnType['delivery_date'] = (request('delivery_driver_assigned_to_transportation_period_id') != null ?
                "required" : "sometimes") . "|date_format:Y-m-d";

                $rulesBasedOnType['delivery_type'] = 'sometimes|nullable|in:normal,fast';
                $rulesBasedOnType['drivers_app_client_id'] = 'required|exists:drivers_app_clients,id,user_id,' . $this->loggedInUser->id;
                $rulesBasedOnType['delivery_driver_assigned_to_transportation_period_id'] = 'sometimes|nullable|numeric';
                $rulesBasedOnType['pickup_driver_assigned_to_transportation_period_id'] = 'sometimes|nullable|numeric';
                break;

                 // $pickupDateRules = (request('pickup_driver_assigned_to_transportation_period_id') != null ? "required": "sometimes") . "|date_format:Y-m-d|";
                    // $pickupDateRules .= "after_or_equal:" . date('Y-m-d', strtotime($order->pickup_date));
                    // $pickupDateRules .= "|before_or_equal:" . date('Y-m-d', strtotime($order->pickup_date . ' -7 days'));
                    // $rulesBasedOnType['pickup_date'] = $pickupDateRules;

                    // $deliveryDateRules = (request('delivery_driver_assigned_to_transportation_period_id') != null ? "required": "sometimes") . "|date_format:Y-m-d|";
                    // $deliveryDateRules .= "after_or_equal:" . date('Y-m-d', strtotime($order->delivery_date));
                    // $deliveryDateRules .= "|before_or_equal:" . date('Y-m-d', strtotime($order->delivery_date . ' -7 days'));
                    // $rulesBasedOnType['delivery_date'] = $deliveryDateRules;
        }

        switch ($order->type) {
                case "easy":
                        $rulesBasedOnType['content'] = 'required|string|max:500';
                        break;
            case "items":
                switch ($order->role) {
                    case "client":
                        $rulesBasedOnType = array_merge($rulesBasedOnType, [

                            'items' => 'required|array',
                            'items.*.product_option_id' => 'required|exists:product_options,id',
                            'items.*.quantity' => 'required|integer|min:1',
                        ]);
                        break;
                    case "drivers_app":
                        $rulesBasedOnType = array_merge($rulesBasedOnType, [

                            'items' => 'sometimes|nullable|array',
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
                'id' => 'required|exists:orders,id',
                'price' => 'sometimes|nullable|numeric',
                'role' => 'required|in:client,drivers_app',
                'status' => 'sometimes|nullable|in:in_cart,in_waiting_list,confirmed,in_picking,picked_up,in_processing,processing_done,in_delivery,delivered,done',
                'discount_value' => 'sometimes|nullable|numeric',
                'discount_value_type' => 'sometimes|nullable|in:constant,percentage',
                'special_instructions' => 'sometimes|nullable|string',
                'comment' => 'sometimes|nullable|string',
            ],
            $rulesBasedOnType

        );



        // case "client":

        //     $rulesBasedOnType['status'] = 'required|in:in_cart,in_waiting_list,confirmed,
        //     in_picking,picked_up,in_processing,processing_done,in_delivery,delivered,done';
        //     if($this->loggedInUser == "admin"){

        //         $rulesBasedOnType['company_id']         = 'required|exists:companies,user_id';
        //     }

        //     $rulesBasedOnType['delivery_type_id']   = 'required|exists:delivery_types,id';
        //     $rulesBasedOnType['pickup_driver_id']   = 'required|exists:drivers,user_id';
        //     $rulesBasedOnType['delivery_driver_id'] = 'required|exists:drivers,user_id';
        //     break;

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
