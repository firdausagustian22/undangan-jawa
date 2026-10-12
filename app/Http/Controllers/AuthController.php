<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthController extends Controller
{
    /**
     * Show admin login form.
     */
    public function showLogin(): View|RedirectResponse
    {
        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.auth.login');
    }

    /**
     * Process admin login.
     */
    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            AuditLog::record(
                'LOGIN',
                'Admin ' . Auth::user()->name . ' berhasil masuk ke sistem.',
                Auth::id()
            );

            return redirect()->intended(route('admin.dashboard'))
                ->with('success', 'Sugeng rawuh, ' . Auth::user()->name . '!');
        }

        return back()->withErrors([
            'email' => 'Email atau kata sandi tidak cocok dengan data kami.',
        ])->onlyInput('email');
    }

    /**
     * Process admin logout.
     */
    public function logout(Request $request): RedirectResponse
    {
        if (Auth::check()) {
            AuditLog::record(
                'LOGOUT',
                'Admin ' . Auth::user()->name . ' keluar dari sistem.',
                Auth::id()
            );
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('info', 'Panjenengan sampun kasil medal (berhasil keluar).');
    }
}
