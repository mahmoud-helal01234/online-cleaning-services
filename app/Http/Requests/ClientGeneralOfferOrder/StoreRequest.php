<?php

namespace App\Http\Requests\ClientGeneralOfferOrder;

use App\Http\Traits\LoggedInUserTrait;
use Carbon\Carbon;
use Illuminate\Validation\Rule;
use App\Http\Traits\ResponsesTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreRequest extends FormRequest
{

    use ResponsesTrait;
    use LoggedInUserTrait;

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

        $user = $this->getLoggedInUser();
        switch($user->role){
            case "admin":
                return [

                    'content' =>             'required|string|max:300',
                    'general_offer_id' =>    ['required', Rule::exists('general_offers','id')->where(function ($q) {

                            // $q->where('from','<=', Carbon::now())->where('to','>=',Carbon::now());
                        })],
                    'client_id' =>  'required|exists:clients,id'
                ];

            case "client":
                $this->merge(['client_id'=> $user->id]);
                return [

                    'content' =>             'required|string|max:300',
                    'general_offer_id' =>            ['required', Rule::exists('general_offers','id')->where(function ($q) {

                            $q->where('from','<=', Carbon::now())->where('to','>=',Carbon::now());
                        })],
                        'client_id' =>  'required|exists:clients,id'
                ];
        }


    }

    public function messages(): array {

        return [

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



