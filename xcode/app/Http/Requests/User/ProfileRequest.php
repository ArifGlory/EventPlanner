<?php

namespace App\Http\Requests\User;


use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;


class ProfileRequest extends FormRequest
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
           // 'name' => 'required|string',
            //'username' => 'required|alpha_dash|unique:users,username,'. auth()->id(),
            'email' => 'required|email|unique:users_login,email,'. Auth::user()->id_users.',id_users',
            'avatar' => 'sometimes|mimes:'.permission_image().'|max:' . max_upload_image(),
        ];
    }

    public function attributes()
    {
        return [
            //'name' => 'Nama Lengkap',
        ];
    }
}
