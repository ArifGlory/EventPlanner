<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;


class Update extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return xhasRole(['superadmin', 'admin']);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            //
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email,' . decodeId($this->id),
            'username' => 'required|alpha_dash|unique:users,username,' . decodeId($this->id),
            'is_active' => 'required',
            'password' => 'confirmed|nullable',
            //'password' => 'required_if:password|nullable|string|confirmed|min:8',
//            "old_password" =>"nullable",
//              "new_password" =>"confirmed|nullable|different:old_password|required_with:old_password",
//              "password_confirmation" =>"nullable|required_with:new_password|required_with:old_password"

        ];


    }

    public function attributes()
    {
        return [
            'is_active' => 'status data',
        ];
    }
}
