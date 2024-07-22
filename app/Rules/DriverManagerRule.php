<?php

namespace App\Rules;

use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Validation\Rule;
use App\Http\Traits\loggedInUserTrait;
class DriverManagerRule implements Rule
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
        $existsInDriversManagers = DB::table('drivers_managers')
            ->where('user_id', $value)
            ->exists();

        $existsInCompanies = DB::table('companies')
            ->where('user_id', $value)
            ->exists();
            return ($existsInCompanies||$existsInDriversManagers);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'This manager dosent exist';
    }
}
