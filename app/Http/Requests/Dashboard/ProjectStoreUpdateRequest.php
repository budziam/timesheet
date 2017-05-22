<?php
namespace App\Http\Requests\Dashboard;

use App\Bases\BaseRequest;

class  ProjectStoreUpdateRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'lkz'         => 'required|string',
            'kerg'        => 'required|string',
            'name'        => 'required|string',
            'description' => 'string',
            'color'       => 'required|string',
            'ends_at'     => 'date|nullable',
            'groups'      => 'array',
        ];
    }
}