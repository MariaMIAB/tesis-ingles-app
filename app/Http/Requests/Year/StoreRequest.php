<?php

namespace App\Http\Requests\Year;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255|unique:years,name',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ];
        
    }

    public function messages(): array
    {
        return [
            'name.required' => 'El nombre del año es obligatorio.',
            'name.string' => 'El nombre del año debe ser una cadena de texto.',
            'name.max' => 'El nombre del año no puede tener más de 255 caracteres.',
            'name.unique' => 'El nombre del año ya existe.',
            'start_date.required' => 'La fecha de inicio es obligatoria.',
            'start_date.date' => 'La fecha de inicio debe ser una fecha válida.',
            'start_date.after_or_equal' => 'La fecha de inicio debe ser hoy o una fecha futura.',
            'end_date.required' => 'La fecha de finalización es obligatoria.',
            'end_date.date' => 'La fecha de finalización debe ser una fecha válida.',
            'end_date.after' => 'La fecha de finalización debe ser posterior a la fecha de inicio.',
        ];
    }
}
