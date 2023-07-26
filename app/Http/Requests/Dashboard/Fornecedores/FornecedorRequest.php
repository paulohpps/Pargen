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
            'razao_social' => 'required|string|min:10|max:120',
            'telefone' => 'required|string',
            'email' => 'required|email|min:10|max:120',
            'cnpj' => ['required', 'bail'],
            'endereco' => 'required|string|min:8|max:120',
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
