<?php

namespace App\Http\Services\PagesContent;

use App\Http\Traits\LoggedInUserTrait;
use App\Models\ClientFeedback;
use App\Http\Traits\ResponsesTrait;
use App\Http\Traits\FileUploadTrait;
use Illuminate\Http\Exceptions\HttpResponseException;

class ClientFeedbackService {

    use ResponsesTrait;
    use FileUploadTrait;
    use LoggedInUserTrait;

    public function get(){

        $clientFeedback = ClientFeedback::get();

        return $clientFeedback;
    }

    public function getById($id){

        $baseCompaniesRate = ClientFeedback::find($id);

        if($baseCompaniesRate == null)
            throw new HttpResponseException($this->apiResponse(null, false, __('validation.not_exist')));

        return $baseCompaniesRate;
    }

    public function create($baseCompaniesRate){


        try{
            $baseCompaniesRate['client_id'] = $this->getLoggedInUser()->id;
            ClientFeedback::create($baseCompaniesRate);


        }catch(\Exception $ex){

            throw new HttpResponseException($this->apiResponse(status:false));;
        }
    }

    public function update($newClientFeedback){

        $clientFeedback = $this->getById($newClientFeedback['id']);
        if ($clientFeedback->client_id != $this->getLoggedInUser()->id)
        throw new HttpResponseException($this->apiResponse(null, false, __('validation.feedback')));
        try{

            $clientFeedback->update($newClientFeedback);

        }catch(\Exception $ex){

            throw new HttpResponseException($this->apiResponse(status:false));;
        }
    }

    public function delete($id){

        $baseCompaniesRate = $this->getById($id);

        try{

            $baseCompaniesRate->delete();
        } catch(\Exception $ex){

            throw new HttpResponseException($this->apiResponse(null, false, __('validation.cannot_delete')));
        }
    }

}
