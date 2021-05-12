<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View as ViewFactory;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')
            ->except('logout');
    }

    public function login(): View
    {
        return ViewFactory::make('login');
    }

    public function authenticate(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            return Redirect::intended('home');
        }

        return Redirect::back()->withErrors([
            'message' => 'Invalid login.',
        ]);
    }

    public function register(): View
    {
        return ViewFactory::make('register');
    }

    /**
     * @param \Illuminate\Http\Request
     */
    public function create(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users',
            'password' => 'required',
        ]);

        $user = User::create(
            $request->only(['name', 'email', 'password'])
        );

        Auth::login($user);

        return Redirect::route('home');
    }
}
