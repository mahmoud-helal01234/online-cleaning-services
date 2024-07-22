<?php

namespace App\Http\Services;

use App\Models\Setting;
use App\Http\Traits\ResponsesTrait;
use App\Http\Traits\FileUploadTrait;
use Illuminate\Http\Exceptions\HttpResponseException;

class SettingsService
{

    use ResponsesTrait;
    use FileUploadTrait;

    public function get()
    {

        $settings = Setting::select(
            'first_order_cash_back_value',
            'first_order_cash_back_value_type',
            'invitation_code_owner_cash_value',
            'invitation_code_owner_cash_value_type',
            'invitation_code_user_cash_value',
            'invitation_code_user_cash_value_type'
        )->first();

        return $settings;
    }

    public function update($newSetting)
    {

        $setting = Setting::first();
        try {

            $setting->update($newSetting);
            return $setting;
        } catch (\Exception $ex) {

            throw new HttpResponseException($this->apiResponse(status:false));;
        }
    }
}
