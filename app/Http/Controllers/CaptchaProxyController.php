<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CaptchaProxyController extends Controller
{
    /**
     * Returns a JS snippet that injects the reCAPTCHA script + widget
     * into the page — site key is never exposed to the end user.
     */
    public function script(Request $request)
    {
        $siteKey = config('supabase.recaptcha.site_key');

        $js = <<<JS
(function() {
    // Load reCAPTCHA script
    var s = document.createElement('script');
    s.src = 'https://www.google.com/recaptcha/api.js';
    s.async = true;
    s.defer = true;
    document.head.appendChild(s);

    // Inject widget into placeholder div
    document.addEventListener('DOMContentLoaded', function() {
        var targets = document.querySelectorAll('.formflow-captcha');
        targets.forEach(function(el) {
            el.setAttribute('data-sitekey', '{$siteKey}');
            el.classList.add('g-recaptcha');
        });
    });
})();
JS;

        return response($js, 200)
            ->header('Content-Type', 'application/javascript')
            ->header('Cache-Control', 'public, max-age=3600');
    }
}