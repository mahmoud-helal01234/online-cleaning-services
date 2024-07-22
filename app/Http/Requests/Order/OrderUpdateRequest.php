<?php

namespace App\Http\Requests\Order;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Http\Traits\ResponsesTrait;

class OrderUpdateRequest extends FormRequest
{

    use ResponsesTrait;

    protected $orderRules;
    protected $orderMessages;

    protected $orderId;

    public function __construct($orderId = null)
    {
        $orderId ??= request('id');
         $this->orderRules = [

            'id'    =>  'required|exists:orders,id',
            'type'      =>  'required|in:easy,items',
            'content'   =>  request('type') == 'easy' ? 'required|string|max:500' : ''

        ];

        $this->orderMessages = [

        ] ;
    }

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
