<?php

namespace App\Rules;

use App\Http\Traits\LoggedInUserTrait;
use App\Models\ClientLocation;
use Illuminate\Contracts\Validation\Rule;

class IsLocationBelongToClientRule implements Rule
{
    use LoggedInUserTrait;
    protected $clientId;

    /**
     * Create a new rule instance.
     *
     * @param  mixed  $parameters
     * @return void
     */
    public function __construct($clientId = null)
    {
        $loggedInUser = $this->getLoggedInUser();
        if($loggedInUser->role == "client")
            $this->clientId = $loggedInUser->id;
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
        return ;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'This location Dosnt not Belong for this client';
    }
}
