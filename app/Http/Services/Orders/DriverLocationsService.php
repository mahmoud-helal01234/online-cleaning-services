<?php

namespace App\Http\Services\Orders;

use App\Models\OrderLocation;
use App\Models\DriverLocation;
use App\Http\Traits\DistanceTrait;
use App\Http\Traits\ResponsesTrait;
use App\Http\Services\Orders\OrdersService;
use App\Http\Traits\LoggedInUserTrait;
use App\Models\OrderLocationStopPoint;
use Illuminate\Support\Facades\Schema;
use App\Models\DriverLocationStopPoint;
use Illuminate\Http\Exceptions\HttpResponseException;

class DriverLocationsService
{

    use ResponsesTrait, DistanceTrait;
    use LoggedInUserTrait;

    public function get($driverId = null)
    {

        $user = $this->getLoggedInUser();
        $data = [];
        $data['locations'] = DriverLocation::with(['stopPoint', 'driver']);
        $data['orders_locations'] = OrderLocation::with(['stopPoint', 'order', 'driver']);

        switch ($user->role) {

            case "admin":

                $data['locations'] = $data['locations']
                    ->when($driverId != null, function ($query) use ($driverId) {
                        $query->where('driver_id', $driverId);
                    });
                $data['orders_locations'] = $data['orders_locations']
                    ->when($driverId != null, function ($query) use ($driverId) {
                        $query->where('driver_id', $driverId);
                    });
                break;

            case "drivers_manager":
            case "company":

                $data['locations'] = $data['locations']
                    ->when($driverId != null, function ($query) use ($driverId) {
                        $query->where('driver_id', $driverId);
                    })
                    ->whereHas('driver', function ($query) use ($user) {
                        $query->where('manager_id', $user->id);
                    });

                $data['orders_locations'] = $data['orders_locations']->when($driverId != null, function ($query) use ($driverId) {
                    $query->where('driver_id', $driverId);
                })->whereHas('driver', function ($query) use ($user) {
                    $query->where('manager_id', $user->id);
                });
                break;

            case "driver":


                $data['locations'] = $data['locations']->where('driver_id', $user->id);
                $data['orders_locations'] = $data['orders_locations']
                    ->when($driverId != null, function ($query) use ($user) {
                        $query->where('driver_id', $user->id);
                    });
                break;
        }

        $data['locations'] = $data['locations']->orderBy('created_at', 'DESC')->get();
        $data['orders_locations'] = $data['orders_locations']->orderBy('created_at', 'DESC')->get();

        return $data;
    }

    public function getById($id)
    {

        $driverLocation = DriverLocation::find($id);

        if ($driverLocation == null)

            throw new HttpResponseException($this->apiResponse(null, false, __('validation.not_exist')));
        return $driverLocation;
    }

    public function create($location)
    {
        try {
            $user = $this->getLoggedInUser();
            if ($user->role == "driver")
                $location['driver_id'] = $user->id;
            $ordersService = new OrdersService();
            $order = $ordersService->driverOrderInDeliveryOrPickup($user->id);

            if ($order == null) {

                $latestLocation = DriverLocation::where('driver_id', $location['driver_id'])->latest()->first();

                if ($latestLocation != null) {

                    $distance = $this->calculateDistanceInMeters($latestLocation->lat, $latestLocation->long, $location['lat'], $location['long']);
                    $time = $latestLocation->created_at->diffInSeconds(now());

                    if ($time < 10){

                        //return;
                    //  he should take 40 meters per every 10 seconds, assuming his speed is 15 km / h .
                    }

                    else if ($distance < 40) {

                        $this->handleStopPoint($latestLocation, $location, $distance, $time, "driver");
                       //return;
                    }
                }
                //dd($location);
                DriverLocation::create($location);
            } else {

                $latestLocation = OrderLocation::where('driver_id', $location['driver_id'])->latest()->first();

                if ($latestLocation != null) {

                    $distance = $this->calculateDistanceInMeters($latestLocation->lat, $latestLocation->long, $location['lat'], $location['long']);
                    $time = $latestLocation->created_at->diffInSeconds(now());

                    if ($time < 10)
                        return;
                    //  he should take 40 meters per every 10 seconds, assuming his speed is 15 km / h .

                    else if ($distance < 40) {

                        $this->handleStopPoint($latestLocation, $location, $distance, $time, "order");
                        return;
                    }
                }
                $location['order_id'] = $order['id'];
                $location['status'] = $order['status'];

                OrderLocation::create($location);
            }
        } catch (\Exception $ex) {

            throw new HttpResponseException($this->apiResponse(status: false));
        }
    }


    // uncomment when get the Distance Matrix API key
    private function handleStopPoint($latestLocation, $newLocation, $distance, $time, $locationType)
    {

        // Estimate travel time based on current traffic conditions

        // $response = Http::get('https://maps.googleapis.com/maps/api/distancematrix/json', [
        //     'origins' => $latestLocation->lat . ',' . $latestLocation->long,
        //     'destinations' => $newLocation['lat'] . ',' . $newLocation['long'],
        //     'mode' => 'driving',
        //     'departure_time' => $latestLocation->created_at,
        //     'traffic_model' => 'best_guess',
        //     'key' => 'YOUR_API_KEY',
        // ]);

        // $estimated_travel_time = $response['rows'][0]['elements'][0]['duration']['value'];

        // Compare estimated and actual travel times to determine if the driver was stopped due to traffic

        // if ($time > $estimated_travel_time) {
        //     // The driver was likely stopped due to traffic
        if ($locationType == "driver") {
            DriverLocationStopPoint::updateOrCreate(
                ['driver_location_id' => $latestLocation->id],
                [
                    'to_at' => now(),
                    'reason' => 'traffic',
                ]
            );
        } else {
            // order Location
            OrderLocationStopPoint::updateOrCreate(
                ['order_location_id' => $latestLocation->id],
                [
                    'to_at' => now(),
                    'reason' => 'traffic',
                ]
            );
        }
        // } else {
        //     // The driver was likely not stopped due to traffic
        // if ($locationType == "driver") {
        //     DriverLocationStopPoint::updateOrCreate(
        //         ['driver_location_id' => $latestLocation->id],
        //         [
        //             'to_at' => now(),
        //             'reason' => 'not_traffic',
        //         ]
        //     );
        // } else {
        //     // order Location
        //     OrderLocationStopPoint::updateOrCreate(
        //         ['order_location_id' => $latestLocation->id],
        //         [
        //             'to_at' => now(),
        //             'reason' => 'not_traffic',
        //         ]
        //     );
        // }

        // }

    }

    public function delete($id)
    {

        $driverLocation = $this->getById($id);
        try {

            $driverLocation->delete();
        } catch (\Exception $ex) {

            throw new HttpResponseException($this->apiResponse(null, false, __('validation.cannot_delete')));
        }
    }

    public function deleteAll()
    {

        Schema::disableForeignKeyConstraints();
        DriverLocationStopPoint::query()->truncate();
        DriverLocation::query()->truncate();
        Schema::enableForeignKeyConstraints();

    }
}
