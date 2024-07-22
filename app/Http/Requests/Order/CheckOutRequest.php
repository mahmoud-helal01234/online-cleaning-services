<?php

namespace App\Http\Requests\Order;

use Carbon\Carbon;
use App\Http\Traits\ResponsesTrait;
use App\Rules\IsLocationBelongToClientRule;
use Illuminate\Foundation\Http\FormRequest;
use App\Rules\PickupTransportationPeriodRule;
use Illuminate\Contracts\Validation\Validator;
use App\Rules\PromoCodeForCompanyOrCountryRule;
use App\Http\Services\Orders\ClientOrdersService;
use App\Rules\DeliveryTypeTransportionPeriodRule;
use App\Rules\IsProductOptionBelongToCompanyRule;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Rules\CapacityOfTransportationPeriodAssignedToDriverRule;

class CheckOutRequest extends FormRequest
{
    use ResponsesTrait;
    private $clientOrderService;
    public function __construct()
    {
        $this->clientOrderService = new ClientOrdersService();
    }


    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->clientOrderService->canClientCheckout(request('order_id'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        return
            [
                // client order table fields
                'client_id' => 'required|exists:clients,id',
                'client_location_id' => ['required', new IsLocationBelongToClientRule(request('client_id'))],
                'delivery_type_id' => 'required|exists:delivery_types,id',
                'company_id' => 'required|exists:companies,user_id',
                'promo_code' => ['sometimes','exists:promo_codes,code', new PromoCodeForCompanyOrCountryRule(request('company_id'))],

                // order items table fields
                'items' => 'required|array',
                'items.*.product_option_id' => ["required" , "numeric", "exists:product_options,id", new IsProductOptionBelongToCompanyRule(request('company_id'))],
                'items.*.quantity' => 'required|integer|min:1',

                // order table fields
                "order_id" => 'required|numeric|exists:orders,id',
                'special_instructions' => 'sometimes|nullable|string|max:500',

                'pickup_driver_assigned_to_transportation_period_id' =>  [
                    'sometimes',
                    'numeric',
                    'exists:transportation_periods_assigned_to_drivers,id',
                    new PickupTransportationPeriodRule(request('pickup_date')),
                    new CapacityOfTransportationPeriodAssignedToDriverRule(request('pickup_date'), request('company_id'))],
                // 'delivery_driver_assigned_to_transportation_period_id' => [
                //     'sometimes',
                //     'numeric',
                //     'exists:transportation_periods_assigned_to_drivers,id',
                //     new DeliveryTypeTransportionPeriodRule(request('pickup_driver_assigned_to_transportation_period_id'), request('delivery_type_id'), request('pickup_date'), request('delivery_date')),
                //     new CapacityOfTransportationPeriodAssignedToDriverRule(request('delivery_date'),request('company_id')),
                // ],
                'pickup_date' => (request('pickup_driver_assigned_to_transportation_period_id') != null ?
                "required": "sometimes") . "|date_format:Y-m-d|after:" . Carbon::now()->subDay()->format('Y-m-d'),

                'delivery_date' => (request('delivery_driver_assigned_to_transportation_period_id') != null ?
                "required": "sometimes") . "|date_format:Y-m-d|after:" . Carbon::now()->subDay()->format('Y-m-d'). "|after_or_equal:".request('pickup_date'),


            ];
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
