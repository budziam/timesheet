<?php
namespace App\Http\Requests\Dashboard;

use App\Bases\FormRequest;

class UserChangePasswordRequest extends FormRequest
{
    public function rules()
    {
        return [
            'password' => 'present|string',
        ];
    }
}