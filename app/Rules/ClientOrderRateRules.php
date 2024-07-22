<?php

namespace App\Rules;

use App\Models\ClientOrder;
use App\Http\Traits\loggedInUserTrait;
use Illuminate\Contracts\Validation\Rule;

class ClientOrderRateRules implements Rule
{
    use loggedInUserTrait;

    /**
     * Create a new rule instance.
     *
     * @param  mixed  $parameters
     * @return void
     */
    public function __construct()
    {

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
        $loggedInUser = $this->getLoggedInUser();
        return ClientOrder::where('client_id', $loggedInUser->id)
            ->whereHas('order', function ($query) {
                $query->where('status', 'done');
            })
            ->where('order_id', $value)
            ->exists();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Order status must be done';
    }
}
