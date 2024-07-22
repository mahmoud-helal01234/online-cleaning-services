<?php

namespace App\Rules;

use App\Http\Traits\loggedInUserTrait;
use Illuminate\Contracts\Validation\Rule;
use App\Http\Services\Users\ClientLocationsService;

class CanClientUpdateLocationRule implements Rule
{
    use loggedInUserTrait;
    protected $locationId;
    /**
     * Create a new rule instance.
     *
     * @param  mixed  $parameters
     * @return void
     */
    public function __construct($locationId)
    {
        $this->locationId = $locationId;
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
        $user = $this->getLoggedInUser();
        if ($user->role == 'admin'){
            return true;
        }else{
            $clientLocationsService = new ClientLocationsService();
            $clientLocation = $clientLocationsService->getById($this->locationId);
            if($value == $clientLocation->client_id)
                return true;
            return false;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'You are not allowed to update this client location to another client';
    }
}
