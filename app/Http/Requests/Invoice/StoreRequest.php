<?php

namespace App\Http\Requests\Invoice;

use App\Http\Services\Orders\InvoicesService;
use App\Http\Traits\ResponsesTrait;
use App\Http\Traits\LoggedInUserTrait;
use App\Rules\IsOrderForThisClientRule;
use App\Rules\IsOrderBelongToCompanyRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreRequest extends FormRequest
{
    use ResponsesTrait ,LoggedInUserTrait;
    private $invoicesService;
    // protected $stopOnFirstFailure = true;
    public function __construct() {
        $this->invoicesService = new InvoicesService;
    }
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */

    public function authorize()
    {

        return $this->invoicesService->canUserCreateInvoice(request('client_order_id'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [

            'client_order_id'           =>   [(request('client_id') == null ? 'required' : 'sometimes'), 'exists:client_orders,order_id', new IsOrderForThisClientRule(request('client_id')), new IsOrderBelongToCompanyRule()],
            'client_id'                 =>   (request('client_order_id') == null ? 'required' : 'sometimes')  . '|numeric|exists:clients,id',
            'discount_value'            =>  'sometimes|nullable|numeric|min:0',
            'discount_value_type'       =>  'sometimes|nullable|in:constant,percentage',
            'tax_value_type'            =>  'sometimes|nullable|in:constant,percentage',
            'tax_value'                 =>  'sometimes|nullable|numeric|min:0',
            'minimum_charge'            =>  'sometimes|numeric|min:0|nullable',

            'items'             =>  'required|array',
            'items.*.name'      =>  'required|string|max:100',
            'items.*.quantity'  =>  'required|integer|min:1',
            'items.*.price'     =>  'required|numeric|min:1',
        ];
    }

    public function messages(): array
    {

        return [
            'client_order_id.required' => __('validation.id.required'),
            'client_order_id.exists' => __('validation.id.exists'),
            'client_id.required' => __('validation.id.required'),
            'client_id.exists' => __('validation.id.exists'),
            'discount_value_type.in' => __('validation.discount_value_type.in'),
            'tax_value_type.in' => __('validation.tax_value_type.in'),
            'items.*.name.required' => __('validation.options.name.required'),
            'items.*.quantity.required' => __('validation.options.quantity.required'),
            'items.*.price.required' => __('validation.options.price.required'),
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
