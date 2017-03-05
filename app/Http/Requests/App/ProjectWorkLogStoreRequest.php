<?php
namespace App\Http\Requests\App;

use App\Bases\BaseRequest;
use App\Models\WorkLog;
use Illuminate\Validation\Rule;

class ProjectWorkLogStoreRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'date'           => [
                'required',
                'date',
                Rule::unique(WorkLog::table(), 'date')
                    ->where('project_id', $this->project->id)
                    ->where('user_id', $this->user()->id),
            ],
            'time_fieldwork' => 'required|integer',
            'time_office'    => 'required|integer',
        ];
    }
}