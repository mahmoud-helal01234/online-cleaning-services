<?php

namespace App\Rules;

use Carbon\Carbon;
use App\Http\Traits\LoggedInUserTrait;
use Illuminate\Contracts\Validation\Rule;
use App\Http\Services\Orders\ClientOrdersService;

class IsOrderBelongToCompanyRule implements Rule
{
    use LoggedInUserTrait;

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
        $user = $this->getLoggedInUser();
        $clientOrdersService = new ClientOrdersService();
       // $clientOrder = $clientOrdersService->get($value);

        if($user->role == 'company')
            return $clientOrdersService->getById($value)->company_id == $user->id;
        else if($user->role == 'admin')
            return true;
        else
            return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'This Order does not belong to your company';
    }
}
