<?php

namespace App\Rules;

use App\Http\Traits\ResponsesTrait;
use App\Http\Traits\LoggedInUserTrait;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Http\Services\Orders\TransportationPeriodsAssignedToDriversService;

class CapacityOfTransportationPeriodAssignedToDriverRule implements Rule
{
    use ResponsesTrait, LoggedInUserTrait;
    protected $date;
    protected $companyId;
    /**
     * Create a new rule instance.
     *
     * @param  mixed  $parameters
     * @return void
     */
    public function __construct($date, $companyId)
    {
        $this->companyId = $companyId;
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
        $date = $this->date;
        $companyId = $this->companyId;

        $loggedInUser = $this->getLoggedInUser();
        if($loggedInUser->role != "admin")
            $companyId = $loggedInUser->id;

        $transportationPeriodAssignedToDriversService = new TransportationPeriodsAssignedToDriversService();
        $transportationPeriodAssignedToDrivers = $transportationPeriodAssignedToDriversService->getById($value);
        // dd($companyId);
        // if($transportationPeriodAssignedToDrivers->transportationPeriod->user_id != $companyId)
        //     throw new HttpResponseException($this->apiResponse(null, false, 'this transportation period is not assigned to this company'));

        $usedCapacity = $transportationPeriodAssignedToDriversService->transportationPeriodAssignedToDriverCapacityInDate($value, $date);

        return ($usedCapacity < $transportationPeriodAssignedToDrivers->capacity);

    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The driver Capacity is Full';
    }
}
