<?php
namespace App\Http\Requests\Dashboard;

use App\Bases\BaseRequest;

class ProjectUpdateRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'name'  => 'required|string',
        ];
    }
}