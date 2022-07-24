<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ModuleRequest extends FormRequest
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
            'panel' => 'required',
            'title' => 'required',
            'functionality' => 'required',
            'type' => 'required',
            'parent_menu_id' => 'required_if:type,Submenu',
        ];
    }

    public function messages()
    {
        return [
            // 'email' => 'Please Select Role',
        ];
    }
}
