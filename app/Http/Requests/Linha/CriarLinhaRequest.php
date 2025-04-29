<?php

namespace App\Http\Requests\Linha;

use Illuminate\Foundation\Http\FormRequest;

class CriarLinhaRequest extends FormRequest
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
            'nome' => ['required'],
            'categoria_id' => ['required', 'exists:categorias,id']
        ];
    }
}
