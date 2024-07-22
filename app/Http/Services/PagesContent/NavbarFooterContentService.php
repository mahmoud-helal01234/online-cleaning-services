<?php

namespace App\Http\Services\PagesContent;

use App\Models\Order;
use App\Http\Traits\ResponsesTrait;
use App\Models\NavbarFooterContent;
use App\Http\Traits\FileUploadTrait;
use App\Http\Traits\LoggedInUserTrait;
use Illuminate\Http\Exceptions\HttpResponseException;

class NavbarFooterContentService
{

    use ResponsesTrait;
    use FileUploadTrait;
    use LoggedInUserTrait;

    public function get()
    {

        $loggedInUser = $this->getLoggedInUser();
        $navbarFooterContent = NavbarFooterContent::first();

        if ($loggedInUser != null) {

            switch ($loggedInUser->role) {

                case "client": // tested and done
                    $clientId = $loggedInUser->id;
                    $ordersNum = Order::where('status', 'in_cart')->whereHas('clientOrder', function ($query)  use ($clientId) {
                        $query->where('client_id', $clientId);
                    })->count();
                    $navbarFooterContent['cart_num'] = $ordersNum;
            }
        }
        return $navbarFooterContent;
    }

    public function update($newNavbarFooterContent)
    {

        try {

            $navbarFooterContent = NavbarFooterContent::updateOrCreate(['id' => 1], $newNavbarFooterContent);
            return $navbarFooterContent;
        } catch (\Exception $ex) {

            throw new HttpResponseException($this->apiResponse(status:false));;
        }
    }
}
