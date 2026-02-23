<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmailVerificationController;
use App\Http\Controllers\FormSubmissionController;
use App\Http\Controllers\FormEndpointController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PlaygroundController;
use App\Http\Controllers\LibraryController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\SocialAuthController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Google Captcha Routes
|--------------------------------------------------------------------------
*/
Route::get('/recaptcha-config', function () {
    return response()->json([
        'sitekey' => config('services.recaptcha.site_key'),
    ]);
})->name('recaptcha.config');
Route::get('/captcha/{formId}', [FormSubmissionController::class, 'showCaptcha'])->name('captcha.show');
Route::post('/captcha/{formId}/verify', [FormSubmissionController::class, 'verifyCaptcha'])->name('captcha.verify');
/*
|--------------------------------------------------------------------------
| Google Authentication Routes
|--------------------------------------------------------------------------
*/
Route::get('/auth/{provider}', [SocialAuthController::class, 'redirect'])->name('social.redirect');
Route::get('/auth/callback/{provider}', [SocialAuthController::class, 'callback'])->name('social.callback');

/*
|--------------------------------------------------------------------------
| Public Pages
|--------------------------------------------------------------------------
*/

Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/docs', [PageController::class, 'docs'])->name('docs');
Route::get('/pricing', [PageController::class, 'pricing'])->name('pricing');
Route::get('/ajax', [PageController::class, 'ajax'])->name('ajax');

/*
|--------------------------------------------------------------------------
| Playground Page
|--------------------------------------------------------------------------
*/

Route::withoutMiddleware([\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class])->group(function () {

    // ── Email-based: /f/you@example.com ─────────────────────────────────
    // GET request - Show form endpoint info page (for playground)
    Route::get('/f/{email}', [PlaygroundController::class, 'formEndpointInfo'])
        ->name('playground.endpoint.info')
        ->where('email', '.+@.+');

    // POST request - Handle form submission to email endpoint (playground submission)
    Route::post('/f/{email}', [PlaygroundController::class, 'handleEmailSubmission'])
        ->name('playground.endpoint.submit')
        ->where('email', '.+@.+');

    // ── Slug-based: /f/my-contact-form ──────────────────────────────────
    // GET request - Show form (if you want to display the form)
    Route::get('/f/{slug}', [FormSubmissionController::class, 'show'])
        ->name('form.show')
        ->where('slug', '[^@]+');

    // POST request - Handle form submission (dashboard forms)
    Route::post('/f/{slug}', [FormSubmissionController::class, 'submit'])
        ->name('form.submit')
        ->where('slug', '[^@]+');

    // File upload endpoint for dashboard forms
    Route::post('/f/{slug}/upload', [FormSubmissionController::class, 'upload'])
        ->where('slug', '[^@]+');
});

/*
|--------------------------------------------------------------------------
| Playground Routes
|--------------------------------------------------------------------------
*/

Route::prefix('playground')->name('playground.')->group(function () {
    Route::get('/', [PlaygroundController::class, 'index'])->name('index');
    Route::post('/verify-email', [PlaygroundController::class, 'verifyEmail'])->name('verify');
    Route::get('/confirm-email', [PlaygroundController::class, 'confirmEmail'])->name('confirm-email');
    Route::get('/check-verified', [PlaygroundController::class, 'checkVerified'])->name('check-verified');
    Route::post('/submit', [PlaygroundController::class, 'submit'])->name('submit');
});

// Form submitted thank you page
Route::get('/form-submitted', [PlaygroundController::class, 'formSubmitted'])
    ->name('playground.form.submitted');

/*
|--------------------------------------------------------------------------
| Email Verification
|--------------------------------------------------------------------------
*/

Route::get('/verify-email/{token}', [EmailVerificationController::class, 'verify'])
    ->name('verify.email');

/*
|--------------------------------------------------------------------------
| Authentication
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {
    Route::get('/login',           [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login',          [AuthController::class, 'login']);
    Route::get('/signup',          [AuthController::class, 'showSignup'])->name('signup');
    Route::post('/signup',         [AuthController::class, 'signup']);
    Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('password.request');
    Route::post('/forgot-password',[AuthController::class, 'sendResetLink'])->name('password.email');
});
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| Dashboard (Authenticated)
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->prefix('dashboard')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/forms/create',                   [DashboardController::class, 'createForm'])->name('dashboard.forms.create');
    Route::post('/forms',                          [DashboardController::class, 'storeForm'])->name('dashboard.forms.store');
    Route::get('/forms/{id}',                      [DashboardController::class, 'showForm'])->name('dashboard.forms.show');
    Route::get('/forms/{id}/edit',                 [DashboardController::class, 'editForm'])->name('dashboard.forms.edit');
    Route::put('/forms/{id}',                      [DashboardController::class, 'updateForm'])->name('dashboard.forms.update');
    Route::delete('/forms/{id}',                   [DashboardController::class, 'destroyForm'])->name('dashboard.forms.destroy');
    Route::get('/forms/{id}/export',               [DashboardController::class, 'exportSubmissions'])->name('dashboard.forms.export');
    Route::post('/forms/{id}/resend-verification', [DashboardController::class, 'resendVerification'])->name('dashboard.forms.resend-verification');

    // ── Submissions ──────────────────────────────────────────────────────
    Route::get('/forms/{formId}/submissions/{submissionId}',
        [DashboardController::class, 'showSubmission'])->name('dashboard.submissions.show');

    // Fixed: removed the erroneous /dashboard prefix inside the already-prefixed group
    Route::get('/forms/{formId}/submissions/{submissionId}/download',
        [FormSubmissionController::class, 'downloadFile'])->name('dashboard.submissions.download');

    Route::delete('/forms/{formId}/submissions/{submissionId}',
        [DashboardController::class, 'destroySubmission'])->name('dashboard.submissions.destroy');

    Route::post('/forms/{formId}/submissions/{submissionId}/spam',
        [DashboardController::class, 'markAsSpam'])->name('dashboard.submissions.spam');

    // ── Archive toggle (archive_when_paused setting) ──────────────────────
    Route::patch('/forms/{form}/toggle-archive',
        [FormSubmissionController::class, 'toggleArchive'])->name('dashboard.forms.toggle-archive');
});

/*
|--------------------------------------------------------------------------
| Library
|--------------------------------------------------------------------------
*/

Route::get('/library',                       [LibraryController::class, 'Library'])->name('Home.library');
Route::get('/Application-forms',             [LibraryController::class, 'ApplicationForm'])->name('Home.library.ApplicationForm');
Route::get('/Tenant-Application-forms',      [LibraryController::class, 'TenantApplicationForm'])->name('Home.library.TenantApplicationForm');
Route::get('/Rental-Application-forms',      [LibraryController::class, 'RentalApplicationForm'])->name('Home.library.RentalApplicationForm');
Route::get('/Job-Application-forms',         [LibraryController::class, 'JobApplicationForm'])->name('Home.library.JobApplicationForm');
Route::get('/Scholarship-Application-forms', [LibraryController::class, 'ScholarshipApplicationForm'])->name('Home.library.ScholarshipApplicationForm');
Route::get('/Vendor-Application-forms',      [LibraryController::class, 'VendorApplicationForm'])->name('Home.library.VendorApplicationForm');
Route::get('/Internship-Application-forms',  [LibraryController::class, 'InternshipApplicationForm'])->name('Home.library.InternshipApplicationForm');

