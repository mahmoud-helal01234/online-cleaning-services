<?php

namespace App\Http\Services\Orders;

use App\Http\Traits\LoggedInUserTrait;
use App\Http\Traits\ResponsesTrait;
use App\Models\DriversApp\Notification;
use Illuminate\Http\Exceptions\HttpResponseException;

class NotificationsService
{

    use ResponsesTrait,LoggedInUserTrait;



    public function get()
    {

        return Notification::with(['order' => function ($query){
            return $query->with(['clientOrder.client','driversAppOrder.client']);
        }])->where('user_id', $this->getLoggedInUser()->id )->get();
    }

    public function getById($id)
    {

        $notification = Notification::find($id);
        if ($notification == null)
            throw new HttpResponseException($this->apiResponse(null, false, __('validation.not_exist')));
        return $notification;
    }

    public function create($notification)
    {

        try {
            $createdNotification = Notification::create($notification);
            return $createdNotification;
        } catch (\Exception $ex) {

            throw new HttpResponseException($this->apiResponse(status:false));
        }
    }

    public function delete($id)
    {

        $notification = $this->getById($id);

        $this->canUserDeleteNotification($this->getLoggedInUser(),$notification);
        try {

        $notification->delete();
    } catch (\Exception $ex) {

            throw new HttpResponseException($this->apiResponse(null, false, __('validation.cannot_delete')));
    }
    }

    public function canUserDeleteNotification($user,$notification){

        if($user->role == "admin" || $user->id == $notification->user_id)
            return;
        else
            throw new HttpResponseException($this->apiResponse(status:false));

    }
}
