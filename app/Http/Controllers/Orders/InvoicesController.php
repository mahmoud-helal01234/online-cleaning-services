<?php

namespace App\Http\Controllers\Orders;

use App\Http\Traits\ResponsesTrait;
use App\Http\Traits\FileUploadTrait;
use App\Http\Services\Orders\InvoicesService;
use App\Http\Requests\Invoice\StoreRequest;
use App\Http\Requests\Invoice\UpdateRequest;
use App\Http\Controllers\Controller;

class InvoicesController extends Controller
{

    use ResponsesTrait;
    use FileUploadTrait;

    private $invoicesService;
    public function __construct()
    {

        $this->invoicesService = new InvoicesService();
    }

    public function get()
    {

        $invoices = $this->invoicesService->get(clientOrderId:request('order_id')); // request('payment_status'),request('name'),request('phone'),request('id')
        return $this->apiResponse($invoices);
    }
/*
    public function getByLinkKey($linkKey)
    {


        $invoice = $this->invoicesService->getByLinkKey($linkKey);
        return $this->apiResponse($invoice);
    }
*/
    public function getClients()
    {

        $invoice = $this->invoicesService->getClients(request('name'),request('phone'));
        return $this->apiResponse($invoice);
    }

    public function create(StoreRequest $request)
    {

        $invoice = $request->validated();
        $this->invoicesService->create($invoice);
        return $this->apiResponse();
    }

    public function update(UpdateRequest $request)
    {

        $invoice = $request->validated();
        $this->invoicesService->update($invoice);
        return $this->apiResponse();
    }

    public function updateInvoiceProvider($invoiceId,$providerId = null)
    {

        $this->invoicesService->updateInvoiceProvider($invoiceId,$providerId);
        return $this->apiResponse();
    }

    public function delete($id)
    {

        $this->invoicesService->delete($id);
        return $this->apiResponse(null, true, __('deleted'));
    }

}

