<?php

namespace App\Http\Requests\FrequentlyAskedQuestion;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Http\Traits\ResponsesTrait;

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
            'id' => 'required|numeric|exists:frequently_asked_questions,id',
            'question_ar' =>             'required|string|max:500',
            'question_en' =>             'required|string|max:500',
            'answer_ar' =>             'required|string|max:500',
            'answer_en' =>             'required|string|max:500',
        ];
    }

    public function messages(): array {
        return [
            'id.required' => __('validation.id.required'),
            'id.exists' => __('validation.id.exists'),
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
