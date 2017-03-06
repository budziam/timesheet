<?php
namespace App\Http\Controllers\Dashboard;

use App\Bases\BaseController;

class HomeController extends BaseController
{
    public function index()
    {
        return view('dashboard.pages.home.index');
    }
}