<?php

namespace App\Http\Requests\ClientesRequest;

use Illuminate\Foundation\Http\FormRequest;

class CriarCliente extends FormRequest
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
            'carteira_id' => ['nullable', 'exists:carteiras,id'],
            'segmento_id' => ['nullable', 'exists:segmentos,id'],
            'forma_atuacao_id' => ['nullable', 'exists:formas_atuacoes,id'],
            'status_lgpd_id' => ['nullable', 'exists:status_lgpd,id'],
            'nome' => ['required'],
            'razao_social' => ['nullable'],
            'cnpj' => ['required'],
            'telefone' => ['required'],
            'email' => ['nullable'],
            'cep' => ['nullable'],
            'rua' => ['nullable'],
            'numero' => ['nullable'],
            'bairro' => ['nullable'],
            'cidade' => ['nullable'],
            'estado' => ['nullable'],
            'complemento' => ['nullable']
        ];
    }
}
