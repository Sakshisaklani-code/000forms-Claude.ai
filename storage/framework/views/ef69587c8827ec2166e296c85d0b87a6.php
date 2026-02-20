

<?php if (! $__env->hasRenderedOnce('c0641cce-c1b0-448a-8bca-4e0812155f54')): $__env->markAsRenderedOnce('c0641cce-c1b0-448a-8bca-4e0812155f54'); ?>
<script>
(function() {
    // ── Load reCAPTCHA script once ──────────────────────────
    const siteKey = '<?php echo e(env("CAPTCHA_SITE_KEY")); ?>';
    if (!siteKey || siteKey === '') return;

    // Inject the reCAPTCHA API script
    const script = document.createElement('script');
    script.src   = 'https://www.google.com/recaptcha/api.js';
    script.async = true;
    script.defer = true;
    document.head.appendChild(script);

    // ── Auto-inject widget into matching forms ──────────────
    function injectCaptcha() {
        // Target: any form POSTing to /f/{slug} (not playground forms)
        // Playground forms post to /playground/submit — excluded
        const forms = document.querySelectorAll(
            'form[action*="/f/"]:not([data-captcha-injected]):not([data-no-captcha])'
        );

        forms.forEach(function(form) {
            // Skip if action is the playground AJAX submit route
            if (form.action.includes('/playground/submit')) return;

            // Skip if already has a recaptcha div
            if (form.querySelector('.g-recaptcha')) return;

            // Create wrapper div
            const wrapper = document.createElement('div');
            wrapper.style.marginBottom = '1rem';

            // reCAPTCHA widget div
            const widget = document.createElement('div');
            widget.className    = 'g-recaptcha';
            widget.dataset.sitekey = siteKey;
            widget.dataset.theme   = 'dark'; // matches your dark theme

            // Error message placeholder
            const errorMsg = document.createElement('p');
            errorMsg.className = 'captcha-error';
            errorMsg.style.cssText = 'color:#ff4d4d;font-size:0.8rem;margin-top:0.4rem;display:none;';
            errorMsg.textContent = '⚠️ Please complete the CAPTCHA.';

            wrapper.appendChild(widget);
            wrapper.appendChild(errorMsg);

            // Insert before the submit button
            const submitBtn = form.querySelector('[type="submit"]');
            if (submitBtn) {
                form.insertBefore(wrapper, submitBtn);
            } else {
                form.appendChild(wrapper);
            }

            // Mark as injected
            form.dataset.captchaInjected = 'true';

            // ── Validate on submit ──────────────────────────
            form.addEventListener('submit', function(e) {
                const response = grecaptcha ? grecaptcha.getResponse() : '';
                if (!response) {
                    e.preventDefault();
                    e.stopImmediatePropagation();
                    errorMsg.style.display = 'block';
                    widget.style.outline   = '2px solid #ff4d4d';
                    widget.style.borderRadius = '4px';
                    return false;
                }
                errorMsg.style.display = 'none';
                widget.style.outline   = '';
            }, true); // capture phase so it runs before other handlers
        });
    }

    // Run after DOM ready and after reCAPTCHA script loads
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', injectCaptcha);
    } else {
        injectCaptcha();
    }

    // Also run after a short delay to catch dynamically rendered forms
    setTimeout(injectCaptcha, 500);
})();
</script>
<?php endif; ?><?php /**PATH C:\Git-folders\000FORMS-Claude.ai\000forms-Claude.ai\resources\views\components\recaptcha.blade.php ENDPATH**/ ?>