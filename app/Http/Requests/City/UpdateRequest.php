<?php

namespace App\Http\Requests\City;

use Illuminate\Validation\Rule;
use App\Http\Traits\ResponsesTrait;
use App\Http\Traits\LoggedInUserTrait;
use Illuminate\Foundation\Http\FormRequest;
use App\Http\Services\Countries\CitiesService;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateRequest extends FormRequest
{

    use ResponsesTrait, LoggedInUserTrait;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    private $loggedInUser;
    private $citiesService;

    public function __construct()
    {

        $this->loggedInUser = $this->getLoggedInUser();
        $this->citiesService = new CitiesService();
    }
    public function authorize()
    {

        return $this->citiesService->canUserUpdate(request('id'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {

        return [
            'id'                => 'required|numeric',
            'name_ar'           => ['sometimes', 'nullable', 'string', Rule::unique('cities', 'name_ar')->ignore(request('id'))],
            'name_en'           => ['sometimes', 'nullable', 'string', Rule::unique('cities', 'name_en')->ignore(request('id'))],
            'governorate_id'    => 'required|numeric|exists:governorates,id',
            'active'            => 'sometimes|numeric|in:0,1'
        ];
    }

    public function messages(): array {

        return [
            'id.required'      => __('validation.id.required'),
            'id.exists'        => __('validation.id.exists'),
            'name_ar.required'     => __('validation.name_ar.required'),
            'name_en.required'     => __('validation.name_en.required'),
            'governorate_id.required' => __('validation.id.required'),
            'governorate_id.exists' => __('validation.id.exists'),
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
