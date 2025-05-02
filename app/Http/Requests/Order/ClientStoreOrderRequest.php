<?php

namespace App\Http\Requests\Order;

use Illuminate\Validation\Rule;
use App\Http\Traits\ResponsesTrait;
use App\Http\Traits\LoggedInUserTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ClientStoreOrderRequest extends FormRequest
{

    use ResponsesTrait, LoggedInUserTrait;

    public function authorize()
    {

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

            // "special_instructions" => "sometimes|nullable|string|max:500",
            // "location_id" => "sometimes|numeric",
            'client_name' => 'required|string|max:50',
            'phone' => 'required|string|max:15',
            'address' => 'required|string|max:500',
            'promo_code_id' => 'sometimes|nullable|exists:promo_codes,id,active,1',

            'preferred_pickup_time' => 'required|date_format:Y-m-d H:i',
            'items' => 'required|array',
            'items.*.id' =>  [
                'required',
                Rule::exists('product_options')->where(function ($query) {
                    $query->whereNull('deleted_at');
                }),
            ],
            'items.*.quantity' =>  [
                'required',

            ],

        ];
    }

    public function messages(): array
    {

        return [
            "client_name.required" => "Enter your name please"
        ];
    }

    public function failedValidation(Validator $validator)
    {

        throw new HttpResponseException($this->apiResponse(null, false, $validator->errors()->first()));
    }

    public function failedAuthorization()
    {

        throw new HttpResponseException($this->apiResponse(null, false, "not authorized to access this"));
    }
}
