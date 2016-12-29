<?php
namespace App\Http\Requests\App;

use App\Bases\BaseRequest;

class WorkLogSyncRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'date_from'   => 'integer',
            'date_to'     => 'integer',
            'work_logs.*' => [
                'date' => 'required|date_format:Y-m-d',
                'time' => 'required|date_format:H:i',
            ],
        ];
    }
}