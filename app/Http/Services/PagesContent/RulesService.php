<?php

namespace App\Http\Services\PagesContent;

use App\Http\Traits\ResponsesTrait;
use App\Models\Rule;
use Illuminate\Http\Exceptions\HttpResponseException;

class RulesService
{

    use ResponsesTrait;



    public function get()
    {

        $rules = Rule::get();

        return $rules;
    }

    public function getById($id)
    {

        $rule = Rule::find($id);
        if ($rule == null)
            throw new HttpResponseException($this->apiResponse(null, false, __('validation.not_exist')));
        return $rule;
    }

    public function create($rule)
    {

        try {
            $createdRule = Rule::create($rule);
            return $createdRule;
        } catch (\Exception $ex) {

            throw new HttpResponseException($this->apiResponse(status:false));;
        }
    }

    public function update($newRule)
    {

        $rule = $this->getById($newRule['id']);
        try {

            $rule->update($newRule);
            return $rule;
        } catch (\Exception $ex) {

            throw new HttpResponseException($this->apiResponse(status:false));
        }
    }

    public function toggleActivation($id, $activationStatus)
    {

        $rule = $this->getById($id);
        try {

            $rule->update(['active' => $activationStatus]);
        } catch (\Exception $ex) {

            throw new HttpResponseException($this->apiResponse(status:false));;
        }
    }

    public function delete($id)
    {

        $rule = $this->getById($id);
        try {

            $rule->delete();
        } catch (\Exception $ex) {

            throw new HttpResponseException($this->apiResponse(null, false, __('validation.cannot_delete')));
        }
    }
}
