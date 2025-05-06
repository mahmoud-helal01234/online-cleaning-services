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
    protected function prepareForValidation()
    {

        if ($this->has('options') && is_string($this->input('options'))) {
            $this->merge([
                'options' => json_decode($this->input('options'), true),
            ]);
        }
    }
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

        return $this->productsService->canUserUpdate(request('id'));
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
            'name_ar'           =>  'required|string',
            'name_en'           =>  'required|string',
            'category_id'       =>  "required|numeric|exists:categories,id",
            'img_path'          =>  'sometimes|' . FormRequestRulesConstant::ImageValidation,

            'options'                   =>  'required|array',
            'options.*.option_id'         =>  'required|exists:options,id',

            'options.*.price'           =>  'required|numeric|min:0'

        ];
    }

    public function messages(): array
    {

        return [];
    }

    public function failedValidation(Validator $validator)
    {

        throw new HttpResponseException($this->apiResponse(null, false, $validator->errors()->first()));
    }

    public function failedAuthorization()
    {

        throw new HttpResponseException($this->apiResponse(data: null, status: false, message: __('auth.authorization.not_authorized')));
    }
}
