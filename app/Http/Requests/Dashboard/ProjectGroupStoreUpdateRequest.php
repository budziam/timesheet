<?php
namespace App\Http\Requests\Dashboard;

use App\Bases\BaseRequest;

class ProjectGroupStoreUpdateRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'name' => 'required|string',
        ];
    }
}