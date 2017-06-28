<?php
namespace App\Http\Controllers\App\Api;

use App\Bases\BaseController;
use App\Http\Requests\App\ProjectGroupSearchSelect2Request;
use App\Services\ProjectGroupSearchService;
use App\Transformers\ProjectGroupSelect2Transformer;

class ProjectGroupSearchController extends BaseController
{
    public function select2(ProjectGroupSearchSelect2Request $request, ProjectGroupSearchService $repository)
    {
        $search = $request->input('q', '');

        $pagination = $repository->searchSelect2($search)
            ->paginate();

        $projectGroups = fractal()
            ->collection($pagination->items(), new ProjectGroupSelect2Transformer())
            ->toArray();

        return [
            'items'       => $projectGroups,
            'per_page'    => $pagination->perPage(),
            'total_count' => $pagination->total(),
        ];
    }
}