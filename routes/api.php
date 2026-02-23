<?php
// routes/api.php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

// Add rate limiting to prevent abuse
Route::middleware('throttle:60,1')->get('/recaptcha-sitekey', function (Request $request) {
    // Optional: Add CSRF protection or token validation
    // $request->validate(['token' => 'required|string']);
    
    return response()->json([
        'sitekey' => config('supabase.recaptcha.site_key')
    ]);
});