<?php

namespace skyimport\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class changePasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'old_password' => 'required|string|min:6|current_password',
            'password' => 'required|string|min:6|confirmed|different:old_password',
            'password_confirmation' => 'required|string|min:6',
        ];
    }

    /**
     * Cambio de nombres de los atributos.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'old_password'          => 'contraseña actual',
            'password'              => 'nueva contraseña',
            'password_confirmation' => 'confirmación',
        ];
    }
}
