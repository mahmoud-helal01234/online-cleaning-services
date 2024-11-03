<?php

namespace App\Http\Requests\ClientOrder;

use App\Http\Traits\ResponsesTrait;
use App\Http\Requests\Order\OrderStoreRequest;
use App\Http\Traits\LoggedInUserTrait;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreRequest extends OrderStoreRequest
{
    use ResponsesTrait,LoggedInUserTrait;

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


        $rulesBased = [];

        switch (request('type')) {
            case "easy":

                $rulesBased = [
                    'content' => 'required|string|max:500'
                ];
                break;
            case "items":

                $rulesBased = [

                    'items' => 'required|array',
                    'items.*.id' => ['required', 
                    'distinct', 'company_option:' . request('company_id')],
                    'items.*.quantity' => 'required|integer|min:1'
                ];
                break;
        }
        if($this->getLoggedInUserRole() != "client")
            $rulesBased['client_id'] = 'required|exists:clients,id';



        return array_merge(
            [

                'type'                      =>  'required|in:items,easy',
                'delivery_type_id'          =>  'required|exists:delivery_types,id',
                'company_id'                =>  'required|exists:companies,user_id',
                'client_location_id'        =>  'required|exists:client_locations,id'
                // 'pickup_start_date_time'    =>  "sometimes|nullable|date_format:Y-m-d H:i|after:" . Carbon::now()->addHour()->format("Y-m-d H:i") ,
                // 'pickup_end_time'           =>
                // (request('pickup_start_date_time') ?
                // "required|after:" .Carbon::createFromFormat("Y-m-d H:i",request('pickup_start_date_time'))->addMinutes(119)->
                // format("H:i"):"sometimes|nullable" ).'|date_format:H:i',
                // 'delivery_start_date_time'  =>  "sometimes|nullable|date_format:Y-m-d H:i". (request('pickup_start_date_time') ?
                // ("|after:" .Carbon::createFromFormat("Y-m-d H:i",request('pickup_start_date_time'))->addHours(23)->format("Y-m-d H:i")):""),
                // 'delivery_end_time'         =>  (request('delivery_start_date_time') ? "required|after:" .Carbon::createFromFormat("Y-m-d H:i",
                // request('delivery_start_date_time'))->addHours(2)->format("H:i"):"sometimes|nullable" ).'|date_format:H:i'
            ],
            $rulesBased
        );
    }

    public function messages(): array
    {

        return array_merge($this->orderMessages,[


        ]);
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
