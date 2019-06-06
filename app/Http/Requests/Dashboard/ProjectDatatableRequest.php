<?php
namespace App\Http\Requests\Dashboard;

use App\Models\Project;
use Illuminate\Validation\ValidationException;
use App\ModelShaper\Datatable\DatatableFormRequest;

class ProjectDatatableRequest extends DatatableFormRequest
{
    public function rules()
    {
        $parentRules = parent::rules();
        $rules = [
            'only_active' => 'bool',
        ];

        return array_merge($parentRules, $rules);
    }


    public function sucessfullyValidated()
    {
        $errors = [];

        if ($this->project()->workLogs()->count() > 0) {
            $errors[] = __('There are work logs connected with this project');
        }

        if (count($errors)) {
            throw ValidationException::withMessages($errors);
        }
    }

    protected function project() : Project
    {
        return $this->route('project');
    }
}
