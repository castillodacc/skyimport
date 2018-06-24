<?php

namespace skyimport\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserStoreRequest extends FormRequest
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
            'name'          => 'required|max:25',
            'last_name'     => 'required|max:25',
            'email'         => 'required|email|max:100|unique:users',
            'phone'         => 'required|numeric|unique:users|digits_between:6,13',
            'num_id'        => 'required|numeric|exr_ced|unique:users|digits_between:7,13',
            'country_id'    => 'required|numeric',
            'state_id'      => 'required|numeric',
            'city'          => 'required|alfa_space|max:50',
            'address'       => 'required|string|max:100',
            'address_two'   => 'nullable|string|max:100',
            'role_id'       => 'required|numeric',
            'password2'     => 'required|string|min:6|confirmed'
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
            'name'          => 'nombre',
            'last_name'     => 'apellido',
            'email'         => 'correo',
            'phone'         => 'telefono',
            'num_id'        => 'cedula',
            'country_id'    => 'pais',
            'state_id'      => 'Estado o Departamento',
            'city'          => 'ciudad',
            'address'       => 'direccion',
            'address_two'   => 'direccion',
            'role_id'       => 'rol',
            'password2'     => 'contraseña'
        ];
    }
}
