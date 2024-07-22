<?php

namespace App\Rules;

use App\Models\ProductOption;
use App\Http\Traits\loggedInUserTrait;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Http\Exceptions\HttpResponseException;

class IsProductOptionBelongToCompanyRule implements Rule
{
    use loggedInUserTrait;
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
        $productOptionIds = is_array($value) ? $value : [$value];

        foreach ($productOptionIds as $optionId) {
            $productOption = ProductOption::with('product')->where('id', $optionId)->first();

            if (!$productOption || $productOption->product->company_id != $companyId) {
                return false;
            }
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'This product options does not belong to this company';
    }
}
