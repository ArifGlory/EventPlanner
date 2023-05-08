<?php

namespace App\Http\Requests\Auth;

use App\Models\User;
use App\Models\UserHasRole;
use App\Models\UserOtpRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => ['required', 'string'],
            //'password' => ['required', 'string'],
        ];
    }

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function authenticate()
    {
        $this->ensureIsNotRateLimited();
        $email = $this->request->get('email');
        $otp = $this->request->get('otp');

        $cek = UserOtpRequest::where('otp_email',$email)
            ->where('otp_code',$otp)
            ->first();
        if (!$cek){
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'email' => trans('auth.failed'),
            ]);
        }else{
            $user = User::where('email',$email)
                ->first();
            if (!$user){
                $default_pass = "12345678";
                $user = User::create([
                    'name' => $cek->otp_user_name,
                    'email' => $cek->otp_email,
                    'phone' => $cek->otp_phone,
                    'level' => "user",
                    'password' => Hash::make($default_pass),
                ]);

                $usr_has_role = UserHasRole::create([
                    'user_id' => $user->id,
                    'role_id' => 4,
                ]);

                event(new Registered($user));
                Auth::login($user);

                return redirect(RouteServiceProvider::PROFILE_USER);
            }else{
                //TODO loginkan pengguna secara manual
            }

        }
        /*if (!Auth::attempt($this->only('email', 'password'), $this->filled('remember'))) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'email' => trans('auth.failed'),
            ]);
        }
        if (unlessRole(['superadmin','admin'])) {
            RateLimiter::hit($this->throttleKey());
            throw ValidationException::withMessages([
                'email' => 'Mohon maaf role anda tidak bisa mengakses web ini.',
            ]);
        }*/

        RateLimiter::clear($this->throttleKey());
    }

    /**
     * Ensure the login request is not rate limited.
     *
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function ensureIsNotRateLimited()
    {
        if (!RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the rate limiting throttle key for the request.
     *
     * @return string
     */
    public function throttleKey()
    {
        return Str::transliterate(Str::lower($this->input('email')) . '|' . $this->ip());
    }
}
