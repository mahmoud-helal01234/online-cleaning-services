<?php

namespace App\Http\Requests\MainCategory;

use App\Http\Traits\ResponsesTrait;
use App\Http\Traits\LoggedInUserTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use App\Http\Constants\FormRequestRulesConstant;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateRequest extends FormRequest
{
    use ResponsesTrait,  LoggedInUserTrait;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    // private $loggedInUser;
    // private $categoriesService;

    public function __construct()
    {

        // $this->loggedInUser = $this->getLoggedInUser();
        // $this->categoriesService = new CategoriesService();
    }
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

            'id'                    =>  'required|numeric', // checked for existence inside
            'name_ar'               =>  'sometimes|nullable|string',
            'name_en'               =>  'sometimes|nullable|string',
            'have_sub_categories'   =>  'sometimes|nullable|in:0,1',
            'img_path'              =>  'sometimes|nullable|' . FormRequestRulesConstant::ImageValidation,
        ];
    }
    public function messages(): array
    {

        return [
            'id.required'      => __('validation.id.required'),
            'id.exists'        => __('validation.id.exists'),
            'name_ar.required'          => __('validation.name_ar.required'),
            'name_en.required'          => __('validation.name_en.required'),
            'have_sub_categories.required' => __('validation.have_sub_categories.required'),
            'img_path.required'         => __('validation.img_path.required'),
            'parent_id.exists'          => __('validation.parent_id.exists')
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
