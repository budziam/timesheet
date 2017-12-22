<?php
namespace App\Http\Requests\App;

use App\Bases\FormRequest;

class ProjectSearchSelect2Request extends FormRequest
{
    public function rules()
    {
        return [
            'q' => 'string',
        ];
    }
}