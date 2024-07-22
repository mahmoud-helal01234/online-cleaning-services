<?php

namespace App\Http\Requests\GeneralOffer;

use App\Http\Traits\ResponsesTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use App\Http\Constants\FormRequestRulesConstant;
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

            'from' =>             'required|date_format:Y-m-d H:i',
            'to' =>             'required|date_format:Y-m-d H:i',
            'img_path'    =>  "required|" .FormRequestRulesConstant::ImageValidation,
            'active'        =>  "sometimes|numeric|in:0,1"
        ];
    }

    public function messages(): array {

        return [
            'from.required' => __('validation.from.required'),
            'to.required' => __('validation.to.required'),
            'img_path.required' => __('validation.img_path.required'),
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



