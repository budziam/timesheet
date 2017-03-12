<?php
namespace App\Http\Controllers\Dashboard;

use App\Bases\BaseController;

class ProjectController extends BaseController
{
    public function index()
    {
        $componentData = [
            'columns' => [
                'Id',
                'Name',
            ],
            'options' => [
                'ajax'    => route('dashboard.api.datatable.projects'),
                'columns' => [
                    [
                        'name' => 'id',
                        'data' => ['_' => 'id.display'],
                    ],
                    ['data' => 'name'],
                ],
            ],
        ];

        return view('dashboard.pages.projects.index', compact('componentData'));
    }
}