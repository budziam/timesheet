<?php
namespace App\Bases;

use App\Builders\Breadcrumb\BreadcrumbBuilder;
use App\Builders\NavbarBuilder;
use App\Models\User;
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
    protected $navbarBuilder;

    /** @var BreadcrumbBuilder */
    protected $breadcrumbBuilder;

    public function __construct(NavbarBuilder $navbarBuilder, BreadcrumbBuilder $breadcrumbBuilder)
    {
        $this->navbarBuilder = $navbarBuilder;
        $this->breadcrumbBuilder = $breadcrumbBuilder;

        $this->initMiddlewares();
        $this->preInitPageInformation();
    }

    protected function preInitPageInformation()
    {
        $this->breadcrumbBuilder
            ->attachNewBreadcrumb(__('Dashboard'), route('dashboard.home.index'));

        $this->initPageInformation();
    }

    /**
     * Initializes middlewares
     */
    protected function initMiddlewares()
    {
        //
    }

    /**
     * Initializes basic information about current page
     */
    protected function initPageInformation()
    {
        //
    }

    protected function user() : User
    {
        return auth()->user();
    }
}
