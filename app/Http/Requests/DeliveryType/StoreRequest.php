<?php

namespace App\Http\Requests\DeliveryType;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Http\Traits\ResponsesTrait;

class StoreRequest extends FormRequest
{
    use ResponsesTrait;

    // protected $stopOnFirstFailure = true;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {

        // authorize user
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

            'name_ar'           =>  'required|string',
            'name_en'           =>  'required|string',
            'description_ar'    =>  'required|string',
            'description_en'    =>  'required|string',
            'after_hours'       =>  'required|numeric',
            "added_value_type"  =>  'required|string|in:percentage,constant',
            "added_value"       =>  'required|numeric',
            'active'          => 'sometimes|numeric|in:0,1'
        ];
    }

    public function messages(): array {

        return [
            'name_ar.required'  => __('validation.name_ar.required'),
            'name_en.required'  => __('validation.name_en.required'),
            'description_ar.required'  => __('validation.description_ar.required'),
            'description_en.required'  => __('validation.description_en.required'),
            'after_hours.required'  => __('validation.after_hours.required'),
            'added_value_type.required'  => __('validation.added_value_type.required'),
            'added_value.required'  => __('validation.added_value.required'),
            'active.in'  => __('validation.active.in'),
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



