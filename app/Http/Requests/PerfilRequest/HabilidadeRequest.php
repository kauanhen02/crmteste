<?php

namespace App\Http\Requests\PerfilRequest;

use Illuminate\Foundation\Http\FormRequest;

class HabilidadeRequest extends FormRequest
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
            'habilidades' => ['nullable', 'array'],
            'habilidades.*.habilidade_id' => ['nullable']
        ];
    }
}
