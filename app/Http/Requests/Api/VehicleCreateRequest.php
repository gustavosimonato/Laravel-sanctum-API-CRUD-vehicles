<?php

namespace App\Http\Requests\Api;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class VehicleCreateRequest extends FormRequest
{
    public function rules()
    {
        return [
            'manufacturer' => 'required|string|max:191',
            'model' => 'required|string|max:191',
            'year' => 'required|string|max:20',
            'color' => 'required|string|max:20',
            'plate' => 'required|string|max:20',
            'type' => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            'manufacturer.required' => 'O campo fabricante é obrigatório.',
            'model.required' => 'O campo modelo é obrigatório.',
            'year.required' => 'O campo ano é obrigatório.',
            'color.required' => 'O campo cor é obrigatório.',
            'plate.required' => 'O campo placa é obrigatório.',
            'type.required' => 'O campo tipo é obrigatório.',
            'manufacturer.string' => 'O campo fabricante deve ser uma string.',
            'model.string' => 'O campo modelo deve ser uma string.',
            'year.string' => 'O campo ano deve ser uma string.',
            'year.max' => 'O ano não pode ter mais de :max caracteres.',
            'color.string' => 'O campo cor deve ser uma string.',
            'plate.string' => 'O campo placa deve ser uma string.',
            'type.string' => 'O campo tipo deve ser uma string.',
            'manufacturer.max' => 'O campo fabricante não pode ter mais de :max caracteres.',
            'model.max' => 'O campo modelo não pode ter mais de :max caracteres.',
            'color.max' => 'O campo cor não pode ter mais de :max caracteres.',
            'plate.max' => 'O campo placa não pode ter mais de :max caracteres.',
        ];
    }


    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => 'Validation errors',
            'data' => $validator->errors()
        ], 417));
    }
}
