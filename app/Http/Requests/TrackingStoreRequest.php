<?php

namespace skyimport\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TrackingStoreRequest extends FormRequest
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
            'tracking' => 'required|min:5|max:25',
            'description' => 'required|string|max:15|min:3',
            'consolidated_id' => 'required|numeric',
            'distributor_id' => 'required|numeric',
            'price' => 'required|numeric|max:1000000',
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
            'tracking' => 'número de tracking',
            'description' => 'descripción',
            'consolidated_id' => 'consolidado',
            'distributor_id' => 'distribuidor',
            'price' => 'precio',
        ];
    }
}
