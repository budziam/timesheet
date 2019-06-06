<?php
namespace App\ModelShaper\Select2;

use Illuminate\Foundation\Http\FormRequest as BaseFormRequest;

class Select2FormRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'q' => 'string',
        ];
    }

    public function authorize()
    {
        return true;
    }
}
