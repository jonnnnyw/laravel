<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View as ViewFactory;
use App\Http\Requests\UserRegisterRequest;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')
            ->except('logout');
    }

    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function login(): View
    {
        return ViewFactory::make('login');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
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

    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function register(): View
    {
        return ViewFactory::make('register');
    }

    /**
     * @param \App\Http\Requests\UserRegisterRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function create(UserRegisterRequest $request): RedirectResponse
    {
        $user = User::create(
            $request->only(['name', 'email', 'password'])
        );

        Auth::login($user);

        return Redirect::route('home');
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(): RedirectResponse
    {
        Auth::logout();

        return Redirect::route('login');
    }
}
