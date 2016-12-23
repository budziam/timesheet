<?php
namespace App\Http\Controllers\App\Api;

use App\Bases\BaseController;
use App\Http\Requests\App\ProjectSearchDefaultRequest;
use App\Http\Requests\App\ProjectSearchSelect2Request;
use App\Services\ProjectSearchService;
use App\Transformers\ProjectTransformer;
use App\Transformers\SearchSelectTransformer;

class ProjectSearchController extends BaseController
{
    public function default(ProjectSearchDefaultRequest $request, ProjectSearchService $service)
    {
        $search = $request->input('search', '');
        $groups = $request->input('groups', []);

        $projects = $service->searchDefault($search, $groups);

        return fractal()
            ->collection($projects, new ProjectTransformer);
    }

    public function select2(ProjectSearchSelect2Request $request, ProjectSearchService $service)
    {
        $search = $request->input('q', '');

        $pagination = $service->searchSelect2($search)
            ->paginate();

        $items = fractal()
            ->collection($pagination->items(), new SearchSelectTransformer)
            ->toArray();

        return [
            'items'       => $items,
            'per_page'    => $pagination->perPage(),
            'total_count' => $pagination->total(),
        ];
    }
}