<?php

namespace App\Http\Requests\Semester;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Year;

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
            'year_id' => 'required|exists:years,id',
            'semesters.*.start_date' => 'required|date',
            'semesters.*.end_date' => 'required|date|after:semesters.*.start_date',
        ];
    }

    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $semesters = $this->input('semesters', []);
            $year = Year::find($this->input('year_id'));

            if ($year) {
                $firstDayOfYear = new \DateTime($year->start_date);
                $lastDayOfYear = new \DateTime($year->end_date);

                if (isset($semesters[0])) {
                    $firstSemesterStart = new \DateTime($semesters[0]['start_date']);
                    $firstSemesterEnd = new \DateTime($semesters[0]['end_date']);

                    if ($firstSemesterStart < $firstDayOfYear || $firstSemesterStart > $lastDayOfYear) {
                        $validator->errors()->add('semesters.0.start_date', 'La fecha de inicio del primer semestre debe estar dentro del año seleccionado.');
                    }

                    if ($firstSemesterEnd < $firstDayOfYear || $firstSemesterEnd > $lastDayOfYear) {
                        $validator->errors()->add('semesters.0.end_date', 'La fecha de fin del primer semestre debe estar dentro del año seleccionado.');
                    }

                    if (isset($semesters[1])) {
                        $secondSemesterStart = new \DateTime($semesters[1]['start_date']);
                        $secondSemesterEnd = new \DateTime($semesters[1]['end_date']);

                        if ($secondSemesterStart <= $firstSemesterEnd) {
                            $validator->errors()->add('semesters.1.start_date', 'El segundo semestre debe comenzar después de que termine el primer semestre.');
                        }

                        if ($secondSemesterStart < $firstDayOfYear || $secondSemesterStart > $lastDayOfYear) {
                            $validator->errors()->add('semesters.1.start_date', 'La fecha de inicio del segundo semestre debe estar dentro del año seleccionado.');
                        }

                        if ($secondSemesterEnd < $firstDayOfYear || $secondSemesterEnd > $lastDayOfYear) {
                            $validator->errors()->add('semesters.1.end_date', 'La fecha de fin del segundo semestre debe estar dentro del año seleccionado.');
                        }
                    }
                }
            }
        });
    }

    /**
     * Get the custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'year_id.required' => 'El campo del año es obligatorio.',
            'year_id.exists' => 'El año seleccionado no es válido.',
            'semesters.*.start_date.required' => 'La fecha de inicio del semestre es obligatoria.',
            'semesters.*.start_date.date' => 'La fecha de inicio del semestre debe ser una fecha válida.',
            'semesters.*.end_date.required' => 'La fecha de fin del semestre es obligatoria.',
            'semesters.*.end_date.date' => 'La fecha de fin del semestre debe ser una fecha válida.',
            'semesters.*.end_date.after' => 'La fecha de fin del semestre debe ser posterior a la fecha de inicio.',
        ];
    }
}
