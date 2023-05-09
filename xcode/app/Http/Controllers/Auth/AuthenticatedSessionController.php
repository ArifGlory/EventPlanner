<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use App\Models\UserHasRole;
use App\Models\UserOtpRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;

class AuthenticatedSessionController extends Controller
{
    private $BASE_URL_API = "https://privatesale.xomerce.io/autentikasi/";
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        if (!Auth::check()) {
            return view('myauth.login');

        }
        return redirect('main');

    }

    /**
     * Handle an incoming authentication request.
     *
     * @param \App\Http\Requests\Auth\LoginRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LoginRequest $request)
    {
        $request->authenticate();

        $request->session()->regenerate();

        /*if (cekRoleAkses("user")){
            return redirect()->intended(RouteServiceProvider::PROFILE_USER);
        }else{
            return redirect()->intended(RouteServiceProvider::DASHBOARD);
        }*/
        return redirect()->intended(RouteServiceProvider::PROFILE_USER);
    }

    /**
     * Destroy an authenticated session.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        //activity()->log('Logout');
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function requestOtp(Request $request){
        $email = $request->input('email');

        $url = $this->BASE_URL_API."emailcek?email=".$email;
        $client = new \GuzzleHttp\Client();
        $response = $client->request('GET', $url);
        $data = array();

        if ($response->getStatusCode() == 200){
            $json = $response->getBody();
            $data_user = (array)json_decode($json);

            $six_digit_random_number = random_int(100000, 999999);
            $otp_request['otp_user_name'] = $data_user['name'];
            $otp_request['otp_email'] = $request->email;
            $otp_request['otp_phone'] = $data_user['phone'];
            $otp_request['otp_code'] = $six_digit_random_number;
            UserOtpRequest::create($otp_request);

            //TODO send email otp ke email pengguna

            $msg = "Kode OTP telah dikirimkan ke email anda";
            return Respon($data,true,$msg,200);
        }else{

            $msg = "Email anda belum terdaftar di privatesale, silahkan daftar terlebih dahulu";
            return Respon($data,false,$msg,202);
        }
    }
}
