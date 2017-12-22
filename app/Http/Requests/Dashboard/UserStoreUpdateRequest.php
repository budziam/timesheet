<?php
namespace App\Http\Requests\Dashboard;

use App\Bases\FormRequest;

class UserStoreUpdateRequest extends FormRequest
{
    public function rules()
    {
        return [
            'fullname' => 'required|string',
            'name'     => 'required|string',
        ];
    }
}