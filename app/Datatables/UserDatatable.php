<?php
namespace App\Datatables;

use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Support\Collection;
use ModelShaper\Datatable\BaseDatatable;

class UserDatatable extends BaseDatatable
{
    /** @var UserRepository */
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function initBuilder()
    {
        $this->builder = User::query();
    }

    public function render() : Collection
    {
        return $this->builder
            ->get()
            ->map(function (User $user) {
                return [
                    'id'       => [
                        'display' => $this->userRepository->getLink($user, '#' . $user->id),
                        'raw'     => $user->id,
                    ],
                    'fullname' => $user->fullname,
                    'name'     => $user->name,
                ];
            });
    }
}