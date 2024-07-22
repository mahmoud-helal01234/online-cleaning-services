<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Http\Services\Orders\ClientOrdersService;

class IsOrderForThisClientRule implements Rule
{

    protected $clientId;

    /**
     * Create a new rule instance.
     *
     * @param  mixed  $parameters
     * @return void
     */
    public function __construct($clientId = null)
    {
        $this->clientId = $clientId;

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
        if($this->clientId == null)
            return true;
        $clientOrdersService = new ClientOrdersService();
        $clientOrder = $clientOrdersService->getById($value);
        return $clientOrder->client_id == $this->clientId;

    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'this order doesnt belong to this client';
    }
}
