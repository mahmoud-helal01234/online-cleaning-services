<?php

namespace App\Http\Requests\ClientGeneralOfferOrder;

use Illuminate\Validation\Rule;
use App\Http\Traits\ResponsesTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

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
            'id'                =>  'required|exists:client_general_offer_orders,id',
            'content' =>             'required|string|max:300',
            'general_offer_id' =>            ['required', Rule::exists('general_offers','id')->where(function ($q) {

                    // $q->where('from','<=', Carbon::now())->where('to','>=',Carbon::now());
                })],
            'status'    =>  'required|in:waiting,done'
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

        throw new HttpResponseException($this->apiResponse(data: null, status: false, message: __('auth.authorization.not_authorized')));
    }
}
