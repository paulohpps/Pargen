<?php

namespace App\Http\Requests\Dashboard\Funcionarios;

use Illuminate\Foundation\Http\FormRequest;

class FuncionarioRequest extends FormRequest
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
            'nome' => ['required', 'string', 'min:10', 'max:120'],
            'cpf' => ['required', 'bail'],
            'cargo' => 'required|string|min:6|max:40',
            'valor_vencimento' => 'required|numeric|min:0|max:999999.99',
            'encargos' => 'required|numeric|min:0|max:999999.99',
        ];
    }

    protected function prepareForValidation(): void
    {
        $attributes = [];
        if ($this->has('cpf')) {
            $attributes['cpf'] = preg_replace('/\D/', '', (string) $this->input('cpf'));
        }
        if ($this->has('valor_vencimento')) {
            $attributes['valor_vencimento'] = str_replace(',', '.', (string) $this->input('valor_vencimento'));
        }
        if ($this->has('encargos')) {
            $attributes['encargos'] = str_replace(',', '.', (string) $this->input('encargos'));
        }

        $this->merge($attributes);
    }

    public function messages()
    {
        return [
            'nome.required' => 'O campo nome e sobrenome é obrigatório.',
            'nome.regex' => 'O campo deve conter nome e sobrenome.',
        ];
    }
}
