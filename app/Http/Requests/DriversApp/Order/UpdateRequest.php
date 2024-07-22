<?php

namespace App\Http\Requests\DriversApp\Order;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Http\Traits\ResponsesTrait;

class UpdateRequest extends FormRequest
{

    use ResponsesTrait;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {

        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {

        return [
            'order_id'                       => 'required|numeric|exists:drivers_app_orders,order_id',
            'drivers_app_client_id'          => 'required|numeric|exists:drivers_app_clients,id',
            'delivery_type'                  => 'sometimes|string',
            // 'pickup_driver_id'            => 'sometimes|nullable|numeric|exists:drivers,user_id',
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
            'order_id.required'  =>  __('validation.id.required'),
            'order_id.exists'  =>  __('validation.id.exists'),
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
