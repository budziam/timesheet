<?php
namespace App\Http\Controllers\App\Api;

use App\Bases\BaseController;
use App\Http\Requests\App\ProjectGroupSearchSelect2Request;
use App\Services\ProjectGroupSearchService;
use App\Transformers\SearchSelectTransformer;

class ProjectGroupSearchController extends BaseController
{
    public function select2(ProjectGroupSearchSelect2Request $request, ProjectGroupSearchService $repository)
    {
        $search = $request->input('q', '');

        $pagination = $repository->searchSelect2($search)
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