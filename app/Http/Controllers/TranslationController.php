<?php
namespace App\Http\Controllers;

use App\Bases\Controller;

class TranslationController extends Controller
{
    public function index()
    {
        return __('*');
    }
}