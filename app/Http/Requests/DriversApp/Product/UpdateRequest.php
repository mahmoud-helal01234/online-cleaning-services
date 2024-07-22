<?php

namespace App\Http\Requests\DriversApp\Product;

use App\Http\Traits\ResponsesTrait;
use App\Http\Traits\LoggedInUserTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use App\Http\Constants\FormRequestRulesConstant;
use App\Http\Services\DriversApp\ProductsService;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateRequest extends FormRequest
{

    use ResponsesTrait, LoggedInUserTrait;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {

        // products not clients
        $driversAppProductsService = new ProductsService();
        return $driversAppProductsService->canUserUpdateProduct($this->getLoggedInUser(),request('id'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {

        return [

            'id'        =>  'required', // |exists:products,id in authorize
            'name'      =>  'required|string|max:100',
            'img_path' => 'sometimes|' .FormRequestRulesConstant::ImageValidation,
            'options'     =>  'required|array',
            'options.*.name'     =>  'required|string|max:100',
            'options.*.price'     =>  'required|numeric'
        ];
    }

    public function messages(): array {

        return [
            'id.required'  =>  __('validation.id.required'),
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
