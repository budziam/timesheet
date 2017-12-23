<?php
namespace App\Http\Requests\Dashboard;

use App\Bases\FormRequest;
use App\Models\Customer;
use Illuminate\Validation\ValidationException;

class CustomerDestroyRequest extends FormRequest
{
    public function sucessfullyValidated()
    {
        $errors = [];

        if ($this->customer()->projects()->count() > 0) {
            $errors[] = __('There are projects connected with this customer.');
        }

        if (count($errors)) {
            throw ValidationException::withMessages($errors);
        }
    }

    protected function customer() : Customer
    {
        return $this->route('customer');
    }
}