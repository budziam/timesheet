<?php
namespace App\Transformers;

use Illuminate\Database\Eloquent\Model;
use League\Fractal\TransformerAbstract;

class SearchSelectTransformer extends TransformerAbstract
{
    /** @var string */
    protected $column;

    public function __construct($column = 'name')
    {
        $this->column = (string)$column;
    }

    public function transform(Model $model)
    {
        return [
            'id'   => $model->getKey(),
            'text' => $model->getAttribute($this->column),
        ];
    }
}