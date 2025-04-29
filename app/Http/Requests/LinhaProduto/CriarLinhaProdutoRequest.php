<?php

namespace App\Http\Requests\LinhaProduto;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CriarLinhaProdutoRequest extends FormRequest
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
            'categoria_id' => ['required', 'exists:categorias,id'],
            'linha_id' => ['required', Rule::exists('linhas', 'id')->where('categoria_id', $this->categoria_id)],
            'volume_id' => ['required'],
            'quantidade' => ['required'],
            'custo_venda_minimo' => ['required'],
            'custo_venda_maximo' => ['required'],
            'aplicacao_minimo' => ['required'],
            'aplicacao_maximo' => ['required'],
            'numero_sugestoes' => ['nullable'],
            'custo_beneficio' => ['nullable'],
            'aplicacao' => ['nullable'],
            'base' => ['nullable'],
            'obs' => ['nullable'],
            'aplicacao_personalizada' => ['nullable'],
            'estabilidade' => ['nullable'],
            'sugestao_formulacao' => ['nullable'],
            'suporte_tecnico' => ['nullable'],
            'obs_olfativa' => ['nullable']
        ];
    }
}
