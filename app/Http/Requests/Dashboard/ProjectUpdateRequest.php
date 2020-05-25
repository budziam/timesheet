<?php
namespace App\Http\Requests\Dashboard;

use App\Bases\FormRequest;
use App\Models\Customer;
use App\Models\Project;
use Illuminate\Validation\Rule;

class ProjectUpdateRequest extends FormRequest
{
    public function rules()
    {
        /** @var Project $project */
        $project = $this->route('project');

        return [
            'lkz'         => [
                'required',
                'string',
                Rule::unique(Project::table())->ignore($project->id),
            ],
            'kerg'        => 'required|string',
            'name'        => 'required|string',
            'value'       => 'required|numeric',
            'description' => 'string',
            'color'       => 'string|nullable',
            'ends_at'     => 'date|nullable',
            'groups'      => 'array',
            'customer_id' => ['nullable', 'integer', Rule::exists(Customer::table(), 'id')],
        ];
    }
}
