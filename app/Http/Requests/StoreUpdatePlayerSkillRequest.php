<?php

namespace App\Http\Requests;

use App\Enums\PlayerSkill;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class StoreUpdatePlayerSkillRequest extends FormRequest
{
    protected $stopOnFirstFailure = true;

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'skill'  => [
                'required',
                new Enum(PlayerSkill::class)
            ],
            'value' => [
                'nullable'
            ]
        ];
    }

    public function messages()
    {
        return [
            'skill' => [
                'required' => 'Invalid value for skill: :input',
                'Illuminate\Validation\Rules\Enum' => 'Invalid value for skill: :input',
            ]
        ];
    }


    public function failedValidation(Validator $validator)
    {
        if ($this->wantsJson()) {

            $val = $validator->errors();
            $response = response()->json([
                'message' => current($val->toArray())[0]
            ], Response::HTTP_BAD_REQUEST);
        }

        throw (new ValidationException($validator, $response))
            ->errorBag($this->errorBag)
            ->redirectTo($this->getRedirectUrl());
    }

    public function errors()
    {
        return $this->validator->errors()->messages();
    }
}
