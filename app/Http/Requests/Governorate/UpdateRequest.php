<?php

namespace App\Http\Requests\Governorate;

use Illuminate\Validation\Rule;
use App\Http\Traits\ResponsesTrait;
use App\Http\Traits\LoggedInUserTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use App\Http\Services\Countries\GovernoratesService;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateRequest extends FormRequest
{
    use ResponsesTrait,  LoggedInUserTrait;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    private $governoratesService;
    public function authorize()
    {
        $this->governoratesService = new GovernoratesService();

        if($this->governoratesService->canUserUpdate(request('id')))
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
            'id'                => 'required|numeric',
            'name_ar'           => ['sometimes', 'nullable', 'string', Rule::unique('governorates', 'name_ar')->ignore(request('id'))],
            'name_en'           => ['sometimes', 'nullable', 'string', Rule::unique('governorates', 'name_en')->ignore(request('id'))],
            'country_id'        => 'sometimes|nullable|numeric|exists:countries,id',
            'active'            => 'sometimes|nullable|numeric|in:0,1'
        ];
    }

    public function messages(): array {

        return [
            'id.required'       => __('validation.id_required'),
            'id.exists'         => __('validation.id_exists'),
            'name_ar.required'  => __('validation.name_ar.required'),
            'name_en.required'  => __('validation.name_en.required'),
            'country_id.exists' => __('validation.id.exists'),
            'active.in'         => __('validation.active.in'),
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
