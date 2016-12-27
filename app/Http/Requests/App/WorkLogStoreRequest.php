<?php
namespace App\Http\Requests\App;

use App\Bases\BaseRequest;
use App\Models\Project;
use Carbon\Carbon;
use Illuminate\Validation\Validator;

class WorkLogStoreRequest extends BaseRequest
{
    /** @var Project */
    public $project;

    public function rules()
    {
        return [
            'project_id' => 'required|integer',
            'date'       => 'required|date_format:Y-m-d',
            'starts_at'  => 'required|date_format:H:i',
            'ends_at'    => [
                'required',
                'date_format:H:i',
                'after:starts_at',
            ],
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

    public function allTransformed()
    {
        $data = parent::allTransformed();

        $data['starts_at'] = Carbon::createFromFormat(
            'Y-m-d H:i', $this->input('date') . ' ' . $this->input('starts_at')
        );

        $data['ends_at'] = Carbon::createFromFormat(
            'Y-m-d H:i', $this->input('date') . ' ' . $this->input('ends_at')
        );

        return $data;
    }
}