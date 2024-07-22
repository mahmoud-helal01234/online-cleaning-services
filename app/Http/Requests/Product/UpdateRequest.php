<?php

namespace App\Http\Requests\Product;

use App\Http\Traits\ResponsesTrait;
use App\Http\Services\Products\ProductsService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use App\Http\Constants\FormRequestRulesConstant;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateRequest extends FormRequest
{

    use ResponsesTrait;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    //private $loggedInUser;
    private $productsService;

    public function __construct()
    {

        //$this->loggedInUser = $this->getLoggedInUser();
        $this->productsService = new ProductsService();
    }
    public function authorize()
    {

        return $this->productsService->canUserUpdate(request('id') );
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {

        return [

            'id'        => 'required|numeric',
            'name_ar' =>             'required|string',
            'name_en' =>             'required|string',
            'img_path'    =>  "sometimes|".FormRequestRulesConstant::ImageValidation,
            'options'     =>  'required|array',
            'options.*.name_ar'     =>  'required|string|max:50',
            'options.*.name_en'     =>  'required|string|max:50',
            'options.*.price_unit_ar'     =>  'required|string|max:50',
            'options.*.price_unit_en'     =>  'required|string|max:50',
            'options.*.price'     =>  'required|numeric|min:0',
            'options.*.active'     =>  'sometimes|numeric|in:0,1'

        ];
    }

    public function messages(): array {

        return [
            'id.required'  =>  __('validation.id.required'),
            'id.exists'  =>  __('validation.id.exists'),
            'name_ar.required'  => __('validation.name_ar.required'),
            'name_en.required'  => __('validation.name_en.required'),
            'category_id.required'  => __('validation.id.required'),
            'category_id.exists'  => __('validation.id.exists'),
            'company_id.required'  => __('validation.id.required'),
            'company_id.exists'  => __('validation.id.exists'),
            'img_path.required'       => __('validation.img_path.required'),

            'options.*.name_ar.required'  => __('validation.name_ar.required'),
            'options.*.name_en.required'  => __('validation.name_en.required'),
            'options.*.price_unit_ar.required'  => __('validation.price_unit_ar.required'),
            'options.*.price_unit_en.required'  => __('validation.price_unit_en.required'),
            'options.*.price.required'  => __('validation.options.price.required'),
            'options.*.active.in' => __('validation.active.in')
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
