<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PrestamoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'alumno_id'      => 'required|exists:alumnos,id',
            'libro_id'       => 'required|exists:libros,id',
            'fecha_prestamo' => 'nullable|date|before_or_equal:today',
            'observaciones'  => 'nullable|string|max:500',
        ];
    }

    public function messages(): array
    {
        return [
            'alumno_id.required'             => 'El alumno es obligatorio.',
            'alumno_id.exists'               => 'El alumno seleccionado no existe.',
            'libro_id.required'              => 'El libro es obligatorio.',
            'libro_id.exists'                => 'El libro seleccionado no existe.',
            'fecha_prestamo.date'            => 'La fecha no tiene un formato válido.',
            'fecha_prestamo.before_or_equal' => 'La fecha no puede ser futura.',
            'observaciones.max'              => 'Las observaciones no pueden superar 500 caracteres.',
        ];
    }
}