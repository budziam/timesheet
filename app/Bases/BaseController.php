<?php
namespace App\Bases;

use App\Builders\NavbarBuilder;
use App\Traits\Responseable;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class BaseController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    use Responseable;

    /** @var NavbarBuilder */
    protected $navbar;

    public function __construct(NavbarBuilder $navbarBuilder)
    {
        $this->navbar = $navbarBuilder;
    }
}
