<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    // protected $except = [
    //     // Exact route patterns - be very specific
    //     'f/*',
    //     'f/*/*',
    //     'f/*?*', // With query parameters
    //     'f*', // Catch all f routes
    //     '*/f/*',
        
    //     // Your specific form submission routes
    //     'f/*/submit',
    //     'form/submit/*',
        
    //     // Development URLs (if needed)
    //     '127.0.0.1:8000/f/*',
    //     'localhost:8000/f/*',
        
    //     // Wildcard for all form endpoints
    //     '*f*',
    // ];
    protected $except = [
        // Allow EVERYTHING - for testing
        '*',
    ];
}