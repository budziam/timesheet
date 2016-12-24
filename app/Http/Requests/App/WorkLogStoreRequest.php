<?php
namespace App\Http\Requests\App;

use App\Bases\BaseRequest;

class WorkLogStoreRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'project_id' => 'required|integer',
            'date'       => 'required|date',
            'starts_at'  => 'required|date_format:HH:i',
            'ends_at'    => 'required|date_format:HH:i',
        ];
    }
}