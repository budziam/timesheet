<?php
namespace App\ModelShaper\Select2;

use Illuminate\Database\Eloquent\Model;
use League\Fractal\TransformerAbstract;

class InputSelectTransformer extends TransformerAbstract
{
    /**
     * Text column
     *
     * @var string
     */
    protected $column;

    public function __construct($column)
    {
        $this->column = $column;
    }

    public function transform(Model $model)
    {
        return [
            'id'   => $model->getAttribute('id'),
            'text' => $model->getAttribute($this->column),
        ];
    }
}
