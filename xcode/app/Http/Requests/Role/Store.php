<?php

namespace App\Http\Requests\Role;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;


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
        return Auth::user()->hasRole('superadmin');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|unique:roles,name',
            'permission' => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'Roles Name',
            'permission' => 'Pilih Permission',
        ];
    }

//    public function messages()
//    {
//        return [
//            'name.required' => 'Name is Must',
//            'name.min' => 'Name Must be 5 Chr.',
//        ];
//    }
}
