<?php
namespace App\Http\Requests\Dashboard;

use App\Bases\FormRequest;

class ProjectGroupStoreUpdateRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name'  => 'required|string',
            'color' => 'required|string',
        ];
    }
}