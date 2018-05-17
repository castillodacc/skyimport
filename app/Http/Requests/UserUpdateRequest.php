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
            'name'          => 'required|max:25',
            'last_name'     => 'required|max:25',
            'email'         => 'required|email|max:30',
            'phone'         => 'required|numeric|digits_between:6,11',
            'num_id'        => 'required|numeric|exr_ced|digits_between:7,12',
            'country_id'    => 'required|numeric',
            'state_id'      => 'required|numeric',
            'city'          => 'required|alpha|max:20',
            'address'       => 'required|string|max:100',
            'address_two'   => 'nullable|string|max:100',
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
        ];
    }
}
