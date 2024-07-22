<?php

namespace App\Http\Services;

use App\Models\Company;
use Illuminate\Support\Facades\DB;
use App\Http\Services\UsersService;
use App\Http\Traits\ResponsesTrait;
use App\Models\StatisticsCategories;
use App\Http\Traits\ArraySliceTrait;
use App\Http\Traits\FileUploadTrait;
use App\Http\Traits\LoggedInUserTrait;
use App\Http\Resources\Client\StatisticsResource;
use App\Models\ClientCompanyRate;
use Illuminate\Http\Exceptions\HttpResponseException;

class StatisticsService
{

    use ResponsesTrait;
    use FileUploadTrait;
    use ArraySliceTrait;
    use LoggedInUserTrait;
    public function __construct()
    {

    }

    public function getYearlyStatistics($year)
    {
        $user = $this->getLoggedInUser();
        switch ($user->role) {
            case "admin":

                $data = DB::table('orders')
                ->select([
                    DB::raw("(SELECT COUNT(DISTINCT id) FROM orders WHERE YEAR(created_at) = $year) as orders_count"),
                    DB::raw("(SELECT COUNT(DISTINCT id) FROM companies WHERE YEAR(created_at) = $year) as companies_count"),
                    DB::raw("(SELECT COUNT(DISTINCT id) FROM clients WHERE YEAR(created_at) = $year) as clients_count"),
                ])->limit(1)
                ->first();
                break;
            case "country_manager":

                break;
        }
        return $data;
    }


}
