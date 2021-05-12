<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\View as ViewFactory;
use Illuminate\Contracts\View\View;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @return \Illuminate\Contracts\View\View
    */
    public function __invoke(): View
    {
        return ViewFactory::make('home');
    }
}
