<?php
namespace App\Http\Requests\Dashboard;

use App\Bases\BaseRequest;

class UserStoreUpdateRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'name' => 'required|string',
        ];
    }
}