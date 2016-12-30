<?php
namespace App\Http\Controllers\App;

use App\Bases\BaseController;

class HomeController extends BaseController
{
    public function index()
    {
        $this->navbar->setActive('home');

        return view('app.pages.home.index');
    }
}