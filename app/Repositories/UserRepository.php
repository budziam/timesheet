<?php
namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    public function getLink(User $user, $title = null) : string
    {
        $title = $title ?? $user->name;

        return (string)link_to_route('dashboard.users.edit', $title, $user->getRouteKey());
    }
}