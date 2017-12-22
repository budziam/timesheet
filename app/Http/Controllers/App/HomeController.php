<?php
namespace App\Http\Controllers\App;

use App\Bases\Controller;

class HomeController extends Controller
{
    public function index()
    {
        $this->breadcrumbBuilder->attachNewBreadcrumb(__('Homepage'), route('app.home.index'));

        return view('app.pages.home.index');
    }
}