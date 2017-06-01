<?php
namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    public function getLink(User $user, $title = null) : string
    {
        $title = $title ?? $user->fullname;

        return (string)link_to_route('dashboard.users.edit', $title, $user->getRouteKey());
    }

    public function create(array $attributes = []) : User
    {
        $user = User::withTrashed()
            ->where('name', data_get($attributes, 'name'))
            ->first();

        if ($user !== null) {
            $user->restore();

            return $user;
        }

        $attributes['password'] = $attributes['password'] ?? bcrypt('');

        return User::create($attributes);
    }
}