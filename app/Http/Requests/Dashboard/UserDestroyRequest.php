<?php
namespace App\Http\Requests\Dashboard;

use App\Bases\BaseRequest;
use App\Models\User;
use Illuminate\Validation\ValidationException;

class UserDestroyRequest extends BaseRequest
{
    public function sucessfullyValidated()
    {
        $errors = [];

        if ($this->getRequestUser()->workLogs()->count() > 0) {
            $errors[] = __('There are work logs connected to this user');
        }

        if (count($errors)) {
            throw new ValidationException(null, response($errors, 422));
        }
    }

    protected function getRequestUser() : User
    {
        return $this->user;
    }
}