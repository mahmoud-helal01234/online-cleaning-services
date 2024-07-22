<?php

namespace App\Rules;

use Carbon\Carbon;
use App\Http\Traits\loggedInUserTrait;
use Illuminate\Contracts\Validation\Rule;
use App\Http\Services\Orders\DeliveryTypesService;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Http\Services\Orders\TransportationPeriodsAssignedToDriversService;

class DeliveryTypeTransportionPeriodRule implements Rule
{
    use loggedInUserTrait;

    /**
     * Create a new rule instance.
     *
     * @param  mixed  $parameters
     * @return void
     */
    protected $pickupTransportationPeriodId;
    protected $deliveryTypeId;
    protected $pickupDate;
    protected $deliveryDate;
    private $transportationPeriodsAssignedToDriver;
    private $deliveryTypeService;
    public function __construct($pickupTransportationPeriodId, $deliveryTypeId, $pickupDate, $deliveryDate)
    {

        $this->pickupTransportationPeriodId             = $pickupTransportationPeriodId;
        $this->deliveryTypeId                           = $deliveryTypeId;
        $this->pickupDate                               = $pickupDate;
        $this->deliveryDate                             = $deliveryDate;
        $this->transportationPeriodsAssignedToDriver    = new TransportationPeriodsAssignedToDriversService();
        $this->deliveryTypeService                      = new DeliveryTypesService();
    }


    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $deliveryTransportationPeriod   = $this->transportationPeriodsAssignedToDriver->getById($value);
        $deliveryto                     = Carbon::parse($deliveryTransportationPeriod->transportationPeriod->to);

        $deliveryType                   = $this->deliveryTypeService->getById($this->deliveryTypeId);
        $afterHours                     = $deliveryType->after_hours;

        $pickupDate                     = Carbon::parse($this->pickupDate);
        $deliveryDate                   = Carbon::parse($this->deliveryDate);

        $deliveryDateTime               = $deliveryDate->setTime($deliveryto->hour, $deliveryto->minute);

        if($this->pickupTransportationPeriodId == null){
            $pickupTo = now()->addHours(2);
        }else{
            $pickupTransportationPeriod     = $this->transportationPeriodsAssignedToDriver->getById($this->pickupTransportationPeriodId);
            $pickupTo                       = Carbon::parse($pickupTransportationPeriod->transportationPeriod->to);
            $pickupDateTime                 = $pickupDate->setTime($pickupTo->hour, $pickupTo->minute);
        }
        // should take care of the time structure "24 hours" or "12 hours"
        return ($pickupDateTime->copy()->addHours($afterHours))->lessThan($deliveryDateTime);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'the delivery type has after_hours < period between (pickup and delivery)';
    }
}
