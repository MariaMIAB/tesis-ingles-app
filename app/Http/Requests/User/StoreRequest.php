<?php

namespace App\Http\Requests\User;

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
    public function rules()
    {
        $rules = [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed',
            'avatar' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'role' => 'required|in:Administrador,Profesor,Estudiante,Inabilitado,Exanenes-cancelados,Actividades-canelados'
        ];
    
        if ($this->input('role') === 'Estudiante') {
            $rules['year'] = 'required|exists:years,id';
        }
    
        return $rules;
    }

       /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'password.confirmed' => 'Las contraseñas no coinciden.',
        ];
    }
}
