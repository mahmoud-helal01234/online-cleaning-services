<?php

namespace App\Http\Requests\DriversApp\Order;

use App\Http\Traits\LoggedInUserTrait;
use App\Http\Traits\ResponsesTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreRequest extends FormRequest
{
    use ResponsesTrait,LoggedInUserTrait;

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
            'drivers_app_client_id'        => 'required|numeric|exists:drivers_app_clients,id',
            'delivery_type'                 => 'required|string',
            // 'pickup_driver_id'             => 'sometimes|nullable|numeric|exists:drivers,user_id',
            // 'delivery_driver_id'           => 'sometimes|nullable|numeric|exists:drivers,user_id',
            // 'price'                        => 'required|numeric',
            // 'comment'                      => 'sometimes|nullable',
            // 'pickup_start_time'                 => 'sometimes|nullable|date_format:H:i',
            // 'pickup_end_time'                   => 'sometimes|nullable|date_format:H:i',
            // 'pickup_date'                       => 'sometimes|nullable|date_format:Y-m-d',
            // 'delivery_start_time'               => 'sometimes|nullable|date_format:H:i',
            // 'delivery_end_time'                 => 'sometimes|nullable|date_format:H:i',
            // 'delivery_date'                     => 'sometimes|nullable|date_format:Y-m-d',

            // 'items'             =>  'required|array',
            // 'items.*.name'      =>  'required|string|max:100',
            // 'items.*.quantity'  =>  'required|integer|min:1',
            // 'items.*.price'     =>  'required|numeric|min:1',
        ];
    }


    public function messages(): array
    {

        return [
            'drivers_app_client_id.required'  =>  __('validation.id.required'),
            'drivers_app_client_id.exists'  =>  __('validation.id.exists'),
            'delivery_type.required'  =>  __('validation.delivery_type.required'),

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
