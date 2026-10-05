<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Pengguna;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    public function showLoginForm()
    {
        return view('login_kppti');
    }

    public function login(Request $request)
    {
        $this->validateLogin($request);

        if (method_exists($this, 'hasTooManyLoginAttempts') && $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
            return $this->sendLoginResponse($request);
        }

        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    /**
     * Get the failed login response instance.
     */
    protected function sendFailedLoginResponse(Request $request)
    {
        throw ValidationException::withMessages([
            $this->username() => __('Email atau kata sandi yang Anda masukkan salah.'),
        ]);
    }

    /**
     * Redirect the user after they have been locked out for too many failed login attempts.
     */
    protected function sendLockoutResponse(Request $request)
    {
        $seconds = $this->limiter()->availableIn(
            $this->throttleKey($request)
        );

        $minutes = (int) ceil($seconds / 60);

        throw ValidationException::withMessages([
            $this->username() => __('Terlalu banyak percobaan login. Silakan coba lagi dalam :minutes menit.', [
                'minutes' => $minutes,
            ]),
        ])->status(Response::HTTP_TOO_MANY_REQUESTS);
    }

    protected function sendLoginResponse(Request $request)
    {
        $user = $request->user();
        $user->load('activeRoles');

        $user_session = [
            'idpengguna' => $user->idpengguna,
            'nama' => $user->nama,
            'email' => $user->email,
            'no_wa' => $user->no_wa,
            'idinstitusi_asal' => $user->idinstitusi_asal,
            'idrole_aktif' => $user->activeRoles->pluck('idrole')[0],
        ];

        if (! array_key_exists($user_session['idrole_aktif'], self::HOME_BY_ROLE)) {
            Auth::logout();

            throw ValidationException::withMessages([
                $this->username() => __('Area untuk role akun Anda belum tersedia.'),
            ]);
        }

        Auth::login($user);
        session(['userdata' => $user_session]);

        return redirect()->intended(route(self::HOME_BY_ROLE[$user_session['idrole_aktif']]))->with('success', 'Login successful!');
    }

    /**
     * The user has been authenticated. Eager-load their active roles.
     */
    protected function authenticated(Request $request, Pengguna $user): void
    {
        $user->load('activeRoles');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        session()->flush();

        return redirect('/login');
    }
}
