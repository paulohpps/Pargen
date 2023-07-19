<?php

namespace App\Http\Requests\Dashboard\Fornecedores;

use App\Enums\Financeiro\CategoriaPagamento;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PagamentoFornecedorRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'fornecedor_id' => ['required', 'integer'],
            'categoria' => ['required', 'integer', Rule::in(CategoriaPagamento::values())],
            'descricao' => ['required', 'string'],
        ];
    }
}
