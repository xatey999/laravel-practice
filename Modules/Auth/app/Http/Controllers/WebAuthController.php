<?php

namespace Modules\Auth\Http\Controllers;

use App\Actions\CreateUserAction;
use App\DataTransferObjects\RegisterFormPayload;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Auth\Http\Requests\Web\WebLoginRequest;
use Modules\Auth\Http\Requests\RegisterRequest;

class WebAuthController extends Controller
{
    /**
     * Show login form
     */
    public function showLoginForm()
    {
        return view('auth::login');
    }

    /**
     * Handle login request
     */
    public function login(WebLoginRequest $request)
    {
        $credentials = $request->validated();

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended(route('dashboard'));
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    /**
     * Show register form
     */
    public function showRegisterForm()
    {
        return view('auth::register');
    }

    /**
     * Handle register request
     */
    public function register(RegisterRequest $request, CreateUserAction $action)
    {
        $validated = $request->validated();
        
        // Set default role to 'customer' for web registration
        $validated['role'] = $validated['role'] ?? 'customer';
        
        $user = $action->handle(RegisterFormPayload::fromRequest($validated));

        Auth::login($user);

        return redirect(route('dashboard'));
    }

    /**
     * Handle logout request
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
