<?php
namespace App\Http\Requests\App;

use App\Bases\BaseRequest;

class ProjectGroupIndexRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'q' => 'string',
        ];
    }
}