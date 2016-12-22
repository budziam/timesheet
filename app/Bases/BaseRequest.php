<?php
namespace App\Bases;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

abstract class BaseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            //
        ];
    }

    public function validate()
    {
        $this->beforeValidation();

        parent::validate();

        $this->sucessfullyValidated();
    }

    /**
     * You can modify validator here
     *
     * @param Validator $validator
     */
    public function withValidator(Validator $validator)
    {
        // 
    }

    /**
     * Runs exactly before validation
     */
    protected function beforeValidation()
    {
        //
    }

    /**
     * Runs when validation is passed
     */
    protected function sucessfullyValidated()
    {
        //
    }

    /**
     * Instead of modifying request directly, use this method to get modyfied request data
     *
     * @return \Illuminate\Support\Collection
     */
    public function allTransformed()
    {
        return collect($this->all());
    }
}
