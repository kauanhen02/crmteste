<?php

namespace App\Http\Requests\Atendimentos;

use Illuminate\Foundation\Http\FormRequest;

class CriarAtendimentoEnviosRequest extends FormRequest
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
            'destino_id' => ['required'],
            'envio_id' => ['required'],
            'contato' => ['required'],
            'cidade' => ['required'],
            'estado' => ['required'],
            'rua' => ['required'],
            'numero' => ['required'],
            'bairro' => ['required'],
            'complemento' => ['nullable'],
            'cep' => ['required'],
            'obs' => ['nullable'],
        ];
    }
}
