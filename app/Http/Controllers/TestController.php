<?php

namespace App\Http\Controllers;

use App\Http\Traits\NotificationTrait;
use App\Models\Notification;
use App\Http\Controllers\Controller;



class TestController extends Controller
{

    use NotificationTrait;
    public function __construct()
    {
        // $this->model="App\Models\Notification";
        // $this->User="App\Models\User";
    }

    public function index(){
        #TODO complete
        $this->lang();
        $notifications= Notification::with(["region:id,$this->locale"])
        ->get();
        return view('admin.notifications.index',compact('notifications'));
    }

    public function create(){
        $this->lang();
        $sellers=[];
        $products=[];
        // $regions = City::whereNotNull('parent_id')->get(['id',$this->locale]);
        // return view('admin.notifications.add',compact('sellers','products','regions'));
    }

    // public function store(AddNotificationRequest $request){
    //      $data=$request->validated();
    //     Notification::create($data);
    //     $notification=
    //     [
    //         'type' => "1",
    //         'title' => $request->name_ar,
    //         'title_en' => $request->name_en,
    //         'message' => $request->description_ar,
    //         'message_en' => $request->description_en,
    //         'region_id' =>$request->region_id ,

    //     ];
    //     $subscribers=[];
    //     if($request->region_id){
    //         $subscribers = User::whereCityId($request->region_id)->whereNotNull('device_id')->pluck('device_id');
    //     }
    //     $this->sendNotification($data_send=$notification,$subscribers);
    //     return  to_route('admin.notifications.index')->with('success',trans('lang.created'));
    // }

    public function destroy(Request $request){
        Notification::destroy($request->id);
        return  to_route('admin.notifications.index')->with('success',trans('lang.deleted'));
    }

    public function update(EditRequest $request,$id){
    // return "here";
    $data=$request->validated();
    // if($user->subscription_end_date<now()){
    //     $data['active']=0;
    // }
    $user=User::find($request->id);
    $user->update($data);
    // $user->syncRoles([$request->role_id]);

    if($request->active==1){

        $notification=
        [
            'type' => "1",
            'title' => "حالة المستخدم",
            'title_en' => "User status",
            'message' => "تم تنشيط حسابكم",
            'message_en' => "Your account has been activated",
        ];
        $subscribers=[$user->device_id];

        $this->sendNotification($data_send=$notification,$subscribers);
    }
    elseif($request->active==2){

        $notification=
        [
            'type' => "1",
            'title' => "حالة المستخدم",
            'title_en' => "User status",
            'message' => "تم ايقاف حسابكم مؤقتا الرجاء التواصل مع الدعم",
            'message_en' => "Your account is temporarily suspended. Please contact support",
        ];
        $subscribers=[$user->device_id];

        $this->sendNotification($data_send=$notification,$subscribers);

    }

    return  to_route('admin.clients')->with('success',trans('lang.updated'));
}

}

