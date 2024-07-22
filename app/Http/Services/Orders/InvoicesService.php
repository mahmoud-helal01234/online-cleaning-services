<?php

namespace App\Http\Services\Orders;

use Exception;
use App\Models\Invoice;
use App\Models\ClientOrder;
use App\Models\InvoiceItem;
use Illuminate\Support\Facades\DB;
use App\Http\Traits\ResponsesTrait;
use App\Http\Traits\LoggedInUserTrait;
use App\Http\Resources\InvoicesResource;
use App\Http\Services\Users\UsersService;
use App\Http\Services\Orders\OrdersService;
use App\Http\Services\Orders\ClientOrdersService;
use Illuminate\Http\Exceptions\HttpResponseException;

class InvoicesService
{

    use ResponsesTrait,LoggedInUserTrait;

    private $ordersService;
    private $clientOrdersService;
    private $usersService;
    public function __construct()
    {

        $this->usersService = new UsersService();
        $this->ordersService = new OrdersService();
        $this->clientOrdersService = new ClientOrdersService();

    }

    public function get($clientOrderId= null) // $whereStatus = null,$whereClientName = null,$whereClientPhone = null
    {

        $loggedInUser = $this->getLoggedInUser();

        switch($loggedInUser->role){
            case "admin":

                $invoices = Invoice::with(['items','clientOrder.order'])->when($clientOrderId != null , function($query) use($clientOrderId){
                    $query->where('client_order_id', $clientOrderId);
                })->get();
                 break;
            case 'country_manager':

            $invoices = Invoice::with(['items','clientOrder.order'])
            ->whereHas('clientOrder.company', function ($query) use($loggedInUser){
                $query->where('country_id' , $loggedInUser->countryManager->country_id);
            })
            ->when($clientOrderId != null , function($query) use($clientOrderId){
                $query->where('client_order_id', $clientOrderId);
            })->get();
                break;
            case 'company':

                $invoices = Invoice::with(['items','clientOrder.order'])
                ->whereHas('clientOrder.order', function ($query) use($loggedInUser){
                    $query->where('company_id' , $loggedInUser->id);
                })
                ->when($clientOrderId != null , function($query) use($clientOrderId){
                    $query->where('client_order_id', $clientOrderId);
                })->get();
                break;
            default:
            $invoices = Invoice::with(['items','clientOrder.order'])->where('client_id',$loggedInUser->id)->
            orderBy('created_at','desc')->withTrashed()->get();
        }


        return $invoices;
        //return InvoicesResource::collection($invoices);
    }

    public function getClients($clientName = null,$clientPhone = null) // $whereStatus = null,$whereClientName = null,$whereClientPhone = null
    {

        $loggedInUser = $this->getLoggedInUser();
            $clients = Invoice::where('user_id',$loggedInUser->id)->when($clientName != null, function ($q) use ($clientName) {
                return $q->where('client_name', 'LIKE', '%'.$clientName.'%');
            })
            ->when($clientPhone != null, function ($q) use ($clientPhone){
                return $q->where('client_phone', 'LIKE', '%'.$clientPhone.'%');
            })->select('client_name','client_phone')->distinct()->get();
            //->unique('client_name');
            //


        return $clients;
    }
/*
    public function getByLinkKey($linkKey){

        $invoice = Invoice::with('items')->where('link_key', $linkKey)->first();
        if($invoice == null)
            throw new HttpResponseException($this->apiResponse(null, false, __('validation.not_exist')));
        $total = 0;
        foreach($invoice->items as $item)
        {
            $item->total_price = $item->price * $item->quantity;
            $total += $item->price * $item->quantity;
        }

        $discount = $invoice->discount_type == "constant" ? $invoice->discount_value : $invoice->discount_value / 100 * $total;
        $invoice->sub_total = $total;
        $invoice->total = ($total - $discount) < $invoice->minimum_charge ? $invoice->minimum_charge : $total - $discount;

        if($invoice == null)
            throw new HttpResponseException($this->apiResponse(null, false, __('validation.not_exist')));

        return $invoice;
    }
*/
    public function getById($id)
    {

        $invoice = Invoice::find($id);
        if ($invoice == null)
            throw new HttpResponseException($this->apiResponse(null, false, __('validation.not_exist')));
        return $invoice;
    }

    private function getToken($length, $seed){
        $token = "";
        $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $codeAlphabet.= "0123456789";

        mt_srand($seed);      // Call once. Good since $application_id is unique.

        for($i=0;$i<$length;$i++){
            $token .= $codeAlphabet[mt_rand(0,strlen($codeAlphabet)-1)];
        }
        return $token;
    }
    public function canUserCreateInvoice($orderId){

        $user = $this->getLoggedInUser();
        switch($user->role){
            case "admin":
                return true;
            case "country_manager":
                $order = $this->ordersService->getById($orderId);
                return ($order->clientOrder->company->country_id == $user->countryManager->country_id);
            case "company":
                $order = $this->ordersService->getById($orderId);
                return ($order->clientOrder->company == $user->id);
            default:
                return false;
        }
    }
    public function create($invoice)
    {

        try {
            DB::transaction(function () use (&$invoice) {
                $createdInvoice = Invoice::create($invoice);
                if(isset($invoice['client_order_id']) && $invoice['client_order_id'] != null)
                    ClientOrder::where('order_id',$invoice['client_order_id'])->update(["invoice_id" => $createdInvoice->id]);


                foreach ($invoice['items'] as $item) {

                    InvoiceItem::create(['name' => $item['name'], 'invoice_id' => $createdInvoice->id, 'quantity' => $item['quantity'], 'price' => $item['price']]);
                }

            });
        // $loggedInUser = $this->getLoggedInUser();

        // switch($loggedInUser->role){
        //     // case "client":
        //     //     $invoice['user_id'] = $loggedInUser->id;
        //     //     DB::transaction(function () use (&$invoice) {

        //     //         $createdInvoice = Invoice::create($invoice);

        //     //         foreach ($invoice['items'] as $item) {

        //     //             InvoiceItem::create(['name' => $item['name'], 'invoice_id' => $createdInvoice->id, 'quantity' => $item['quantity'], 'price' => $item['price']]);
        //     //         }

        //     //     });
        //     case "admin":


        //         DB::transaction(function () use (&$invoice) {
        //             $createdInvoice = Invoice::create($invoice);
        //             if(isset($invoice['client_order_id']) && $invoice['client_order_id'] != null)
        //                 ClientOrder::where('order_id',$invoice['client_order_id'])->update(["invoice_id" => $createdInvoice->id]);


        //             foreach ($invoice['items'] as $item) {

        //                 InvoiceItem::create(['name' => $item['name'], 'invoice_id' => $createdInvoice->id, 'quantity' => $item['quantity'], 'price' => $item['price']]);
        //             }

        //         });
        //         break;
        //     case "company":
        //         DB::transaction(function () use (&$invoice) {

        //             $createdInvoice = Invoice::create($invoice);
        //             if(isset($invoice['client_order_id']) && $invoice['client_order_id'] != null)
        //                 ClientOrder::where('order_id',$invoice['client_order_id'])->update(["invoice_id" => $createdInvoice->id]);


        //             foreach ($invoice['items'] as $item) {

        //                 InvoiceItem::create(['name' => $item['name'], 'invoice_id' => $createdInvoice->id, 'quantity' => $item['quantity'], 'price' => $item['price']]);
        //             }
        //         });
        //         break;
        //     }

        } catch (\Exception $ex) {

            throw new HttpResponseException($this->apiResponse(null, false, $ex->getMessage()));;
        }
    }

    public function update($newInvoice)
    {
        $loggedInUser = $this->getLoggedInUser();
        $invoice = $this->getById($newInvoice['id']);

                try {

                    $invoice->update($newInvoice);
                    InvoiceItem::where('invoice_id',$newInvoice['id'])->delete();

                    foreach ($newInvoice['items'] as $item) {

                        InvoiceItem::create(['name' => $item['name'], 'invoice_id' => $newInvoice['id'], 'quantity' => $item['quantity'], 'price' => $item['price']]);
                    }

                    return $invoice;
                } catch (\Exception $ex) {

                    throw new HttpResponseException($this->apiResponse(null, false, $ex->getMessage()));;
                }
    }


    public function delete($id)
    {
        $loggedInUser = $this->getLoggedInUser();
        $invoice = $this->getById($id);

        if($this->canUserDeleteInvoice($loggedInUser, $invoice)){

            // NEW ADDED DELETE ITEMS
            InvoiceItem::where('invoice_id',$invoice['id'])->delete();
            $invoice->delete();
            ClientOrder::where('invoice_id',$invoice['id'])->update(["invoice_id" => null]);

        }else{
            throw new HttpResponseException($this->apiResponse(null, false, __('auth.authorization.not_authorized')));
        }

    }

    public function updateInvoiceProvider($invoiceId, $providerId = null)
    {

        $loggedInUser = $this->getLoggedInUser();
        $invoice = $this->getById($invoiceId);

        if($invoice->user_id != $loggedInUser->id)
            throw new HttpResponseException($this->apiResponse(null, false, __('auth.authorization.not_authorized')));
        try {
            if($providerId == null)
                $invoice->update(['provider_id' => $providerId]);
            else{
                $provider = $this->usersService->getById($providerId);
                if ( $provider->role != "provider")
                    throw new Exception();
            }
                $invoice->update(['provider_id' => $providerId]);

        } catch (\Exception $ex) {

            throw new HttpResponseException($this->apiResponse(null, false, $ex->getMessage()));;
        }
    }
    //update invoice DONE AND TESTED. :)
    public function canUserUpdateInvoice($invoiceId){

        $loggedInUser = $this->getLoggedInUser();
        $invoice = $this->getById($invoiceId);

        switch ($loggedInUser->role){
            case"admin":
                return true;
            case "company":

                foreach ($invoice->clientOrder as $clientOrder) {
                    if ($clientOrder->company_id != $loggedInUser->id) {
                        throw new HttpResponseException($this->apiResponse(null, false, __('auth.authorization.not_belong_to_you')));
                    } else if ($clientOrder->order->status == "in_delivery") {
                        throw new HttpResponseException($this->apiResponse(null, false, __('The order is in_delivery, cant be updated :(')));
                    }
                }
                break;
            case "country_manager":
                if($invoice->clientOrder->company->country_id != $loggedInUser->countryManager->country_id)
                    throw new HttpResponseException($this->apiResponse(null, false,__('auth.authorization.not_belong_to_you')));
                //  else if ($invoice->clientOrder->order->status == "in_delivery") {
                //     throw new HttpResponseException($this->apiResponse(null, false, __('The order is in_delivery, cant be updated :(')));
                // }
        }
        return false;
    }
    public function canUserDeleteInvoice($loggedInUser, $invoice){

        switch ($loggedInUser->role){
            case"admin":
                return true;
            case "company":

                if($invoice->clientOrder->company_id != $loggedInUser->id)
                    throw new HttpResponseException($this->apiResponse(null, false, __('auth.authorization.not_belong_to_you')));
                return true;

            case "country_manager":
                if($invoice->clientOrder->company->country_id != $loggedInUser->countryManager->country_id)
                    throw new HttpResponseException($this->apiResponse(null, false,__('auth.authorization.not_belong_to_you')));
                return true;
        }
    }

}
