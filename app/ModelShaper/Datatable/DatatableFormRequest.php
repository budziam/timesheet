<?php
namespace App\ModelShaper\Datatable;

use Illuminate\Foundation\Http\FormRequest as BaseFormRequest;

class DatatableFormRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'draw'    => 'required|int',
            'start'   => 'required|int',
            'length'  => 'required|int',
            'search'  => 'required|array',
            'order'   => 'required|array',
            'columns' => 'required|array',
        ];
    }

    public function authorize()
    {
        return true;
    }
}
