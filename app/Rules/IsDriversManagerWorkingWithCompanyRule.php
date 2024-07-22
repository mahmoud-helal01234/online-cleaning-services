<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Http\Services\Users\DriversManagersService;
use App\Http\Services\Orders\CompaniesWorkingWithDriverManagersService;

class IsDriversManagerWorkingWithCompanyRule implements Rule
{

    protected $companyId;

    /**
     * Create a new rule instance.
     *
     * @param  mixed  $parameters
     * @return void
     */
    public function __construct($companyId)
    {
        $this->companyId = $companyId;
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
        $companyId = $this->companyId;

        $driversManagerService = new DriversManagersService();
        $driversManager = $driversManagerService->getById($value);

        $companiesWorkingWithDriverManagersService = new CompaniesWorkingWithDriverManagersService();


        return ($driversManager->id == $companyId || $companiesWorkingWithDriverManagersService->isDriversManagerWorkingWithCompany(driversManagerId:$driversManager->user_id,companyId:$companyId));
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'This Drivers manager dosnt not working with this comapny';
    }
}
