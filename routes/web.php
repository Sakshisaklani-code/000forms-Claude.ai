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
use Illuminate\Support\Facades\Route;

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

Route::prefix('playground')->name('playground.')->group(function () {
    Route::get('/',               [PlaygroundController::class, 'index'])->name('index');
    Route::post('/verify-email',  [PlaygroundController::class, 'verifyEmail'])->name('verify');
    Route::get('/confirm-email',  [PlaygroundController::class, 'confirmEmail'])->name('confirm-email');
    Route::get('/check-verified', [PlaygroundController::class, 'checkVerified'])->name('check-verified');
    Route::post('/submit',        [PlaygroundController::class, 'submit'])->name('submit');
});

Route::get('/form-submitted', [PlaygroundController::class, 'formSubmitted'])
    ->name('playground.form.submitted');

/*
|--------------------------------------------------------------------------
| Form Endpoints — all CSRF exempt
|
| HOW ROUTING WORKS:
|   Laravel matches routes top to bottom within the group.
|   We use ->where() with a regex that checks for '@' to split:
|     - Contains '@'  → email address → FormEndpointController (playground)
|     - No '@'        → slug          → FormSubmissionController (dashboard forms)
|
|   NOTE: Laravel strips ^ and $ anchors in route where() — so we use
|   a positive lookahead pattern that works without anchors:
|   Email pattern:  '.+@.+'   (must contain @)
|   Slug  pattern:  '[^@]+'   (must NOT contain @)
|--------------------------------------------------------------------------
*/

Route::withoutMiddleware([\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class])->group(function () {

    // ── Email-based: /f/you@example.com ─────────────────────────────────
    // Matches ONLY when segment contains '@'
    Route::get('/f/{email}', [PlaygroundController::class, 'formEndpointInfo'])
        ->name('playground.endpoint.info')
        ->where('email', '.+@.+');

    Route::post('/f/{email}', [FormEndpointController::class, 'handle'])
        ->name('playground.endpoint')
        ->where('email', '.+@.+');

    // ── Slug-based: /f/my-contact-form ──────────────────────────────────
    // Matches ONLY when segment has NO '@' — dashboard forms, completely unchanged
    Route::match(['get', 'post'], '/f/{slug}', [FormSubmissionController::class, 'submit'])
        ->name('form.submit')
        ->where('slug', '[^@]+');

    Route::post('/f/{slug}/upload', [FormSubmissionController::class, 'upload'])
        ->where('slug', '[^@]+');

});

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

Route::get('/auth/{provider}',          [AuthController::class, 'redirectToProvider'])->name('auth.provider');
Route::get('/auth/callback/{provider}', [AuthController::class, 'handleCallback'])->name('auth.callback');
Route::post('/auth/tokens',             [AuthController::class, 'processTokens'])->name('auth.tokens');

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

Route::get('/Test-form',  [TestController::class, 'home'])->name('test-form');
Route::get('/thank-you',  [TestController::class, 'thankYou'])->name('thank-you-form');
Route::get('/formspree',  [TestController::class, 'formspree'])->name('formspree-form');
Route::get('/formsubmit', [TestController::class, 'formsubmit'])->name('formsubmit-form');