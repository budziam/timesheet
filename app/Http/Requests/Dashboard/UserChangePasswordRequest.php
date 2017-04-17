<?php
namespace App\Http\Requests\Dashboard;

use App\Bases\BaseRequest;

class UserChangePasswordRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'password' => 'present|string',
        ];
    }
}