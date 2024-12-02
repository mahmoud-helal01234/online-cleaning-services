<?php

use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['middleware' => ['api'], 'namespace' => 'App\Http\Controllers'], function () {

    Route::group(['namespace' => 'Products'], function () {
        // Route::post('/import-products','ProductsController@import');
        // Route::post('/upload-images', 'ProductsController@uploadImages');

        Route::get('category', 'CategoriesController@get'); // parent_id, country_id
    });
    Route::group(['namespace' => 'Offers'], function () {
        Route::get('promo_code/code/{code}', 'PromoCodesController@getByCode');

    });

    Route::get('create-channel', 'TestNotificationsController@createChannel');
    Route::get('broadcast-event', 'TestNotificationsController@broadcastEvent');

    Route::group(['namespace' => 'Countries'], function () {


        Route::get('country', 'CountriesController@get');

        Route::group(['middleware' => ['authenticate:admin']], function () {

            Route::post('country', 'CountriesController@create');
            Route::post('country/update', 'CountriesController@update');
            Route::delete('country/{id}', 'CountriesController@delete');
            Route::get('country/{id}/activate/{activationStatus}', 'CountriesController@toggleActivation');
        });
        /// I ADD COUNTRY MANAGER ROLE HERE THE AUTH IS HANDELED IN THE SERVICES & REQUESTS AUHTHORIZATION.
        Route::group(['middleware' => ['authenticate:admin,country_manager']], function () {

            Route::get('country/{countryId}/governorate', 'GovernoratesController@get');
            Route::post('governorate', 'GovernoratesController@create');
            Route::post('governorate/update', 'GovernoratesController@update');
            Route::delete('governorate/{id}', 'GovernoratesController@delete');
            Route::get('governorate/{id}/activate/{activationStatus}', 'GovernoratesController@toggleActivation');

            Route::get('governorate/{governorateId}/city', 'CitiesController@get');
            Route::post('city', 'CitiesController@create');
            Route::post('city/update', 'CitiesController@update');
            Route::delete('city/{id}', 'CitiesController@delete');
            Route::get('city/{id}/activate/{activationStatus}', 'CitiesController@toggleActivation');
        });
    });

    Route::group(['namespace' => 'Users'], function () {

        Route::get('/login/{provider}/callback', 'AuthController@handleProviderCallback');
        Route::post('client/social_login', 'AuthController@socialLogin');
        // Route::get('auth/{provider}', 'AuthController@redirectToProvider');
        // Route::get('auth/{provider}/callback', 'AuthController@handleProviderCallback');

        Route::group(['middleware' => ['authenticate']], function () {
            Route::post('me', 'AuthController@me');
            // Route::get('user', 'UsersController@get');
            Route::get('user/view_profile', 'UsersController@viewProfile');
            Route::post('user/update', 'UsersController@update');
            // Route::delete('user/{id}', 'UsersController@delete');
            Route::get('client/view_profile', 'ClientsController@viewProfile');
            Route::post('client/update_profile', 'ClientsController@updateProfile');
            Route::get('client/logout', 'ClientsController@logout');

            Route::post('device_token', 'UsersController@createDeviceToken');
        });
        Route::get('company_rate', 'CompaniesController@getCompanyRates');


        Route::get('logout', 'AuthController@logout');
        Route::post('refresh', 'AuthController@refresh');
        Route::post('login', 'AuthController@login'); // dashboard

        // done and tested
        Route::post('client/login', 'ClientsController@login'); // client
        Route::post('client/register', 'ClientsController@register');



        Route::get('client/location/select/{clientId}', 'ClientLocationsController@selectClientLocations');
        Route::get('client/select/{companyId}', 'ClientsController@selectClientsByCompany');

        Route::get('client/send_password_reset_token/{email}', 'AuthController@sendPasswordResetTokenClients');
        Route::post('client/reset_password', 'AuthController@resetPasswordClients');

        Route::get('send_password_reset_token/{email}', 'AuthController@sendPasswordResetTokenUsers');
        Route::post('reset_password', 'AuthController@resetPasswordUsers');

        Route::group(['middleware' => ['authenticate:admin']], function () {

            Route::get('client', 'ClientsController@get');
            Route::post('client', 'ClientsController@create');
            Route::post('client/update', 'ClientsController@update');
            Route::delete('client/{id}', 'ClientsController@delete');
            Route::get('client/{id}/activate/{activationStatus}', 'ClientsController@toggleActivation');


            Route::get('user/select', 'UsersController@getSelect');
            Route::get('admin', 'AdminsController@get');
            Route::post('admin', 'AdminsController@create');
            Route::post('admin/update', 'AdminsController@update');
            Route::delete('admin/{id}', 'AdminsController@delete');
            Route::get('admin/{id}/activate/{activationStatus}', 'AdminsController@toggleActivation');

            Route::get('country_manager', 'CountryManagersController@get');
            Route::post('country_manager', 'CountryManagersController@create');
            Route::post('country_manager/update', 'CountryManagersController@update');
            Route::delete('country_manager/{id}', 'CountryManagersController@delete');
            Route::get('country_manager/{id}/activate/{activationStatus}', 'CountryManagersController@toggleActivation');
        });

        Route::group(['middleware' => ['authenticate:client']], function () {



            Route::post('client_location', 'ClientLocationsController@create');
            Route::delete('client_location/{id}', 'ClientLocationsController@delete');
        });

        Route::group(['middleware' => ['authenticate:admin,customer_service,client']], function () {

            Route::get('client_location', 'ClientLocationsController@get');
        });
        Route::group(['middleware' => ['authenticate:admin,company,drivers_manager']], function () {

            Route::get('my_drivers', 'DriversController@myDrivers');
        });
        /// I ADD IT TO ENABLE ERVERY ROLE TO CAN EDIT IT SELF, SEE OTHER ROLE "GET METHOD" LIKE 'COUNTRY_MANAGER WANT TO SEE COMPANIES' , AUTH IS HANDELED IN THE SERVICES & REQUESTS AUHTHORIZATION.
        Route::group(['middleware' => ['authenticate:admin,country_manager,company,drivers_manager,driver']], function () {
            Route::get('company', 'CompaniesController@get');
            Route::post('company', 'CompaniesController@create');
            Route::post('company/update', 'CompaniesController@update');
            Route::delete('company/{id}', 'CompaniesController@delete');

            Route::get('drivers_manager', 'DriversManagersController@get');
            Route::post('drivers_manager', 'DriversManagersController@create');
            Route::post('drivers_manager/update', 'DriversManagersController@update');
            Route::delete('drivers_manager/{id}', 'DriversManagersController@delete');
            Route::get('drivers_manager/{id}/activate/{activationStatus}', 'DriversManagersController@toggleActivation');

            Route::get('driver', 'DriversController@get');
            Route::post('driver', 'DriversController@create');
            Route::post('driver/update', 'DriversController@update');
            Route::delete('driver/{id}', 'DriversController@delete');
            Route::get('driver/{id}/activate/{activationStatus}', 'DriversController@toggleActivation');
        });
        Route::group(['middleware' => ['authenticate:client']], function () {

            Route::post('client_company_rate', 'CompaniesController@createClientRate');
        });
    });

    Route::group(['namespace' => 'Orders'], function () {
        
        Route::post('order/client', 'OrdersController@createForClient');

        Route::get('region', 'RegionsController@get');

        Route::group(['middleware' => ['authenticate:client']], function () {

            
            Route::get('order/client', 'OrdersController@getForClient');

        });

        Route::group(['middleware' => ['authenticate:admin']], function () {

            Route::get('company/{companyId}/deliver_to/city', 'CompaniesDeliverToCitiesController@getCitiesDeliveredByCompany');
            Route::get('city/{cityId}/delivered_by/company', 'CompaniesDeliverToCitiesController@getCompaniesDeliverToCity');
            Route::post('company/deliver_to/city', 'CompaniesDeliverToCitiesController@addCompanyDeliverToCityRelation');
            Route::delete('company/deliver_to/city/{id}', 'CompaniesDeliverToCitiesController@deleteCompanyDeliverToCityRelation');

            Route::get('order', 'OrdersController@get');
            Route::get('order_statuses', 'OrdersController@getStatuses');

            Route::post('client_order', 'ClientOrdersController@create');
            Route::post('client_order/update', 'ClientOrdersController@update');

            Route::post('delivery_type', 'DeliveryTypesController@create');
            Route::post('delivery_type/update', 'DeliveryTypesController@update');
            Route::delete('delivery_type/{id}', 'DeliveryTypesController@delete');
            Route::get('delivery_type/{id}/activate/{activationStatus}', 'DeliveryTypesController@toggleActivation');
            Route::get(
                'drivers_manager/working_with/company',
                'CompaniesWorkingWithDriversManagersController@get'
            );
            // Route::get(
            //     'drivers_manager/{driverManagerId}/working_with/company',
            //     'CompaniesWorkingWithDriversManagersController@getCompaniesWorkingWithDriversManager'
            // );
            Route::get(
                'company/{companyId}/working_with/drivers_manager',
                'CompaniesWorkingWithDriversManagersController@getDriverManagersWorkingWithCompany'
            );
            Route::post(
                'drivers_manager/working_with/company',
                'CompaniesWorkingWithDriversManagersController@addDriversManagerWorkingWithCompanyRelation'
            );
            Route::delete(
                'drivers_manager/working_with/company/{id}',
                'CompaniesWorkingWithDriversManagersController@deleteDriversManagerWorkingWithCompanyRelation'
            );
            Route::get('orders_analysis', 'OrdersAnalysisController@get');
            Route::get('orders_count_per_company', 'OrdersAnalysisController@getOrdersAnalysisPerCompany');
            Route::get('orders_count_for_week/{startingData}', 'OrdersAnalysisController@getOrdersCountForWeek');

            Route::get('orders_analysis_per_company', 'OrdersAnalysisController@getOrdersAnalysisPerCompany');


            Route::post('order/change_company', 'OrdersController@changeCompany');

            // Route::get('invoice', 'InvoicesController@get');
            // Route::post('invoice', 'InvoicesController@create');
            // Route::post('invoice/update', 'InvoicesController@update');
            // Route::delete('invoice/{id}', 'InvoicesController@delete');


        });

        Route::group(['middleware' => ['authenticate:admin,country_manager,company']], function () {

            Route::get('invoice', 'InvoicesController@get');
            Route::post('invoice', 'InvoicesController@create');
            Route::post('invoice/update', 'InvoicesController@update');
            Route::delete('invoice/{id}', 'InvoicesController@delete');
        });
        Route::group(['middleware' => ['authenticate:admin,country_manager,company,drivers_manager']], function () {

            Route::get('transportation_periods_assigned_to_drivers/select', 'TransportationPeriodsAssignedToDriversController@selectPeriodsWithCapacity');

            Route::post('order', 'OrdersController@create');
            Route::post('order/update', 'OrdersController@update');
            Route::delete('order/{id}', 'OrdersController@delete');

            Route::get('transportation_period', 'TransportationPeriodsController@get');
            Route::post('transportation_period', 'TransportationPeriodsController@create');
            Route::post('transportation_period/update', 'TransportationPeriodsController@update');
            Route::delete('transportation_period/{id}', 'TransportationPeriodsController@delete');
            Route::get('transportation_period/{id}/activate/{activationStatus}', 'TransportationPeriodsController@toggleActivation');

            Route::get('transportation_period/{id}/driver', 'TransportationPeriodsAssignedToDriversController@getDriverForTransportationPeriod');
            Route::post('transportation_period/driver', 'TransportationPeriodsAssignedToDriversController@create');
            Route::post('transportation_period/driver/update', 'TransportationPeriodsAssignedToDriversController@update');
            Route::delete('driver/assigned_to/transportation_period/{id}', 'TransportationPeriodsAssignedToDriversController@delete');

            Route::get('transportation_periods_assigned_to_drivers', 'TransportationPeriodsAssignedToDriversController@get');
        });

        Route::group(['middleware' => ['authenticate:admin,driver,customer_service']], function () {

            Route::get('order', 'OrdersController@get');


            Route::get('order/{id}/status/{status}', 'OrdersController@changeOrderStatus');


            Route::get('transportation_period', 'TransportationPeriodsController@get');
            Route::post('transportation_period', 'TransportationPeriodsController@create');
            Route::post('transportation_period/update', 'TransportationPeriodsController@update');
            Route::delete('transportation_period/{id}', 'TransportationPeriodsController@delete');
            Route::get('transportation_period/{id}/activate/{activationStatus}', 'TransportationPeriodsController@toggleActivation');


            Route::get('order_comment/{orderId}', 'OrderCommentsController@get');
            Route::get('order_comment/{id}/show_for_client/{showForClient}', 'OrderCommentsController@toggleShowForClient');
            Route::post('order_comment', 'OrderCommentsController@create');
            Route::post('order_comment/update', 'OrderCommentsController@update');
            Route::delete('order_comment/{id}', 'OrderCommentsController@delete');

            Route::get('notification', 'NotificationsController@get');
            Route::delete('notification/{id}', 'NotificationsController@delete');
        });


        Route::group(['middleware' => ['authenticate:admin,client']], function () {

            Route::get('delivery_type', 'DeliveryTypesController@get');
            Route::get('order/working', 'OrdersController@getWorkingOn');
        });

        Route::group(['middleware' => ['authenticate:client']], function () {


            Route::get('cart_order', 'OrdersController@getCartOrderDetails'); // order_id
            Route::get('order_details/{id}', 'OrdersController@getOrderDetails');
            Route::post('rate_order', 'OrdersController@rate');

            Route::get('order/client/cart', 'ClientOrdersController@getClientOrdersInCart');

            Route::post('add_promo_code_to_order', 'ClientOrdersController@addPromoCodeToOrder');
            Route::post('add_items_to_order', 'ClientOrdersController@addProductOptionsToCart');
            Route::post('checkout', 'ClientOrdersController@checkOut');
            Route::post('order_item/update', 'OrdersController@updateOrderItem');
            Route::delete('order_item/{id}', 'OrdersController@deleteOrderItem');
            //  Route::delete('order/{id}', 'OrdersController@delete');
        });

        Route::group(
            ['middleware' => ['authenticate:driver'], 'prefix' => 'drivers_app/'],
            function () {

                Route::post('driver/location', 'DriverLocationsController@create');
                //
            }
        );
        Route::group(
            ['middleware' => ['authenticate:admin,company,drivers_manager,driver']],
            function () {

                Route::get('driver/location', 'DriverLocationsController@get');
            }
        );
    });

    Route::group(['namespace' => 'Offers'], function () {

        Route::get('offer', 'OffersController@get');
        Route::get('general_offer', 'GeneralOffersController@get');
        Route::get('slider_offer', 'SliderOffersController@get');
        Route::get('promo_code_offer', 'PromoCodeOffersController@get');
        Route::get('promo_code/{id?}', 'PromoCodesController@get');
        
        
        Route::get('promo_code/select/{companyId}', 'PromoCodesController@selectPromoCodes');


        Route::group(['middleware' => ['authenticate:admin']], function () {

            Route::post('slider_offer', 'SliderOffersController@create');
            Route::post('slider_offer/update', 'SliderOffersController@update');
            Route::delete('slider_offer/{id}', 'SliderOffersController@delete');
            Route::get('slider_offer/{id}/activate/{activationStatus}', 'SliderOffersController@toggleActivation');

            //Route::get('general_offer', 'GeneralOffersController@get');
            Route::post('general_offer', 'GeneralOffersController@create');
            Route::post('general_offer/update', 'GeneralOffersController@update');
            Route::delete('general_offer/{id}', 'GeneralOffersController@delete');
            Route::get('general_offer/{id}/activate/{activationStatus}', 'GeneralOffersController@toggleActivation');

            Route::post('offer', 'OffersController@create');
            Route::post('offer/update', 'OffersController@update');
            Route::delete('offer/{id}', 'OffersController@delete');
            Route::get('offer/{id}/activate/{activationStatus}', 'OffersController@toggleActivation');


            Route::post('promo_code_offer', 'PromoCodeOffersController@create');
            Route::post('promo_code_offer/update', 'PromoCodeOffersController@update');
            Route::delete('promo_code_offer/{id}', 'PromoCodeOffersController@delete');
            Route::get('promo_code_offer/{id}/activate/{activationStatus}', 'PromoCodeOffersController@toggleActivation');

            //Route::get('promo_code/{id?}', 'PromoCodesController@get');
            Route::post('promo_code', 'PromoCodesController@create');
            Route::post('promo_code/update', 'PromoCodesController@update');
            Route::delete('promo_code/{id}', 'PromoCodesController@delete');
            Route::get('promo_code/{id}/activate/{activationStatus}', 'PromoCodesController@toggleActivation');

            Route::post('promo_code/countries', 'PromoCodesController@addCountriesToPromoCode');
            Route::post('promo_code/companies', 'PromoCodesController@addCompaniesToPromoCode');
            Route::post('promo_code/products', 'PromoCodesController@addProductsToPromoCode');

            Route::post('general_offer_order', 'ClientGeneralOfferOrdersController@create');
            Route::post('general_offer_order/update', 'ClientGeneralOfferOrdersController@update');
            Route::delete('general_offer_order/{id}', 'ClientGeneralOfferOrdersController@delete');
        });

        Route::group(['middleware' => ['authenticate:admin,client']], function () {

            Route::get('general_offer_order', 'ClientGeneralOfferOrdersController@get');
        });
    });

    Route::group(['namespace' => 'Rates'], function () {

        Route::group(['middleware' => ['authenticate:admin']], function () {

            Route::post('base_companies_rate', 'BaseCompaniesRatesController@create');
            Route::post('base_companies_rate/update', 'BaseCompaniesRatesController@update');
            Route::delete('base_companies_rate/{id}', 'BaseCompaniesRatesController@delete');

            /////admin
            Route::post('base_drivers_rate', 'BaseDriversRatesController@create');
            Route::post('base_drivers_rate/update', 'BaseDriversRatesController@update');
            Route::delete('base_drivers_rate/{id}', 'BaseDriversRatesController@delete');

            /////admin
            Route::post('base_orders_rate', 'BaseOrdersRatesController@create');
            Route::post('base_orders_rate/update', 'BaseOrdersRatesController@update');
            Route::delete('base_orders_rate/{id}', 'BaseOrdersRatesController@delete');
        });

        Route::group(['middleware' => ['authenticate:admin,client']], function () {

            Route::get('base_companies_rate', 'BaseCompaniesRatesController@get');

            Route::get('base_drivers_rate', 'BaseDriversRatesController@get');

            Route::get('base_orders_rate', 'BaseOrdersRatesController@get');


            Route::post('client_driver_rate', 'DriversController@createClientRate');
        });
    });


    Route::group(['namespace' => 'Products'], function () {

        Route::get('category', 'CategoriesController@get'); // parent_id, country_id
        Route::get('product', 'ProductsController@get');

        Route::group(['middleware' => ['authenticate:admin']], function () {

            Route::post('category', 'CategoriesController@create');
            Route::post('category/update', 'CategoriesController@update');
            Route::delete('category/{id}', 'CategoriesController@delete');
            Route::get('category/{id}/activate/{activationStatus}', 'CategoriesController@toggleActivation');

            Route::post('product', 'ProductsController@create');
            Route::post('product/update', 'ProductsController@update');
            Route::delete('product/{id}', 'ProductsController@delete');



            Route::get(
                'category/{categoryId}/have/country',
                'CountriesHaveCategoriesController@getCategoryCountries'
            );
            Route::post(
                'country/have/category',
                'CountriesHaveCategoriesController@addCategoryInCountry'
            );
            Route::delete(
                'country/have/category/{id}',
                'CountriesHaveCategoriesController@deleteCategoryInCountryRelation'
            );
            Route::get('get_drivers_status', 'DriversController@getDrivers');

            Route::get('product/categories_with_companies/select', 'CompaniesCategoriesController@getCategoriesWithCompaniesSelect');
            // Route::post('product', 'ProductsController@create');
            // Route::post('product/update', 'ProductsController@update');
            // Route::delete('product/{id}', 'ProductsController@delete');
            // Route::get('product/{id}/activate/{activationStatus}', 'ProductsController@toggleActivation');

            Route::get('product_option/{productId?}', 'ProductOptionsController@get');
            Route::post('product_option', 'ProductOptionsController@create');
            Route::post('product_option/update', 'ProductOptionsController@update');
            Route::delete('product_option/{id}', 'ProductOptionsController@delete');
            Route::get('product_option/{id}/activate/{activationStatus}', 'ProductOptionsController@toggleActivation');
        });


        Route::group(['middleware' => ['authenticate:admin']], function () {

            Route::get('product_option/{productId?}', 'ProductOptionsController@get');
            Route::post('product', 'ProductsController@create');
            Route::post('product/update', 'ProductsController@update');
            Route::delete('product/{id}', 'ProductsController@delete');
            Route::get('product/{id}/activate/{activationStatus}', 'ProductsController@toggleActivation');
        });
        Route::group(['middleware' => ['authenticate:admin,client']], function () {

            //Route::post('client_company_rate', 'CompaniesController@createClientRate');

            Route::post('client_driver_rate', 'DriversController@createClientRate');


            //Route::get('category', 'CategoriesController@get');

        });
    });

    Route::group(['namespace' => 'DriversApp'], function () {

        Route::group(['middleware' => ['authenticate:admin,drivers_manager,company'], 'prefix' => 'drivers_app/'], function () {

            Route::get('client', 'ClientsController@get');
            Route::post('client', 'ClientsController@create');
            Route::post('client/update', 'ClientsController@update');
            Route::delete('client/{id}', 'ClientsController@delete');
        });

        Route::group(['middleware' => ['authenticate:admin,client']], function () {
        });
    });

    Route::group(['namespace' => 'PagesContent'], function () {


        Route::group(['middleware' => ['authenticate:admin']], function () {


            Route::post('order_step', 'OrderStepsController@create');
            Route::post('order_step/update', 'OrderStepsController@update');
            Route::delete('order_step/{id}', 'OrderStepsController@delete');
            Route::get('order_step/{id}/activate/{activationStatus}', 'OrderStepsController@toggleActivation');

            Route::post('social_link', 'SocialLinksController@create');
            Route::post('social_link/update', 'SocialLinksController@update');
            Route::delete('social_link/{id}', 'SocialLinksController@delete');

            Route::post('rule', 'RulesController@create');
            Route::post('rule/update', 'RulesController@update');
            Route::delete('rule/{id}', 'RulesController@delete');
            Route::get('rule/{id}/activate/{activationStatus}', 'RulesController@toggleActivation');

            Route::post('payment_method', 'PaymentMethodsController@create');
            Route::post('payment_method/update', 'PaymentMethodsController@update');
            Route::delete('payment_method/{id}', 'PaymentMethodsController@delete');
            Route::get('payment_method/{id}/activate/{activationStatus}', 'PaymentMethodsController@toggleActivation');

            Route::post('terms_and_conditions/update', 'TermsAndConditionsController@update');

            Route::post('cooperation_with_us_reason', 'CooperationWithUsReasonsController@create');
            Route::post('cooperation_with_us_reason/update', 'CooperationWithUsReasonsController@update');
            Route::delete('cooperation_with_us_reason/{id}', 'CooperationWithUsReasonsController@delete');

            Route::post('frequently_asked_question', 'FrequentlyAskedQuestionsController@create');
            Route::post('frequently_asked_question/update', 'FrequentlyAskedQuestionsController@update');
            Route::delete('frequently_asked_question/{id}', 'FrequentlyAskedQuestionsController@delete');

            Route::post('nav_bar_footer_content/update', 'NavbarFooterContentController@update');

            Route::post('home_slider_image', 'HomeSliderImageController@create');
            Route::post('home_slider_image/update', 'HomeSliderImageController@update');
            Route::delete('home_slider_image/{id}', 'HomeSliderImageController@delete');

            Route::post('statistics_tag', 'StatisticsTagsController@create');
            Route::post('statistics_tag/update', 'StatisticsTagsController@update');
            Route::delete('statistics_tag/{id}', 'StatisticsTagsController@delete');

            Route::post('client_feedback', 'ClientFeedbackController@create');
            Route::post('client_feedback/update', 'ClientFeedbackController@update');
            Route::delete('client_feedback/{id}', 'ClientFeedbackController@delete');

            Route::post('about_us/update', 'AboutUsContentController@update');

            Route::post('offers_page/update', 'OffersPageContentController@update');

            Route::post('home_page/update', 'HomePageContentController@update');
        });

        Route::group(['middleware' => ['authenticate:admin,client']], function () {
        });
        Route::get('rule', 'RulesController@get');
        Route::get('social_link', 'SocialLinksController@get');
        Route::get('payment_method', 'PaymentMethodsController@get');
        Route::get('terms_and_conditions', 'TermsAndConditionsController@get');
        Route::get('cooperation_with_us_reason', 'CooperationWithUsReasonsController@get');
        Route::get('frequently_asked_question', 'FrequentlyAskedQuestionsController@get');
        Route::get('statistics_tag', 'StatisticsTagsController@get');
        Route::get('client_feedback', 'ClientFeedbackController@get');
        Route::get('home_slider_image', 'HomeSliderImageController@get');
        Route::get('order_step', 'OrderStepsController@get');
        Route::get('offers_page', 'OffersPageContentController@get');
        Route::get('home_page', 'HomePageContentController@get');
        Route::get('nav_bar_footer_content', 'NavbarFooterContentController@get');
        Route::get('about_us_page', 'AboutUsContentController@get');
    });

    Route::group(['middleware' => ['authenticate:admin']], function () {

        Route::post('setting/update', 'SettingsController@update');
    });
    Route::group(['namespace' => 'Client'], function () {
        Route::get('client/home_page', 'HomePageController@get');
        Route::get('client/offer', 'OffersController@get');
        Route::get('client_app/home', 'ClientAppHomeController@get');
    });

    Route::group(['namespace' => 'Wallets'], function () {

        Route::group(['middleware' => ['authenticate:admin']], function () {

            Route::post('wallet_credit_offer', 'WalletCreditOffersController@create');
            Route::post('wallet_credit_offer/update', 'WalletCreditOffersController@update');
            Route::delete('wallet_credit_offer/{id}', 'WalletCreditOffersController@delete');
        });

        Route::group(['middleware' => ['authenticate:admin,client']], function () {

            Route::get('wallet_credit_offer', 'WalletCreditOffersController@get');
            Route::get('wallet_history', 'WalletHistoryController@get');
        });
    });



    Route::get('setting', 'SettingsController@get');
});



// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {

//     return $request->user();
// });
