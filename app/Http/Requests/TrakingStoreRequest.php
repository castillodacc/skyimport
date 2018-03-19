<?php

namespace skyimport\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TrakingStoreRequest extends FormRequest
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
            'tracking' => 'required',
            'description' => 'required|string',
            'consolidated_id' => 'required|numeric',
            'distributor_id' => 'required|numeric',
            'weight' => 'required|numeric',
        ];
    }
}
