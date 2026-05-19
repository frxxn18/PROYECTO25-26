<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LibroRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'titulo' => 'required|string|max:200',
            'autor'  => 'required|string|max:150',
            'isbn' => 'nullable|string|max:20|unique:libros,isbn,' . ($this->route('libro')?->id ?? 'NULL'),
            'stock'  => 'required|integer|min:0',
        ];
    }

    public function messages(): array
    {
        return [
            'titulo.required' => 'El título es obligatorio.',
            'autor.required'  => 'El autor es obligatorio.',
            'isbn.unique'     => 'Este ISBN ya está registrado.',
            'stock.required'  => 'El stock es obligatorio.',
            'stock.min'       => 'El stock no puede ser negativo.',
        ];
    }
}