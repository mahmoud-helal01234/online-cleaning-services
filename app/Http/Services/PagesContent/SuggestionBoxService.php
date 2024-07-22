<?php

namespace App\Http\Services\PagesContent;

use App\Models\SuggestionBox;
use App\Http\Traits\ResponsesTrait;
use App\Http\Traits\FileUploadTrait;
use Illuminate\Http\Exceptions\HttpResponseException;

class SuggestionBoxService {

    use ResponsesTrait;
    use FileUploadTrait;

    public function get(){

        $suggestionContent = SuggestionBox::all();

        return $suggestionContent;
    }
    public function getById($id)
    {

        $suggestionContent = SuggestionBox::find($id);
        if ($suggestionContent == null)
            throw new HttpResponseException($this->apiResponse(null, false, __('validation.not_exist')));
        return $suggestionContent;
    }

    public function create($suggestionContent){


        try{
            $createdSuggestionContent = SuggestionBox::create($suggestionContent);
            return $createdSuggestionContent;

        }catch(\Exception $ex){

            throw new HttpResponseException($this->apiResponse(status:false));
        }
    }
    public function delete($id){

        $suggestionContent = $this->getById($id);

        try{

            $suggestionContent->delete();
        } catch(\Exception $ex){

            throw new HttpResponseException($this->apiResponse(null, false, __('validation.cannot_delete')));
        }
    }

}
