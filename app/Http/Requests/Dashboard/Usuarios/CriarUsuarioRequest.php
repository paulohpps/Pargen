<?php

namespace App\Http\Requests\Dashboard\Usuarios;

use App\Enums\Usuario\TipoUsuario;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CriarUsuarioRequest extends FormRequest
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
            'username' => 'required|string|min:6|max:20|unique:usuarios',
            'password' => 'required|string|min:6|confirmed',
            'tipo_usuario' => ['required', 'integer', Rule::in(TipoUsuario::values())]
        ];
    }
}
