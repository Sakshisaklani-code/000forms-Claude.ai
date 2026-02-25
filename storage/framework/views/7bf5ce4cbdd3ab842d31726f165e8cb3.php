
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Your Submission - 000form Playground</title>
    <link rel="stylesheet" href="/css/app.css">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <style>
        body {
            background: #000000;
            min-height: 100vh;
            display: flex;
            align-items: flex-start;
            justify-content: center;
            padding: 4rem 1rem;
            margin: 0;
        }

        .main {
            width: 100%;
            max-width: 520px;
            margin: 2rem auto;
            animation: slideUp 0.5s ease;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Header Section */
        .text-center {
            text-align: center;
            margin-bottom: 2.5rem;
        }

        .text-center h2 {
            font-size: 2.2rem;
            font-weight: 700;
            background: linear-gradient(135deg, #ffffff 0%, #e0e0e0 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 0.75rem;
            letter-spacing: -0.02em;
        }

        .verification-subtitle {
            font-size: 1rem;
            color: #9ca3af;
            margin-bottom: 0.75rem;
        }

        .using-line {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1.25rem;
            background: rgba(139, 139, 143, 0.1);
            border-radius: 100px;
            font-size: 0.9rem;
            color: #00ff88;
            letter-spacing: 0.3px;
            backdrop-filter: blur(10px);
        }

        .using-line span {
            color: #9ca3af;
            font-weight: 400;
        }

        /* Card */
        .verify-card {
            background: #0a0a0a;
            border: 1px solid #2a2a2a;
            border-radius: 24px;
            padding: 2.5rem;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(10px);
            transition: transform 0.3s ease, border-color 0.3s ease;
        }

        .verify-card:hover {
            border-color: #00ff88;
            transform: translateY(-2px);
        }

        /* Form Info */
        .form-info {
            margin-bottom: 2rem;
            padding: 1.25rem;
            background: #111111;
            border-radius: 16px;
            border: 1px solid #2a2a2a;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .form-info::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: linear-gradient(90deg, transparent, #00ff88, transparent);
        }

        .form-info .label {
            color: #9ca3af;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 0.5rem;
        }

        .form-info .name {
            margin: 0;
            font-weight: 700;
            font-size: 1.4rem;
            color: #ffffff;
            word-break: break-word;
        }

        .form-info .email {
            margin: 0.5rem 0 0;
            font-size: 0.9rem;
            color: #00ff88;
            word-break: break-word;
        }

        /* Playground Badge */
        .playground-badge {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            background: rgba(0, 255, 136, 0.1);
            border: 1px solid rgba(0, 255, 136, 0.2);
            border-radius: 100px;
            font-size: 0.7rem;
            color: #00ff88;
            margin-top: 0.5rem;
            font-family: monospace;
        }

        /* reCAPTCHA */
        .recaptcha-wrapper {
            display: flex;
            justify-content: center;
            margin: 2rem 0;
            transform: scale(1);
            transition: transform 0.2s ease;
        }

        .recaptcha-wrapper:hover {
            transform: scale(1.02);
        }

        .g-recaptcha {
            display: inline-block;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
        }

        /* Button */
        .verify-btn {
            width: 70%;
            padding: 1rem;
            font-size: 1.1rem;
            font-weight: 600;
            background: #00ff88;
            border: none;
            border-radius: 12px;
            color: black;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            display: block;
            margin: 0 auto;
        }

        .verify-btn::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }

        .verify-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(0, 255, 136, 0.3);
        }

        .verify-btn:hover::before {
            width: 300px;
            height: 300px;
        }

        .verify-btn:active {
            transform: translateY(0);
        }

        .verify-btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }

        .verify-btn:disabled:hover {
            box-shadow: none;
        }

        .verify-btn:disabled:hover::before {
            display: none;
        }

        /* Privacy Note */
        .privacy-note {
            margin-top: 1.5rem;
            font-size: 0.75rem;
            color: #6b7280;
            text-align: center;
            padding: 0.5rem;
            border-bottom: 1px dashed #2a2a2a;
            padding-bottom: 1.5rem;
        }

        /* Working Line */
        .working-line {
            margin-top: 1.5rem;
            font-size: 0.9rem;
            text-align: center;
            color: #9ca3af;
            font-weight: 400;
            letter-spacing: 0.3px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .working-line::before,
        .working-line::after {
            content: '';
            flex: 1;
            height: 1px;
            background: linear-gradient(90deg, transparent, #2a2a2a, transparent);
        }

        /* Back Link */
        .back-link {
            text-align: center;
            margin-top: 2rem;
        }

        .back-link a {
            color: #6b7280;
            text-decoration: none;
            font-size: 0.9rem;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem 1.5rem;
            border-radius: 100px;
            background: rgba(167, 162, 162, 0.03);
            border: 1px solid #2a2a2a;
            transition: all 0.2s ease;
        }

        .back-link a:hover {
            color: #ffffff;
            border-color: #00ff88;
            gap: 0.75rem;
        }

        .back-link svg {
            width: 16px;
            height: 16px;
            stroke: currentColor;
            transition: transform 0.2s ease;
        }

        .back-link a:hover svg {
            transform: translateX(-3px);
        }

        /* Security Badge */
        .security-badge {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 1rem;
            margin-top: 1.5rem;
        }

        .security-badge-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.8rem;
            color: #6b7280;
        }

        .security-badge-item svg {
            width: 14px;
            height: 14px;
            stroke: #10b981;
        }

        /* Loading Spinner */
        .btn-loader {
            display: none;
            width: 16px;
            height: 16px;
            border: 2px solid rgba(0, 0, 0, 0.3);
            border-top-color: #000000;
            border-radius: 50%;
            animation: spin 0.6s linear infinite;
            margin-left: 0.5rem;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        /* Responsive */
        @media (max-width: 640px) {
            body {
                padding: 1rem;
            }
            
            .main {
                margin: 1rem auto;
            }
            
            .text-center h2 {
                font-size: 1.8rem;
            }
            
            .verify-card {
                padding: 1.5rem;
            }
            
            .form-info .name {
                font-size: 1.2rem;
            }
            
            .recaptcha-wrapper {
                transform: scale(0.95);
            }
            
            .recaptcha-wrapper:hover {
                transform: scale(0.97);
            }
            
            .verify-btn {
                width: 100%;
            }
        }
    </style>
</head>
<body>

    <!-- Main Content -->
    <main class="main">
        <!-- Header Section -->
        <div class="text-center">
            <h2>Verify you're human</h2>
            <p class="verification-subtitle">This quick verification helps us keep spam away</p>
            <div class="using-line">
                <span>You are using</span> 000form Playground
            </div>
        </div>
        
        <!-- Main Card -->
        <div class="verify-card">
            <!-- Form Info -->
            <div class="form-info">
                <p class="label">Verify Captcha For Submission</p>
            </div>
            
            <!-- reCAPTCHA Form -->
            <form action="<?php echo e(route('playground.verify-captcha', ['email' => $email])); ?>" method="POST" id="captchaForm">
                <?php echo csrf_field(); ?>
                <div class="recaptcha-wrapper">
                    <div class="g-recaptcha" data-sitekey="<?php echo e($siteKey); ?>" data-callback="onCaptchaSuccess"></div>
                </div>
                <button type="submit" class="verify-btn" id="submitBtn" disabled>
                    <span id="btnText">Complete Captcha First</span>
                    <span class="btn-loader" id="btnLoader"></span>
                </button>
            </form>
            
            <!-- Privacy Note -->
            <p class="privacy-note">
                Protected by reCAPTCHA | Your privacy is important to us
            </p>

            <!-- Working Line -->
            <p class="working-line">You Are Working with 000form.com</p>
        </div>
        
        <!-- Back Link -->
        <div class="back-link">
            <a href="javascript:history.back()">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M19 12H5M12 19l-7-7 7-7"/>
                </svg>
                Go back to form
            </a>
        </div>

        <!-- Security Badge -->
        <div class="security-badge">
            <div class="security-badge-item">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                </svg>
                <span>reCAPTCHA Protected</span>
            </div>
            <div class="security-badge-item">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"/>
                    <path d="M12 6v6l4 2"/>
                </svg>
                <span>Quick Verification</span>
            </div>
        </div>
    </main>

    <script>
        function onCaptchaSuccess() {
            document.getElementById('submitBtn').disabled = false;
            document.getElementById('btnText').textContent = 'Verify & Continue';
        }

        document.getElementById('captchaForm').addEventListener('submit', function(e) {
            const btn = document.getElementById('submitBtn');
            const btnText = document.getElementById('btnText');
            const btnLoader = document.getElementById('btnLoader');
            
            btn.disabled = true;
            btnText.textContent = 'Verifying...';
            btnLoader.style.display = 'inline-block';
        });
    </script>
</body>
</html><?php /**PATH C:\Git-folders\000FORMS-Claude.ai\000form\resources\views/pages/playground-captcha.blade.php ENDPATH**/ ?>