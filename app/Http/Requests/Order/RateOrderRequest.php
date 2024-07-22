<?php

namespace App\Http\Requests\Order;

use App\Http\Traits\ResponsesTrait;
use App\Rules\ClientOrderRateRules;
use App\Http\Traits\LoggedInUserTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class RateOrderRequest extends FormRequest
{

    use ResponsesTrait;
    use LoggedInUserTrait;
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
        $loggedInUser = $this->getLoggedInUser();

        return
            [
                'comment'  =>  'sometimes|nullable|string',

                'order_id' => [
                    'required',
                   new ClientOrderRateRules()
                ],

                'rates'                             =>  'required|array',
                'rates.*.base_orders_rate_id'       =>  'required|exists:base_orders_rates,id',
                'rates.*.value'                     =>  'required|integer|min:1|max:5',

            ];
    }

    public function messages(): array
    {

        return [];
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
