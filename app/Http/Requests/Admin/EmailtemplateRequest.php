<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class EmailtemplateRequest extends FormRequest
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
        $id = decode($this->id);
        return [
            'code' => 'required|max:200|unique:email_templates,code,' . $id,
            'title' => 'required',
            'subject' => 'required',
            'html' => 'required',
            'panel' => 'required',
        ];
    }
}