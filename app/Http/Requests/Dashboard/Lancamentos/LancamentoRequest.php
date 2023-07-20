<?php

namespace App\Http\Requests\Dashboard\Lancamentos;

use Illuminate\Foundation\Http\FormRequest;

class LancamentoRequest extends FormRequest
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
            'tipo_pagamento' => 'required',
            'fornecedor_id' => 'required_if:tipo_pagamento,1',
            'funcionario_id' => 'required_if:tipo_pagamento,2',
            'pagamento_id' => 'required_if:tipo_pagamento,3',
            'descricao' => 'string|nullable',
            'valor' => 'required',
            'vencimento' => 'required',
            'status' => 'required',
            'repetir_parcelas' => 'required',
            'numero_parcelas' => 'required_if:repetir_parcelas,true',
            'pagamento_lancamento_id' => 'required|numeric'
        ];
    }

    public function prepareForValidation()
    {
        $tipoPagamento = $this->input('tipo_pagamento');

        if ($tipoPagamento == 1) {
            $this->merge([
                'fornecedor_id' => $this->input('fornecedor_id'),
                'funcionario_id' => null,
                'pagamento_id' => null,
            ]);
        } elseif ($tipoPagamento == 2) {
            $this->merge([
                'fornecedor_id' => null,
                'funcionario_id' => $this->input('funcionario_id'),
                'pagamento_id' => null,
            ]);
        } elseif ($tipoPagamento == 3) {
            $this->merge([
                'fornecedor_id' => null,
                'funcionario_id' => null,
                'pagamento_id' => $this->input('pagamento_id'),
            ]);
        }
    }
}
