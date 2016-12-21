<?php
namespace App\Http\Controllers\Auth;

use App\Bases\BaseController;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends BaseController
{
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo;

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->redirectTo = route('app.home.index');

        $this->middleware('guest', ['except' => 'logout']);
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }
}
