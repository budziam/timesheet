<?php
namespace App\Http\Requests\App;

use App\Bases\FormRequest;

class ProjectSearchDefaultRequest extends FormRequest
{
    public function rules()
    {
        return [
            'search' => 'string',
            'groups' => 'array',
        ];
    }
}