<?php
namespace App\Http\Requests\Dashboard;

use App\Bases\FormRequest;
use App\Models\User;
use Illuminate\Validation\ValidationException;

class UserDestroyRequest extends FormRequest
{
    public function sucessfullyValidated()
    {
        $errors = [];

        if ($this->requestUser()->is($this->user())) {
            $errors[] = __('Cannot delete your account.');
        }

        if ($this->requestUser()->workLogs()->count() > 0) {
            $errors[] = __('There are work logs connected to this user.');
        }


        if (count($errors)) {
            throw ValidationException::withMessages($errors);
        }
    }

    protected function requestUser() : User
    {
        return $this->route('user');
    }
}