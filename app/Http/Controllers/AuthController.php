<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\SupabaseAuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    protected SupabaseAuthService $supabase;

    public function __construct(SupabaseAuthService $supabase)
    {
        $this->supabase = $supabase;
    }

    /**
     * Show login page.
     */
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        return view('auth.login');
    }

    /**
     * Show signup page.
     */
    public function showSignup()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        return view('auth.signup');
    }

    /**
     * Handle email/password signup.
     */
    // public function signup(Request $request)
    // {
    //     $request->validate([
    //         'email' => 'required|email|max:255',
    //         'password' => 'required|min:8|confirmed',
    //     ]);

    //     $result = $this->supabase->signUp(
    //         $request->input('email'),
    //         $request->input('password')
    //     );

    //     if (!$result['success']) {
    //         return back()
    //             ->withInput()
    //             ->withErrors(['email' => $result['error']]);
    //     }

    //     // Check if email confirmation is required
    //     if (isset($result['data']['user']) && empty($result['data']['session'])) {
    //         return redirect()->route('login')
    //             ->with('message', 'Please check your email to confirm your account.');
    //     }

    //     // Auto-login if no confirmation required
    //     if (isset($result['data']['session'])) {
    //         $this->storeSession($result['data']);
    //         return redirect()->route('dashboard');
    //     }

    //     return redirect()->route('login')
    //         ->with('message', 'Account created! Please check your email to verify.');
    // }

    /**
     * Handle email/password signup.
     */
    public function signup(Request $request)
    {
        $request->validate([
            'email' => 'required|email|max:255',
            'password' => 'required|min:8|confirmed',
        ]);

        // Check if user already exists in your database
        $existingUser = User::where('email', $request->input('email'))->first();
        if ($existingUser) {
            return back()
                ->withInput($request->only('email'))
                ->withErrors(['email' => 'An account with this email already exists. Please login instead.']);
        }

        $result = $this->supabase->signUp(
            $request->input('email'),
            $request->input('password')
        );

        if (!$result['success']) {
            return back()
                ->withInput($request->only('email'))
                ->withErrors(['email' => $result['error']]);
        }

        // Additional check: if Supabase returns a user but no session and no confirmation needed,
        // it might be an existing user
        if (isset($result['data']['user']) && 
            empty($result['data']['session']) && 
            !isset($result['data']['user']['confirmation_sent_at'])) {
            return back()
                ->withInput($request->only('email'))
                ->withErrors(['email' => 'An account with this email already exists. Please login instead.']);
        }

        // Check if email confirmation is required
        if (isset($result['data']['user']) && empty($result['data']['session'])) {
            return redirect()->route('login')
                ->with('message', 'Please check your email to confirm your account.');
        }

        // Auto-login if no confirmation required
        if (isset($result['data']['session'])) {
            $this->storeSession($result['data']);
            return redirect()->route('dashboard');
        }

        return redirect()->route('login')
            ->with('message', 'Account created! Please check your email to verify.');
    }

    /**
     * Handle email/password login.
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $result = $this->supabase->signIn(
            $request->input('email'),
            $request->input('password')
        );

        if (!$result['success']) {
            return back()
                ->withInput()
                ->withErrors(['email' => $result['error']]);
        }

        $this->storeSession($result['data']);

        return redirect()->intended(route('dashboard'));
    }

    /**
     * Redirect to OAuth provider.
     */
    public function redirectToProvider(string $provider)
    {
        $allowedProviders = ['google'];

        if (!in_array($provider, $allowedProviders)) {
            abort(404);
        }

        $redirectUrl = $this->supabase->getOAuthUrl(
            $provider,
            route('auth.callback', ['provider' => $provider])
        );

        return redirect($redirectUrl);
    }

    /**
     * Handle OAuth callback.
     */
    public function handleCallback(Request $request, string $provider)
    {
        // Supabase redirects with access_token in URL fragment
        // We need to handle this client-side and send to server
        
        if ($request->has('access_token')) {
            $accessToken = $request->input('access_token');
            $refreshToken = $request->input('refresh_token');

            $userData = $this->supabase->getUser($accessToken);

            if ($userData) {
                $user = $this->supabase->syncUser($userData);
                
                Session::put('supabase_access_token', $accessToken);
                Session::put('supabase_refresh_token', $refreshToken);
                
                Auth::login($user);

                return redirect()->route('dashboard');
            }
        }

        // Check for error
        if ($request->has('error')) {
            return redirect()->route('login')
                ->withErrors(['oauth' => $request->input('error_description', 'Authentication failed')]);
        }

        // If we have a code, exchange it
        if ($request->has('code')) {
            $result = $this->supabase->exchangeCodeForSession($request->input('code'));

            if ($result['success'] && isset($result['data']['session'])) {
                $this->storeSession($result['data']);
                return redirect()->route('dashboard');
            }
        }

        // Return view to handle client-side token extraction
        return view('auth.callback', ['provider' => $provider]);
    }

    /**
     * Process tokens from client-side.
     */
    public function processTokens(Request $request)
    {
        $request->validate([
            'access_token' => 'required|string',
            'refresh_token' => 'required|string',
        ]);

        $userData = $this->supabase->getUser($request->input('access_token'));

        if (!$userData) {
            return response()->json(['error' => 'Invalid token'], 401);
        }

        $user = $this->supabase->syncUser($userData);

        Session::put('supabase_access_token', $request->input('access_token'));
        Session::put('supabase_refresh_token', $request->input('refresh_token'));

        Auth::login($user);

        return response()->json(['redirect' => route('dashboard')]);
    }

    /**
     * Handle logout.
     */
    public function logout(Request $request)
    {
        $accessToken = Session::get('supabase_access_token');

        if ($accessToken) {
            $this->supabase->signOut($accessToken);
        }

        Auth::logout();
        Session::invalidate();
        Session::regenerateToken();

        return redirect()->route('home');
    }

    /**
     * Show forgot password page.
     */
    public function showForgotPassword()
    {
        return view('auth.forgot-password');
    }

    /**
     * Send password reset email.
     */
    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $result = $this->supabase->sendPasswordReset($request->input('email'));

        // Always show success to prevent email enumeration
        return back()->with('message', 'If an account exists with that email, you will receive a password reset link.');
    }

    /**
     * Store Supabase session data.
     */
    protected function storeSession(array $data): void
    {
        if (isset($data['session'])) {
            Session::put('supabase_access_token', $data['session']['access_token']);
            Session::put('supabase_refresh_token', $data['session']['refresh_token']);
        } elseif (isset($data['access_token'])) {
            Session::put('supabase_access_token', $data['access_token']);
            Session::put('supabase_refresh_token', $data['refresh_token'] ?? null);
        }

        if (isset($data['user'])) {
            $user = $this->supabase->syncUser($data['user']);
            Auth::login($user);
        }
    }
}
