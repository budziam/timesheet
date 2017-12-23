<?php
namespace App\Http\Requests\Dashboard;

use App\Bases\FormRequest;
use App\Models\Project;
use Illuminate\Validation\ValidationException;

class ProjectDestroyRequest extends FormRequest
{
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