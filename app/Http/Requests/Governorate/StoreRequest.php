<?php

namespace App\Http\Requests\Governorate;

use App\Http\Traits\ResponsesTrait;
use App\Http\Services\Countries\GovernoratesService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreRequest extends FormRequest
{
    use ResponsesTrait;

    // protected $stopOnFirstFailure = true;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    private $governoratesService;
    public function authorize()
    {
        $this->governoratesService = new GovernoratesService();

        if($this->governoratesService->canUserCreate(request('country_id')))
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
            'name_ar'           => 'required|string|unique:governorates,name_ar',
            'name_en'           => 'required|string|unique:governorates,name_en',
            'country_id'        => "required|numeric|exists:countries,id",
            'active'            => 'sometimes|numeric|in:0,1'
        ];
    }

    public function messages(): array {
        return [
            'name_ar.required' => __('validation.name_ar.required'),
            'name_en.required' => __('validation.name_en.required'),
            'country_id.required' => __('validation.id.required'),
            'country_id.exists' => __('validation.id.exists'),
            'active.in' => __('validation.active.in'),
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException($this->apiResponse(null,false,$validator->errors()->first()));
    }

    public function failedAuthorization()
    {
        throw new HttpResponseException($this->apiResponse(data: null, status: false, message: __('auth.authorization.not_authorized')));
    }


}



