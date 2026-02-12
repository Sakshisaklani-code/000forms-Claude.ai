<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * Show home page.
     */
    public function home()
    {
        return view('pages.home');
    }

    /**
     * Show documentation page.
     */
    public function docs()
    {
        return view('pages.docs');
    }

    /**
     * Show pricing page.
     */
    public function pricing()
    {
        return view('pages.pricing');
    }
}
