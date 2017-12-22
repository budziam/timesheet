<?php
namespace App\Http\Requests\Dashboard;

use App\Bases\FormRequest;

class  ProjectStoreUpdateRequest extends FormRequest
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