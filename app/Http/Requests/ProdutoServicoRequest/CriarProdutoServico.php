<?php

namespace App\Http\Requests\ProdutoServicoRequest;

use Illuminate\Foundation\Http\FormRequest;

class CriarProdutoServico extends FormRequest
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
            'grupo_id' => ['nullable', 'exists:grupos,id'],
            'sub_grupo_id' => ['nullable', 'exists:sub_grupos,id'],
            'descricao' => ['required'],
            'descricao_popular' => ['nullable'],
            'cod' => ['nullable'],
            'custo_medio_ponderado' => ['nullable']
        ];
    }
}
