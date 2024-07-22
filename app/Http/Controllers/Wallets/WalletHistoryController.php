<?php

// namespace App\Http\Controllers\Wallets;

// use Illuminate\Http\Request;
// use App\Http\Traits\ResponsesTrait;
// use App\Http\Controllers\Controller;
// use App\Http\Traits\FileUploadTrait;
// use App\Http\Services\Wallets\WalletHistoryService;
// use App\Http\Requests\WalletHistory\StoreRequest;
// use App\Http\Requests\WalletHistory\UpdateRequest;


// class WalletHistoryController extends Controller
// {

//     use ResponsesTrait;
//     use FileUploadTrait;

//     private $walletHistoryService;

//     public function __construct()
//     {

//         $this->walletHistoryService = new WalletHistoryService();
//     }

//     public function get(Request $request)
//     {

//         $walletHistory = $this->walletHistoryService->get($request->has('governorate_id') ? $request->get('governorate_id') : null);
//         return $this->apiResponse($walletHistory);
//     }

//     public function create(StoreRequest $request)
//     {

//         $city = $request->validated();

//         $this->walletHistoryService->create($city);

//         return $this->apiResponse();
//     }

//     public function update(UpdateRequest $request)
//     {

//         $city = $request->validated();

//         $this->walletHistoryService->update($city);

//         return $this->apiResponse();
//     }

//     public function delete($id)
//     {

//         $this->walletHistoryService->delete($id);
//         return $this->apiResponse(null, true, __('deleted'));
//     }

// }

