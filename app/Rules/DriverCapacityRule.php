<?php

namespace App\Rules;

use App\Http\Services\Orders\OrdersService;
use Illuminate\Contracts\Validation\Rule;
use Carbon\Carbon;

class DriverCapacityRule implements Rule
{

    protected $startTime, $endTime;

    /**
     * Create a new rule instance.
     *
     * @param  mixed  $parameters
     * @return void
     */
    public function __construct($startTime, $endTime)
    {
        $this->startTime = $startTime;
        $this->endTime = $endTime;
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

        if ($this->startTime == null || $this->endTime == null)
            return true;

        $this->startTime = Carbon::createFromFormat(
            "Y-m-d H:i",
            $this->startTime
        );

        $this->endTime = Carbon::createFromFormat(
            "Y-m-d H:i",
            $this->endTime
        );

        // $this->endTime = $this->endTime->setDate($this->startTime->year,$this->startTime->month,$this->startTime->day);

        // if ($this->startTime->gt($this->endTime))
        //     $this->endTime = $this->endTime->addDay();


        $driverCapacity = $this->startTime->diffInHours($this->endTime) * 2; // driver can make just 2 orders per hour

        $ordersService = new OrdersService();
        return $driverCapacity > $ordersService->getOrdersNumBetweenTwoTimesForDriver($value,
        $this->startTime->format('Y-m-d H:i'),$this->endTime->format('Y-m-d H:i'));

    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The driver is not empty in the specified time';
    }
}
