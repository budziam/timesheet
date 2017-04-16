<?php
namespace App\Http\Requests\Dashboard;

use App\Bases\BaseRequest;

class ProjectStoreUpdateRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'name'        => 'required|string',
            'description' => 'string',
            'color'       => 'required|string',
            'ends_at'     => 'required|date',
        ];
    }
}