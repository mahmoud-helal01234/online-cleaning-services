<?php

namespace App\Http\Services\DriversApp;

use App\Models\DriversApp\Product;
use Illuminate\Support\Facades\DB;
use App\Http\Traits\ResponsesTrait;
use App\Http\Traits\LoggedInUserTrait;
use App\Models\DriversApp\ProductOption;
use Illuminate\Http\Exceptions\HttpResponseException;

class ProductsService
{

    use ResponsesTrait, LoggedInUserTrait;

    public function get()
    {

        $loggedInUser = $this->getLoggedInUser();
        $products = Product::with('productOptions:id,name,price,drivers_app_product_id')->where('user_id', $loggedInUser->id)->orderBy('name', 'DESC')->get();
        return $products;
    }

    public function getById($id)
    {

        $product = Product::find($id);

        if ($product == null)
            throw new HttpResponseException($this->apiResponse(null, false, __('validation.not_exist')));

        return $product;
    }

    public function create($product)
    {

        $loggedInUser = $this->getLoggedInUser();
        $product['user_id'] = $loggedInUser->id;
        $createdproduct = Product::create($product);
        foreach ($product['options'] as $productOption) {

            ProductOption::create([...$productOption, "drivers_app_product_id" => $createdproduct->id]);
        }

        try {
        } catch (\Exception $ex) {

            throw new HttpResponseException($this->apiResponse(null, false, $ex->getMessage()));;
        }
    }

    public function update($newproduct)
    {

        $product = $this->getById($newproduct['id']);

        try {

            $product->update($newproduct);
            ProductOption::where('drivers_app_product_id', $newproduct['id'])->delete();
            foreach ($newproduct['options'] as $productOption) {

                ProductOption::create([...$productOption, "drivers_app_product_id" => $newproduct['id']]);
            }
        } catch (\Exception $ex) {

            throw new HttpResponseException($this->apiResponse(null, false, $ex->getMessage()));;
        }
    }

    public function delete($id)
    {

        $loggedInUser = $this->getLoggedInUser();
        $driversAppProduct = $this->getById($id);
        $this->canUserDeleteProduct($loggedInUser, $driversAppProduct);
        try {

            ProductOption::where('drivers_app_product_id', $id)->delete();
            $driversAppProduct->delete();
        } catch (\Exception $ex) {

            throw new HttpResponseException($this->apiResponse(null, false, __('validation.cannot_delete') . $ex->getMessage()));
        }
    }

    public function copyProductsToUser($fromId, $toId)
    {

        $products = Product::where('user_id', $fromId)->select('name', 'price')->get();
        for ($i = 0; $i < count($products); $i++) {

            $products[$i]->user_id = $toId;
        }
        DB::table('products')->insert($products->toArray());
    }
    // in middleware
    public function canUserRoleCreateProduct($userRole)
    {

        switch ($userRole) {
            case "admin":
            case "country_manager":
            case "company":
            case "drivers_manager":
                return true;
            case "driver":
                return false;
        }
    }

    public function canUserUpdateProduct($user, $productId)
    {

        // even admin can't update but his products
        return $this->getById($productId)->user_id == $user->id;
    }

    public function canUserDeleteProduct($user, $driversAppProduct)
    {



        // even admin can't delete but his products
        if ($driversAppProduct->user_id != $user->id) {

            throw new HttpResponseException($this->apiResponse(null, false, __('validation.cannot_delete')));
        }
    }
}
