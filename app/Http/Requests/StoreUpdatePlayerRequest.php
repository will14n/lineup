<?php

namespace App\Http\Requests;

use App\Enums\PlayerPosition;
use App\Enums\PlayerSkill;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class StoreUpdatePlayerRequest extends FormRequest
{
    protected $errorBag = false;
    protected $error = false;
    protected $stopOnFirstFailure = true;

    public function authorize()
    {
        return true;
    }

    public function attributes()
    {
        return [
            'playerskills.*.skill' => 'skill',
            'playerskills.*.value' => 'value',
        ];
    }

    public function rules()
    {
        return [
            'name' => 'required',
            'position' => [
                'required',
                new Enum(PlayerPosition::class)
            ],
            'playerskills.*.skill' => [
                'required',
                new Enum(PlayerSkill::class)
            ],
            'playerSkills.value' => [
                'nullable'
            ]
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Invalid value for name: :input',
            'position' => [
                'required' => 'Invalid value for position: :input',
                'Illuminate\Validation\Rules\Enum' => 'Invalid value for position: :input',
            ],
            'playerskills.*.skill' => [
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
