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
            'value'       => 'required|numeric',
            'description' => 'string',
            'color'       => 'string|nullable',
            'ends_at'     => 'date|nullable',
            'groups'      => 'array',
        ];
    }
}