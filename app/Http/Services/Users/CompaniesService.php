<?php

namespace App\Http\Services\Users;

use App\Models\Company;
use App\Models\ClientCompanyRate;
use Illuminate\Support\Facades\DB;
use App\Http\Traits\ResponsesTrait;
use App\Http\Traits\ArraySliceTrait;
use App\Http\Traits\FileUploadTrait;
use App\Http\Services\ProductsService;
use App\Http\Traits\LoggedInUserTrait;
use App\Http\Services\Users\UsersService;
<<<<<<< HEAD
use App\Http\Services\CompaniesCategoriesService;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Http\Services\CompaniesWorkingWithDriverManagersService;
=======
use App\Http\Services\Products\ProductsService;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Http\Services\Products\CompaniesCategoriesService;
use App\Http\Services\Orders\CompaniesWorkingWithDriverManagersService;
>>>>>>> 92e74da04e455e1892cf056762f2cc93354b21c6

class CompaniesService
{

    use ResponsesTrait;
    use FileUploadTrait;
    use ArraySliceTrait;
    use LoggedInUserTrait;
    private $usersService;
    private $proudctsService;
    private $companiesWorkingWithDriversManager;
    private $companiesCategoriesService;
    public function __construct()
    {
        $this->usersService = new UsersService();
    }

    public function getCompanyRates($companyId)
    {

        $data['company_rates'] = DB::select("
                    SELECT base_orders_rates.name_ar,base_orders_rates.name_en, COUNT(value) AS rates, SUM(value) / COUNT(*) AS rate  FROM `base_orders_rates` LEFT JOIN orders_have_base_orders_rates ON base_orders_rates.id = orders_have_base_orders_rates.base_orders_rate_id LEFT JOIN orders ON orders.id = orders_have_base_orders_rates.order_id AND orders.company_id=" . $companyId . "  GROUP BY base_orders_rate_id ");
        return $data;
    }

    public function get($categoryId = null, $countryId = null, $companyId= null, $cityId = null)
    {

        $user = $this->getLoggedInUser();
        switch ($user->role) {
            case "admin":
                $data = Company::when($countryId != null, function ($query) use ($countryId) {
                    $query->where('country_id', $countryId);
                })->when($companyId != null, function ($query) use ($companyId) {
                    $query->where('user_id', $companyId);
                })->when($categoryId != null , function ($query)use ($categoryId){
                    $query->with('categories', function ($query) use ($categoryId){
                        $query->when($categoryId != null, function ($query) use ($categoryId) {
                            $query->where('category_id', $categoryId);
                        });
                    });
                })->with('user')->get();
                break;
            case "country_manager":

                ///// GET ALL COMPANIES IN A COUNTRY
                $data= Company::where('country_id', $user->countryManager->country_id)->with('user')->get();
                /////
                break;
            case "client": // tested and done


                $data = DB::select('SELECT (SELECT count(*) FROM orders_have_base_orders_rates
                JOIN orders ON orders.id = orders_have_base_orders_rates.order_id AND orders.company_id=companies.user_id)
                AS rates,(SELECT sum(orders_have_base_orders_rates.value) / count(*) FROM orders_have_base_orders_rates
                JOIN orders ON orders.id = orders_have_base_orders_rates.order_id AND orders.company_id=companies.user_id)
                AS rate ,companies.user_id as id,name,logo_path,orders_per_hour FROM  companies
                JOIN companies_categories ON companies.user_id = companies_categories.company_id
                AND companies_categories.category_id = ' . $categoryId . '
                JOIN companies_deliver_to_cities ON companies.user_id = companies_deliver_to_cities.company_id
                AND companies_deliver_to_cities.city_id=' . $cityId . '
                JOIN users ON companies.user_id = users.id
                ');



                break;
        }
        return $data;
    }

    public function getById($id)
    {

        $category = Company::find($id);

        if ($category == null)
            throw new HttpResponseException($this->apiResponse(null, false, __('validation.not_exist')));
        return $category;
    }



    public function create($data)
    {
        $user = $this->array_slice_assoc($data, ['name', 'email', 'phone', 'password']);
        try {

            $createdUser = $this->usersService->create($user, 'company');

            $company = $this->array_slice_assoc($data, ['orders_per_hour', 'logo_path', 'cover_path', 'country_id', 'name_ar', 'name_en']);
            $company['user_id'] = $createdUser->id;
            $createdCompany = Company::create($company);
            return $createdCompany;

        } catch (\Exception $ex) {
            $createdUser->delete();
            throw new HttpResponseException($this->apiResponse(status:false));
        }
    }


    public function createClientRate($data)
    {

        $data['client_id'] = $this->getLoggedInUser()->id; // should be client
        $createdRate = ClientCompanyRate::updateOrCreate(
            ['base_companies_rate_id' => $data['base_companies_rate_id'], 'company_id' => $data['company_id'], 'client_id' => $data['client_id']],
            ['value' => $data['value']]
        );
    }


    public function update($newCompany)
    {

        $company = $this->getById($newCompany['id']);

        try {

            $user = $this->array_slice_assoc($newCompany, ['phone','name','email','password','active']);
            $user['id'] = $company->user_id;
            $this->usersService->update($user);
            $company->update($newCompany);

            return $company;

        } catch (\Exception $ex) {

            throw new HttpResponseException($this->apiResponse(status:false));
        }
    }

    public function delete($id)
    {

        $company = $this->getById($id);
        $user = $this->getLoggedInUser();
        try {

            if($this->usersService->canUserDeleteUser($user,$id)){

                if($this->canUserCreateOrDeleteCompany($company->country_id)){
                    $this->deleteChild($company);
                    $company->delete();
                }
            }else{

                throw new HttpResponseException($this->apiResponse(null, false, __('valiedation.not_allowed_to_delete')));
            }



               ////////// CAN BE RESTORED
            //$logoPath = $company->logo_path;
            //$this->deleteFile($logoPath);
              ///////////////////////////
        } catch (\Exception $ex) {

            throw new HttpResponseException($this->apiResponse(null, false, __('valiedation.not_allowed_to_delete')));
        }
    }
    public function canUserCreateOrDeleteCompany($countryId){

        $user = $this->getLoggedInUser();
        switch ($user->role) {
            case "admin":
                return true;
            case "country_manager":
                //dd($user->countryManager->country_id , $countryId);
                if($user->countryManager->country_id == $countryId)
                return true;
        }

    }

    public function deleteChild($company){

        $this->companiesCategoriesService = new CompaniesCategoriesService;
        $this->companiesCategoriesService->deleteChildren(companyId: $company->user_id);

        $this->companiesWorkingWithDriversManager = new CompaniesWorkingWithDriverManagersService;
        $this->companiesWorkingWithDriversManager->deleteChildren(companyId: $company->user_id);

        $this->proudctsService = new ProductsService;
        $this->proudctsService->deleteChildren(companyId: $company->user_id);

        //// DELETE CLIENTS COMPANY RATES
        ClientCompanyRate::where('company_id', $company->user_id)->delete();

        ///// DELETE IN USER TABLE
        $company->user->delete();

    }
    public function canUserUpdateCompany($companyId){

        $user = $this->getLoggedInUser();
        $company = $this->getById($companyId);
        switch ($user->role) {
            case "admin":
                return true;
            case "country_manager":
                //dd($user->countryManager->country_id , $company->country_id);
                if($user->countryManager->country_id == $company->country_id)
                return true;
        }

    }
}
