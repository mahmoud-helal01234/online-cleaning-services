<?php

namespace App\Http\Services\Products;

use Exception;
use App\Models\Option;
use App\Http\Traits\ResponsesTrait;
use Illuminate\Support\Facades\Log;
use App\Http\Traits\FileUploadTrait;
use App\Http\Traits\LoggedInUserTrait;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Http\Services\Products\CompaniesOptionsService;

class OptionsService
{

    use ResponsesTrait;
    use FileUploadTrait;
    use LoggedInUserTrait;

    private $companiesOptionsService;
    private $proudctsService;
    
    public function get()
    {

        Log::info("start get options");

        $options = Option::get();
        return $options;
    }





    public function getById($id)
    {

        Log::info("start get option by id");


        $option = Option::find($id);

        if ($option == null)
            throw new HttpResponseException($this->apiResponse(null, false, __('validation.not_exist')));
        return $option;
    }



    public function create($option)
    {

        try {
            Log::info("start create option");

            return Option::create($option);
        } catch (\Exception $ex) {

            throw new HttpResponseException($this->apiResponse(status: false));;
        }
    }


    public function update($newOption)
    {

        Log::info("start update option");

        $option = $this->getById($newOption['id']);


        try {
            $option->update($newOption);
            return $option;
        } catch (\Exception $ex) {

            throw new HttpResponseException($this->apiResponse(status: false));;
        }
    }

    // public function toggleActivation($id, $activationStatus)
    // {

    //     Log::info("start toggleActivation option");

    //     $option = $this->getById($id);
    //     try {

    //         $option->update(['active' => $activationStatus]);
    //     } catch (\Exception $ex) {

    //         throw new HttpResponseException($this->apiResponse(status: false));;
    //     }
    // }

    public function delete($id)
    {

        Log::info("start delete option");

        $option = $this->getById($id);

        try {

            $option->delete();

        } catch (\Exception $ex) {

            throw new HttpResponseException($this->apiResponse(null, false, __('validation.cannot_delete')));
        }
    }

}
