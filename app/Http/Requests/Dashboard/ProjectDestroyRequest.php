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

        if ($this->getProject()->workLogs()->count() > 0) {
            $errors[] = __('There are work logs connected with this project');
        }

        if (count($errors)) {
            throw new ValidationException(null, response($errors, 422));
        }
    }

    protected function getProject() : Project
    {
        return $this->project;
    }
}