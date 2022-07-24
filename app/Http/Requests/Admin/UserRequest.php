<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
        $salon_id = $this->salon_id;
        $role_id = $this->role_id;
        $rules = [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:user,email,' . $id . ',id,salon_id,' . $salon_id . ',role_id,' . $role_id,
            'phone_number' => "required|regex:/^[0-9]{3}[0-9]{3}[0-9]{4}$/",
            'role_id' => 'required',
            'salon_id' => 'required_if:role_id,4',
            'profile_photo' => 'image|mimes:jpeg,png,jpg|max:2048',
        ];
        if ($id) {
            return $rules;
        } else {
            $add_validate_rules = [
                'username' => 'unique:user,username,' . $id . ',id,salon_id,' . $salon_id . ',role_id,' . $role_id,
                'password' => 'required|min:6',
                'confirm_password' => 'required|required_with:password|same:password|min:6',
            ];
            return array_merge($rules, $add_validate_rules);
        }
    }

    public function messages()
    {
        return [
            'salon_id' => 'Salon',
        ];
    }
}
