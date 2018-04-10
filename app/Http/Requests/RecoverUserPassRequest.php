<?php

namespace skyimport\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RecoverUserPassRequest extends FormRequest
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
            '_codigo' => 'required|string',
            'id' => 'required|numeric',
            'number_id' => 'required|numeric',
            'password' => 'required|confirmed|string|min:6',
            'password_confirmation' => 'required',
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
            '_codigo'   => 'código',
            'id'        => 'identificador',
            'number_id' => 'número de identificación',
            'password'  => 'contraseña',
            'password_confirmation' => 'confirmación de contraseña',
        ];
    }
}
