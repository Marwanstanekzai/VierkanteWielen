<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Throwable;

class AuthController extends Controller
{
    /**
     * Toon het inlogformulier.
     */
    public function showLoginForm()
    {
        try {
            if (Auth::check()) {
                $user = Auth::user();
                if ($user->isAdmin()) {
                    return redirect()->route('dashboard');
                }

                return redirect()->route('home');
            }

            return view('auth.login');
        } catch (Throwable $e) {
            return response()->view('errors.db_error', [], 500);
        }
    }

    /**
     * Verwerk inlogverzoek.
     */
    public function login(Request $request)
    {
        $request->validate([
            'login' => 'required|string',
            'password' => 'required|string',
        ], [
            'login.required' => 'Vul alstublieft uw e-mailadres of gebruikersnaam in.',
            'password.required' => 'Vul alstublieft uw wachtwoord in.',
        ]);

        try {
            $loginInput = trim($request->input('login'));
            $password = $request->input('password');

            // Bepaal of invoer een e-mailadres of gebruikersnaam is
            $fieldType = filter_var($loginInput, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

            $credentials = [
                $fieldType => $loginInput,
                'password' => $password,
            ];

            if (Auth::attempt($credentials, $request->boolean('remember'))) {
                $request->session()->regenerate();
                $user = Auth::user();

                if ($user->isAdmin()) {
                    return redirect()->intended(route('dashboard'))
                        ->with('success', 'Welkom terug in het beheerpaneel, '.$user->name.'!');
                }

                return redirect()->intended(route('home'))
                    ->with('success', 'Welkom terug, '.$user->name.'!');
            }

            return back()->withInput($request->only('login'))
                ->withErrors(['login' => 'Onjuiste inloggegevens. Controleer uw e-mailadres of gebruikersnaam en wachtwoord.']);
        } catch (Throwable $e) {
            return response()->view('errors.db_error', [], 500);
        }
    }

    /**
     * Uitloggen.
     */
    public function logout(Request $request)
    {
        try {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login')->with('success', 'U bent succesvol uitgelogd.');
        } catch (Throwable $e) {
            return redirect()->route('login');
        }
    }
}
