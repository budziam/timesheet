<?php
namespace App\Http\Requests\App;

use App\Bases\BaseRequest;
use App\Models\Project;
use Illuminate\Validation\Validator;

class WorkLogStoreRequest extends BaseRequest
{
    /** @var Project */
    public $project;

    public function rules()
    {
        sleep(5);
        return [
            'project_id'  => 'required|integer',
            'date'        => 'required|date',
            'starts_at'   => 'required|date_format:H:i',
            'ends_at'     => 'required|date_format:H:i',
        ];
    }

    public function withValidator(Validator $validator)
    {
        $validator->after(function (Validator $validator) {
            $this->project = Project::find($this->input('project_id'));

            if ($this->project === null) {
                $validator->messages()
                    ->add('project_id', 'There is no such a project');
            }
        });
    }
}