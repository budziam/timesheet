<?php
namespace App\Http\Requests\App;

use App\Bases\BaseRequest;

class WorkLogSearchFullcalendarRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'start'      => 'required|date_format:Y-m-d',
            'end'        => 'required|date_format:Y-m-d',
            'project_id' => 'integer',
        ];
    }
}