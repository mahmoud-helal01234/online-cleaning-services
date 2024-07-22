<?php

namespace App\Http\Services\Orders;

use App\Models\OrderComment;
use App\Http\Traits\ResponsesTrait;
use App\Http\Traits\FileUploadTrait;
use App\Http\Traits\LoggedInUserTrait;
use App\Http\Services\Orders\OrdersService;
use Illuminate\Http\Exceptions\HttpResponseException;

class OrderCommentsService
{

    use ResponsesTrait,LoggedInUserTrait,FileUploadTrait;

    public function get($orderId)
    {

        $loggedInUser = $this->getLoggedInUser();

        // validate if logged in user can see this order comments

        $ordersService = new OrdersService();
 
        if(!$ordersService->canUserAccessOrderDetails($loggedInUser->id,$orderId)){
            throw new HttpResponseException($this->apiResponse(status:false, message:__('validation.not_allowed')));
        }

        $comments = OrderComment::with(['user' => function ($query){
            $query->select('id','name','email','role');
        }])->where('order_id',$orderId);

        $comments = $comments->where('show_for_client',1);

        return $comments->select('id','text','img_path','show_for_client','created_at','user_id')->get();
    }

    public function getById($id)
    {

        $orderComment = OrderComment::find($id);
        if ($orderComment == null)
            throw new HttpResponseException($this->apiResponse(null, false, __('validation.not_exist')));
        return $orderComment;
    }

    public function create($orderComment)
    {

        try {

            $orderComment['user_id'] = $this->getLoggedInUser()->id;
            $createdOrderComment = OrderComment::create($orderComment);

            return $createdOrderComment;
        } catch (\Exception $ex) {

            throw new HttpResponseException($this->apiResponse(status: false));;
        }
    }

    public function update($newOrderComment)
    {

        $orderComment = $this->getById($newOrderComment['id']);
        try {

            $orderComment->update($newOrderComment);
            return $orderComment;
        } catch (\Exception $ex) {

            throw new HttpResponseException($this->apiResponse(status: false));;
        }
    }

    public function toggleShowForClient($id, $showForClient)
    {

        $orderComment = $this->getById($id);
        try {

            $orderComment->update(['show_for_client' => $showForClient]);
        } catch (\Exception $ex) {

            throw new HttpResponseException($this->apiResponse(status: false));;
        }
    }

    public function delete($id)
    {

        $orderComment = $this->getById($id);


            if(!$this->canUserEditComment($this->getLoggedInUser(),$id)){
                throw new HttpResponseException($this->apiResponse(null, false, __('validation.not_allowed')));
            }
        try {
            $imgPath = $orderComment->img_path;
            $orderComment->delete();
            $this->deleteFile($imgPath);
        } catch (\Exception $ex) {

            throw new HttpResponseException($this->apiResponse(null, false, __('validation.cannot_delete')));
        }
    }

    public function canUserEditComment($user, $commentId){


        $comment = $this->getById($commentId);

        return $user->role == "admin" || $comment->user_id == $user->id;
    }
}
