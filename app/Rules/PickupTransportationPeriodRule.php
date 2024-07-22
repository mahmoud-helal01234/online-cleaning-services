<?php

namespace App\Rules;

use Carbon\Carbon;
use App\Http\Traits\loggedInUserTrait;
use Illuminate\Contracts\Validation\Rule;
use App\Http\Services\Orders\TransportationPeriodsAssignedToDriversService;


class PickupTransportationPeriodRule implements Rule
{
    use loggedInUserTrait;
    protected $date;
    /**
     * Create a new rule instance.
     *
     * @param  mixed  $parameters
     * @return void
     */

    public function __construct($date)
    {
        $this->date = $date;
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
        $date = Carbon::parse($this->date);

        $transportationPeriodsAssignedToDriverSerivce = new TransportationPeriodsAssignedToDriversService();

        $pickupTransportationPeriod     = $transportationPeriodsAssignedToDriverSerivce->getById($value);
        $pickupTo                       = Carbon::parse($pickupTransportationPeriod->transportationPeriod->to);

        $pickupToTimeDate              = $date->setTime($pickupTo->hour, $pickupTo->minute);
        return now()->addHours(2)->isBefore($pickupToTimeDate);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Pickup transportation period must be 2 hours from now';
    }
}
