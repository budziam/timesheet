<?php
namespace App\Http\Requests\App;

use App\Bases\FormRequest;

class ProjectGroupSearchSelect2Request extends FormRequest
{
    public function rules()
    {
        return [
            'q' => 'string',
        ];
    }
}