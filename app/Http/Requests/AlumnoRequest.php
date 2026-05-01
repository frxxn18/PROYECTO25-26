<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AlumnoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nombre'    => 'required|string|max:100',
            'apellidos' => 'required|string|max:150',
            'dni'       => 'nullable|string|max:20|unique:alumnos,dni,' . $this->route('alumno'),
            'curso_id'  => 'required|exists:cursos,id',
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.required'    => 'El nombre es obligatorio.',
            'apellidos.required' => 'Los apellidos son obligatorios.',
            'dni.unique'         => 'Este DNI ya está registrado.',
            'curso_id.required'  => 'El curso es obligatorio.',
            'curso_id.exists'    => 'El curso seleccionado no existe.',
        ];
    }
}