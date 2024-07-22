<?php

namespace App\Rules;

use Carbon\Carbon;
use App\Models\PromoCode;
use Illuminate\Support\Facades\DB;
use App\Http\Traits\loggedInUserTrait;
use Illuminate\Contracts\Validation\Rule;
use App\Http\Services\Users\CompaniesService;
use App\Http\Services\Offers\PromoCodesService;
use Illuminate\Http\Exceptions\HttpResponseException;

class PromoCodeForCompanyOrCountryRule implements Rule
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
        $promoCode = PromoCode::where('code', $value)->first();
        if (!$promoCode)
             throw new HttpResponseException($this->apiResponse(null, false, "invalid promo code"));

        $promoCodeFrom = Carbon::parse($promoCode->from);
        $promoCodeTo = Carbon::parse($promoCode->to);

        if ($promoCodeFrom->lte(now()) && $promoCodeTo->gte(now())) {

            if($promoCode->type == "companies"){
                return DB::table('promo_codes_companies')->where('promo_code_id', $promoCode->id)->where('company_id', $companyId)->exists();
            }elseif($promoCode->type == "countries"){
                $companiesServices = new CompaniesService();
                $company = $companiesServices->getById($companyId);
                return DB::table('promo_codes_countries')->where('promo_code_id', $promoCode->id)->where('country_id', $company->country_id)->exists();
            }else{
                return false;
            }
        }else
            return false;



    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'This promo code does not belong to this company or country';
    }
}
