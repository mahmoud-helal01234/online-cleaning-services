<?php

namespace App\Http\Requests\City;

use App\Http\Traits\ResponsesTrait;
use App\Http\Services\Countries\CitiesService;
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
    private $citiesService;
    public function authorize()
    {
        $this->citiesService = new CitiesService();

        if($this->citiesService->canUserCreate(request('governorate_id')))
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
            'name_ar'               => 'required|string|unique:cities,name_ar',
            'name_en'               => 'required|string|unique:cities,name_en',
            'governorate_id'        => "required|numeric|exists:governorates,id",
            'active'                => 'sometimes|nullable|numeric|in:0,1'
        ];
    }

    public function messages(): array {

        return [
            'name_ar.required'     => __('validation.name_ar.required'),
            'name_en.required'     => __('validation.name_en.required'),
            'governorate_id.required' => __('validation.governorate_id.required'),
            'governorate_id.exists' => __('validation.governorate_id.exists'),
            'active.in'             => __('validation.active.in')
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



