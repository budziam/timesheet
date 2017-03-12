<?php
namespace App\Http\Controllers;

use App\Bases\BaseController;

class TranslationController extends BaseController
{
    public function index()
    {
        return __('*');
    }
}