<?php

namespace App\Http\Requests\ClientOrder;

use App\Http\Traits\ResponsesTrait;
use Illuminate\Contracts\Validation\Validator;
use App\Http\Requests\Order\OrderUpdateRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateRequest extends OrderUpdateRequest
{
    public function __construct()
    {

        parent::__construct(request('id'));
    }
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

        return array_merge($this->orderRules, [

            'id'                => 'required|numeric', // checked for existence in constructor

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
