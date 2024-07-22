<?php

namespace App\Http\Requests\DriversApp\Product;

use App\Http\Traits\ResponsesTrait;
use App\Http\Traits\LoggedInUserTrait;
use App\Http\Services\DriversApp\ProductsService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use App\Http\Constants\FormRequestRulesConstant;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreRequest extends FormRequest
{
    use ResponsesTrait , LoggedInUserTrait;

    private $loggedInUser;
    private $productsService;
    public function __construct()
    {

        $this->loggedInUser = $this->getLoggedInUser();
        $this->productsService = new ProductsService();
    }

    public function authorize()
    {

        // authorize user
        // should be done in middleware
        return $this->productsService->canUserRoleCreateProduct($this->loggedInUser->role);
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        return [

            'name'      =>  'required|string|max:100',
            'img_path' => 'sometimes|' . FormRequestRulesConstant::ImageValidation,
            'options'     =>  'required|array',
            'options.*.name'     =>  'required|string|max:100',
            'options.*.price'     =>  'required|numeric'
        ];
    }

    public function messages(): array {

        return [
            'name.required'  =>  __('validation.name.required'),
            'options.*.name.required'  =>  __('validation.option.name.required'),
            'options.*.price.required'  =>  __('validation.option.price.required'),
            'options.*.price.numeric'  =>  __('validation.option.price.numeric'),
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



