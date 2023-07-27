<?php

namespace App\Http\Requests\Dashboard\Fornecedores;

use Illuminate\Foundation\Http\FormRequest;

class FornecedorRequest extends FormRequest
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
            'razao_social' => 'required|string',
            'telefone' => 'string|nullable',
            'email' => 'email|nullable',
            'endereco' => 'string|nullable',
        ];
    }

    protected function prepareForValidation(): void
    {
        $attributes = [];
        if ($this->has('cnpj')) {
            $attributes['cnpj'] = preg_replace('/\D/', '', (string) $this->input('cnpj'));
        }

        $this->merge($attributes);
    }

}
