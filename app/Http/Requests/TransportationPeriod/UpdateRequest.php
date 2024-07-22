<?php

namespace App\Http\Requests\TransportationPeriod;

use App\Http\Traits\ResponsesTrait;
use App\Http\Traits\LoggedInUserTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use App\Http\Services\Orders\TransportationPeriodsService;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateRequest extends FormRequest
{
    use ResponsesTrait, LoggedInUserTrait;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {

        $transportationPeriodsService = new TransportationPeriodsService();
        return $transportationPeriodsService->canLoggedInUserUpdateTransortationPeriod(request('id'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [

            'id' => 'required', // checked in authorize
            'from' => 'required|date_format:H:i',
            'to' => 'required|date_format:H:i',
            'active' => 'sometimes|in:0,1'
        ];
    }

    public function messages(): array
    {
        return [
            'id.required' => __('vlaidation.id.required'),
            'id.exists' => __('vlaidation.id.exists'),
            'from.required' => __('vlaidation.from.required'),
            'to.required' => __('vlaidation.to.required'),
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
