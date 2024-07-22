<?php

namespace App\Http\Requests\FrequentlyAskedQuestion;

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
            'question_ar' =>             'required|string|max:500',
            'question_en' =>             'required|string|max:500',
            'answer_ar' =>             'required|string|max:500',
            'answer_en' =>             'required|string|max:500',
        ];
    }

    public function messages(): array {
        return [
            'question_ar.required' => __('validation.question_ar.required'),
            'question_en.required' => __('validation.question_en.required'),
            'answer_ar.required' => __('validation.answer_ar.required'),
            'answer_en.required' => __('validation.answer_en.required'),
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



