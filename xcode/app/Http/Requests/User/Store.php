<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;


class Store extends FormRequest
{
    protected $validator;

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
            'email' => 'required|email|unique:users,email',
            'username' => 'required|alpha_dash|unique:users,username',
            'avatar' => 'sometimes|mimes:' . permission_image() . '|max:' . max_upload_image(),
            'password' => 'required|string|confirmed|min:8',
            'roles' => 'required',
            'is_active' => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'is_active' => 'status data',
        ];
    }
}
