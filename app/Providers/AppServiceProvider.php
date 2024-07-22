<?php

namespace App\Providers;

use App\Models\ProductOption;
use App\Http\Traits\ResponsesTrait;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Exceptions\HttpResponseException;

class AppServiceProvider extends ServiceProvider
{
    use ResponsesTrait;
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

            JsonResource::withoutWrapping(); // tried both
            
        // Validator::extend('company_option', function ($attribute, $value, $parameters,$validationModel) {

        //     // $attribute is the input name
        //     // $value is the value sent with the input
        //     // $parameters : data sent with this custom validation rule (custom_rule:id,1) then $parameters[0] = 'id' and so on
        //     // $validationModel : data from request used in validator

        //     // The user that's being edited, if any.


        //     $product = ProductOption::with('product')->find($value)->product;

        //     // True means pass, false means fail validation.
        //     // If count is 0, that means the unique constraint passes.

        //     return $product->company_id == $parameters[0];
        // });

        //
    }
}
