<?php
namespace App\Http\Controllers\App;

use App\Bases\BaseController;

class HomeController extends BaseController
{
    public function index()
    {
        return view('app.pages.home.index');
    }
}