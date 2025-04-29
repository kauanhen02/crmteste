<?php

namespace App\Http\Requests\Atendimentos;

use Illuminate\Foundation\Http\FormRequest;

class CriarAtendimentosRequest extends FormRequest
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
            'cliente_id' => ['required'],
            'usuario_abriu_id' => ['required'],
            'tipo_atendimento_id' => ['required'],
            'assunto' => ['required'],
            'nome_projeto' => ['required'],
            'status_id' => ['required'],
            'nivel_urgencia' => ['required'],
            'feito' => ['required'],
            'prazo' => ['nullable'],
            'meio_contato' => ['nullable'],
            'contato' => ['nullable'],
            'obs' => ['nullable'],
        ];
    }
}
