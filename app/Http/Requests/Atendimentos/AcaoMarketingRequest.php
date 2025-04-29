<?php

namespace App\Http\Requests\Atendimentos;

use Illuminate\Foundation\Http\FormRequest;

class AcaoMarketingRequest extends FormRequest
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
            'acao_marketing' => ['nullable'],
            'obs_marketing' => ['nullable', 'required_if:acao_marketing,1'],
            'piramide_olfativa_1' => ['nullable'],
            'descricao_olfativa_2' => ['nullable'],
        ];
    }
}
