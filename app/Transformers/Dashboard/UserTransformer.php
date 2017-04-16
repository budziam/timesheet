<?php
namespace App\Transformers\Dashboard;

use App\Models\User;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
    public function transform(User $user)
    {
        return [
            'id'          => $user->id,
            'name'        => $user->name,
            'created_at'  => $user->created_at->toDateTimeString(),
            'updated_at'  => $user->updated_at->toDateTimeString(),
        ];
    }
}