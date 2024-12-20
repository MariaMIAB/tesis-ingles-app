<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
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
        $rules = [
            'name' => 'required|max:255',
            'email' => [
                'required', 'email', 'max:255',
                Rule::unique('users')->ignore($this->route('user')->id)
            ],
            'avatar' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'role' => 'required|in:Administrador,Profesor,Estudiante,Inabilitado,Exanenes-cancelados,Actividades-canelados'
        ];

        if ($this->input('role') === 'Estudiante') {
            $rules['year'] = 'required|exists:years,id';
        }

        return $rules;
    }
}
