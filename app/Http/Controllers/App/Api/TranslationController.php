<?php
namespace App\Http\Controllers\App\Api;

use App\Bases\BaseController;

class TranslationController extends BaseController
{
    public function index()
    {
        return trans('t');
    }
}