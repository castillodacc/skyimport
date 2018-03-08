<?php

namespace skyimport\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
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
            'name'          => 'required|max:50',
            'last_name'     => 'required|max:50',
            'email'         => 'required|email|max:60',
            'phone'         => 'required|numeric',
            'num_id'        => 'required|numeric|exr_ced',
            'country_id'    => 'required|numeric',
            'city'          => 'required|string|max:50',
            'address'       => 'required|string|max:100',
            'address_two'   => 'nullable|string|max:100'
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
            'city'          => 'ciudad',
            'address'       => 'direccion',
            'address_two'   => 'direccion',
        ];
    }
}
