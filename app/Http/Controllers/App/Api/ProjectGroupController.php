<?php
namespace App\Http\Controllers\App\Api;

use App\Bases\BaseController;
use App\Http\Requests\App\ProjectGroupIndexRequest;
use App\Repositories\ProjectGroupRepository;
use App\Transformers\SearchSelectTransformer;

class ProjectGroupController extends BaseController
{
    public function index(ProjectGroupIndexRequest $request, ProjectGroupRepository $repository)
    {
        $search = $request->input('q', '');

        $query = $repository->searchModeSelect($search);

        $pagination = $query->paginate();

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