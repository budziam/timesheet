<?php
namespace App\ModelShaper\Select2;

use Illuminate\Database\Eloquent\Model;
use League\Fractal\TransformerAbstract;

class Select2Shaper
{
    /** @var \Eloquent */
    protected $model;

    /**
     * Column that we filter by
     *
     * @var string
     */
    protected $column;

    /** @var TransformerAbstract */
    protected $transformer;

    /**
     * Function called before select pagination, used to modify query
     *
     * @var callable
     */
    protected $queryModifier;

    public function __construct(Model $model, $column)
    {
        $this->model = $model;
        $this->column = $column;
    }

    public function setTransformer(TransformerAbstract $transformer = null)
    {
        $this->transformer = $transformer;
    }

    public function setQueryModifier(callable $queryModifier = null)
    {
        $this->queryModifier = $queryModifier;
    }

    public function shape(Select2FormRequest $request) : array
    {
        $pattern = $this->preparePattern($request);

        $query = $this->model
            ->where($this->column, 'like', "%{$pattern}%");

        if ($this->queryModifier !== null) {
            $queryModifier = $this->queryModifier;
            $queryModifier($query, $request);
        }

        $pagination = $query->paginate();

        $transformer = $this->transformer ?? new InputSelectTransformer($this->column);

        $items = fractal()
            ->collection($pagination->items(), $transformer)
            ->toArray();

        return [
            'items'       => $items,
            'per_page'    => $pagination->perPage(),
            'total_count' => $pagination->total(),
        ];
    }

    protected function preparePattern(Select2FormRequest $request) : string
    {
        $pattern = (string)$request->input('q');
        $pattern = implode('%', str_split($pattern));

        return $pattern;
    }
}
