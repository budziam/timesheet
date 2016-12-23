<?php
namespace App\Http\Requests\App;

use App\Bases\BaseRequest;

class ProjectGroupSearchSelect2Request extends BaseRequest
{
    public function rules()
    {
        return [
            'q' => 'string',
        ];
    }
}