<?php
namespace App\Http\Requests\Dashboard;

use App\Bases\FormRequest;
use App\Models\Project;
use App\Models\User;
use Illuminate\Validation\Rule;

class WorkLogStoreUpdateRequest extends FormRequest
{
    public function rules()
    {
        return [
            'project_id'     => [
                'required',
                Rule::exists(Project::table(), 'id'),
            ],
            'user_id'        => [
                'required',
                Rule::exists(User::table(), 'id'),
            ],
            'date'           => 'required|date',
            'time_fieldwork' => 'required|integer',
            'time_office'    => 'required|integer',
        ];
    }
}