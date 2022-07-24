<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CustompageRequest extends FormRequest
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
            'name' => 'required|max:200|unique:custom_pages,name,' . $id,
            'title' => 'required',
            'description' => 'required',
        ];
    }
}