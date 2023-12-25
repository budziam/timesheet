<?php
namespace App\Http\Requests\Dashboard;

use App\Bases\FormRequest;
use App\Models\Customer;
use App\Models\Project;
use Illuminate\Validation\Rule;

class ProjectStoreRequest extends FormRequest
{
    public function rules()
    {
        return [
            'lkz'         => ['required', 'string', Rule::unique(Project::table())],
            'kerg'        => 'required|string',
            'name'        => 'required|string',
            'value'       => 'required|numeric',
            'cost'        => 'required|numeric',
            'description' => 'string',
            'color'       => 'string|nullable',
            'ends_at'     => 'date|nullable',
            'groups'      => 'array',
            'customer_id' => ['nullable', 'integer', Rule::exists(Customer::table(), 'id')],
        ];
    }
}
