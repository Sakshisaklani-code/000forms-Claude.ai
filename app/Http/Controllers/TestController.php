<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    public function home()
    {
        return view('Test-forms.test');
    }

    public function thankYou()
    {
        return view('Test-forms.thank-you');
    }

    public function formspree()
    {
        return view('Test-forms.formspree');
    }

    public function formsubmit()
    {
        return view('Test-forms.formsubmit');
    }

}
