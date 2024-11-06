<?php

namespace App\Http\Services\Offers;

use App\Http\Services\Users\CompaniesService;
use App\Models\PromoCode;
use Illuminate\Support\Facades\DB;
use App\Http\Traits\ResponsesTrait;
use App\Http\Traits\LoggedInUserTrait;
use Illuminate\Http\Exceptions\HttpResponseException;

class PromoCodesService
{

    use ResponsesTrait;
    use LoggedInUserTrait;

    public function get($id = null, $active = null)
    {

        $loggedInUser = $this->getLoggedInUser();
        if ($loggedInUser != null) {
            if ($loggedInUser->role == "admin") {
                if ($id) {

                    $data['promo_code'] = $this->getById($id);
                    $data['promo_code'][$data['promo_code']['type']] = $this->getPromoCodeWorkingOnElements($id, $data['promo_code']['type']);
                    $data[$data['promo_code']['type']] = $this->getPromoCodeNotWorkingOnElements($id, $data['promo_code']['type'], $data['promo_code'][$data['promo_code']['type']]);
                    return $data;
                }
            }
        }
        $data = PromoCode::with(['countries', 'companies'])->when($active != null, function ($query) use ($active) {

            $query->where('active', $active);
        })->orderBy('created_at', 'DESC')->get();

        return $data;
    }

    public function getPromoCodeWorkingOnElements($id, $type)
    {

        switch ($type) {

            case "countries":

                return DB::table('countries')->join('promo_codes_countries', 'country_id', '=', 'countries.id')->select('name_en', 'name_ar', 'country_id as id')->get();
            case "companies":

                return DB::table('companies')->join('promo_codes_companies', 'company_id', '=', 'companies.user_id')->select('name_en', 'name_ar', 'company_id as id')->get();

            case "products":

                return DB::table('products')->join('promo_codes_products', 'product_id', '=', 'products.id')->select('name_en', 'name_ar', 'product_id as id')->get();
        }
    }

    public function getPromoCodeNotWorkingOnElements($id, $type, $promoCodeWorkingOnElements)
    {

        switch ($type) {

            case "countries":

                $countriesIds = $promoCodeWorkingOnElements->pluck('id')->toArray();
                return DB::table('countries')->whereNotIn('id', $countriesIds)->select('name_en', 'name_ar', 'id')->get();
            case "companies":

                $companiesIds = $promoCodeWorkingOnElements->pluck('id')->toArray();
                return $data['companies'] = DB::table('companies')->whereNotIn('id', $companiesIds)->select('name_en', 'name_ar', 'id')->get();

            case "products":

                $productsIds = $promoCodeWorkingOnElements->pluck('id')->toArray();
                return DB::table('products')->whereNotIn('id', $productsIds)->select('name_en', 'name_ar', 'id')->get();
        }
    }
    public function selectPromoCodes($companyId)
    {

        $companiesService = new CompaniesService();
        $countryId = $companiesService->getById($companyId)->country_id;
        $promoCodes = PromoCode::whereHas('companies', function ($query) use ($companyId) {
            $query->where('company_id', $companyId);
        })->orWhereHas('countries', function ($query) use ($countryId) {
            $query->where('country_id', $countryId);
        })->get();


        return $promoCodes;
    }
    public function getById($id)
    {

        $promoCode = PromoCode::find($id);

        if ($promoCode == null)
            throw new HttpResponseException($this->apiResponse(null, false, __('validation.not_exist')));

        return $promoCode;
    }

    public function getByCode($code, $active = null)
    {

        $promoCode = PromoCode::where('code', $code)->when($active != null, function ($query) use ($active) {
            $query->where('active', $active);
        })->get()->first();

        if ($promoCode == null)
            throw new HttpResponseException($this->apiResponse(null, false, __('validation.not_exist'),statusCode: 404));

        return $promoCode;
    }

    public function create($promoCode)
    {


        try {
            $createdPromoCode = PromoCode::create($promoCode);
            if ($createdPromoCode->type == 'countries') {

                $countries = $promoCode['countries_ids'];
                $dataSet = [];
                foreach ($countries as $country) {
                    $dataSet[] = [
                        'country_id'  => $country,
                        'promo_code_id'    => $createdPromoCode->id,
                    ];
                }

                DB::table('promo_codes_countries')->where('promo_code_id', $createdPromoCode['id'])->delete();
                DB::table('promo_codes_countries')->insert($dataSet);
            } else if ($createdPromoCode->type == 'companies') {

                $companies = $promoCode['companies_ids'];
                $dataSet = [];
                foreach ($companies as $company) {
                    $dataSet[] = [
                        'company_id'  => $company,
                        'promo_code_id'    => $createdPromoCode->id,
                    ];
                }

                DB::table('promo_codes_companies')->where('promo_code_id', $createdPromoCode['id'])->delete();
                DB::table('promo_codes_companies')->insert($dataSet);
            } else if ($createdPromoCode->type == 'products') {
                $products = $promoCode['products_ids'];
                $dataSet = [];
                foreach ($products as $product) {
                    $dataSet[] = [
                        'product_id'  => $product,
                        'promo_code_id'    => $createdPromoCode->id,
                    ];
                }

                DB::table('promo_codes_products')->where('promo_code_id', $createdPromoCode['id'])->delete();
                DB::table('promo_codes_products')->insert($dataSet);
            }
            return $createdPromoCode;
        } catch (\Exception $ex) {

            throw new HttpResponseException($this->apiResponse(status: false));;
        }
    }

    public function addCountriesToPromoCode($data)
    {

        try {
            $countries = $data['countries_ids'];
            $dataSet = [];
            foreach ($countries as $country) {
                $dataSet[] = [
                    'country_id'  => $country,
                    'promo_code_id'    => $data['promo_code_id'],
                ];
            }

            DB::table('promo_codes_countries')->where('promo_code_id', $data['promo_code_id'])->delete();
            DB::table('promo_codes_countries')->insert($dataSet);
            return $dataSet;
        } catch (\Exception $ex) {

            throw new HttpResponseException($this->apiResponse(status: false));;
        }
    }

    public function addCompaniesToPromoCode($data)
    {

        try {

            $companies = $data['companies_ids'];
            $dataSet = [];
            foreach ($companies as $company) {
                $dataSet[] = [
                    'company_id'  => $company,
                    'promo_code_id'    => $data['promo_code_id'],
                ];
            }

            DB::table('promo_codes_companies')->where('promo_code_id', $data['promo_code_id'])->delete();
            DB::table('promo_codes_companies')->insert($dataSet);
            return $dataSet;
        } catch (\Exception $ex) {

            throw new HttpResponseException($this->apiResponse(status: false));;
        }
    }

    public function addProductsToPromoCode($data)
    {

        try {

            $products = $data['products_ids'];
            $dataSet = [];
            foreach ($products as $product) {
                $dataSet[] = [
                    'product_id'  => $product,
                    'promo_code_id'    => $data['promo_code_id'],
                ];
            }

            DB::table('promo_codes_products')->where('promo_code_id', $data['promo_code_id'])->delete();
            DB::table('promo_codes_products')->insert($dataSet);
            return $dataSet;
        } catch (\Exception $ex) {

            throw new HttpResponseException($this->apiResponse(status: false));;
        }
    }

    public function update($newPromoCode)
    {

        $promoCode = $this->getById($newPromoCode['id']);
        try {

            $promoCode->update($newPromoCode);
            if ($promoCode->type == 'countries') {

                $dataSet = [];
                if (isset($newPromoCode['countries_ids'])) {
                    foreach ($newPromoCode['countries_ids'] as $country) {
                        $dataSet[] = [
                            'country_id'  => $country,
                            'promo_code_id'    => $promoCode->id,
                        ];
                    }
                }

                DB::table('promo_codes_countries')->where('promo_code_id', $newPromoCode['id'])->delete();
                DB::table('promo_codes_countries')->insert($dataSet);
            } else if ($promoCode->type == 'companies') {


                $dataSet = [];
                if (isset($newPromoCode['companies_ids']) && $newPromoCode['companies_ids'] != null) {
                    foreach ($promoCode['companies_ids'] as $company) {
                        $dataSet[] = [
                            'company_id'  => $company,
                            'promo_code_id'    => $promoCode->id,
                        ];
                    }
                }
                DB::table('promo_codes_companies')->where('promo_code_id', $newPromoCode['id'])->delete();
                DB::table('promo_codes_companies')->insert($dataSet);
            } else if ($promoCode->type == 'companies') {

                $dataSet = [];
                if (isset($newPromoCode['products_ids']) && $newPromoCode['products_ids'] != null) {
                    foreach ($newPromoCode['products_ids'] as $product) {
                        $dataSet[] = [
                            'product_id'  => $product,
                            'promo_code_id'    => $promoCode->id,
                        ];
                    }
                }
                DB::table('promo_codes_products')->where('promo_code_id', $newPromoCode['id'])->delete();
                DB::table('promo_codes_products')->insert($dataSet);
            }
            return $promoCode;
        } catch (\Exception $ex) {

            throw new HttpResponseException($this->apiResponse(status: false));;
        }
    }

    public function delete($id)
    {

        $promoCode = $this->getById($id);

        try {

            $promoCode->delete();
        } catch (\Exception $ex) {

            throw new HttpResponseException($this->apiResponse(null, false, __('validation.cannot_delete')));
        }
    }

    public function toggleActivation($id, $activationStatus)
    {

        $promoCode = $this->getById($id);
        try {

            $promoCode->update(['active' => $activationStatus]);
        } catch (\Exception $ex) {

            throw new HttpResponseException($this->apiResponse(status: false));;
        }
    }
}
