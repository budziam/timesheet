<?php
namespace App\Datatables;

use App\Models\User;
use App\Repositories\UserRepository;
use App\Traits\Instantiable;
use Illuminate\Support\Collection;
use ModelShaper\Datatable\DatatableContract;
use ModelShaper\Datatable\Traits\FilterTrait;
use ModelShaper\Datatable\Traits\SortTrait;

class UserDatatable implements DatatableContract
{
    use FilterTrait, SortTrait, Instantiable;

    /** @var UserRepository */
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function render() : Collection
    {
        return User::all()
            ->map(function (User $user) {
                return [
                    'id'   => [
                        'display' => $this->userRepository->getLink($user, '#' . $user->id),
                        'raw'     => $user->id,
                    ],
                    'name' => $user->name,
                ];
            });
    }
}