<?php

namespace App\Http\Requests\Driver;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Http\Traits\ResponsesTrait;

class ClientRateDriver extends FormRequest
{
    use ResponsesTrait;

    // protected $stopOnFirstFailure = true;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {

        // authorize user
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        return [

            'base_drivers_rates_id'    =>  'required|exists:base_drivers_rates,id',
            'driver_id'                =>  'required|exists:drivers,user_id',
            'value'                     =>  'required|numeric|between:0,10'

        ];
    }

    public function messages(): array
    {

        return [
            'base_drivers_rates_id.required'  =>  __('validation.id.required'),
            'base_drivers_rates_id.exists'  =>  __('validation.id.exists'),
            'driver_id.required'  =>  __('validation.id.required'),
            'driver_id.exists'  =>  __('validation.id.exists'),
            'value.required'  =>  __('validation.value.required'),
            'value.numeric'  =>  __('validation.value.numeric'),
            'value.between'  =>  __('validation.value.between'),
        ];
    }

    public function failedValidation(Validator $validator)
    {

        throw new HttpResponseException($this->apiResponse(null, false, $validator->errors()->first()));
    }

    public function failedAuthorization()
    {

        throw new HttpResponseException($this->apiResponse(data: null, status: false, message: __('auth.authorization.not_authorized')));
    }
}
