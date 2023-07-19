<?php

namespace App\Http\Requests\Dashboard\Financeiro;

use Illuminate\Foundation\Http\FormRequest;

class PagamentoRequest extends FormRequest
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
            'descricao' => 'required|string',
            'categoria_id' => 'required|integer',
            'subcategoria_id' => 'required|integer',
        ];
    }
}
