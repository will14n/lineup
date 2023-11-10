<?php

namespace App\Http\Requests;

use App\Enums\PlayerPosition;
use App\Enums\PlayerSkill;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class IndexTeamRequest extends FormRequest
{
    protected $errorBag = false;
    protected $error = false;
    protected $stopOnFirstFailure = true;

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [[
                'position' => [
                    'required',
                    'distinct',
                    // new Enum(PlayerSkill::class)
                ],
                'mainSkill' => [
                    'required',
                    'distinct',
                ],
                'numberOfPlayers' => [
                    'required',
                    'distinct',
                ],
       ] ];
    }

    public function messages()
    {
        return [[
            '*.mainSkill' => [
                'distinct' => 'Invalida tests',
                'required' => 'Invalid value for name: :input',
            ],
            '*.position' => [
                'distinct' => 'Invalid value',
                'required' => 'Invalid value for position: :input',
                'Illuminate\Validation\Rules\Enum' => 'Invalid value for position: :input',
            ]
        ]];
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
