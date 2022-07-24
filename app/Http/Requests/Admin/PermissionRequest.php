<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class PermissionRequest extends FormRequest
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
        $rules = [
            'module_id' => 'required',
            'panel' => 'required',
            'title.*' => 'required',
            'name.*' => 'required',
        ];

        return $rules;
    }

    public function messages()
    {
        return [
            // 'email' => 'Please Select Role',
        ];
    }
}
