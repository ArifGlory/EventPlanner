<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use App\Models\UserHasRole;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    private $BASE_URL_API = "https://privatesale.xomerce.io/autentikasi/";

    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        if (!Auth::check()) {
            return view('myauth.register');

        }
        return redirect('main');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'role' => ['required'],
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', Rules\Password::defaults()],
        ]);

        $role = Role::where('role_name',$request->input('role'))->first();
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'level' => "user",
            'password' => Hash::make($request->password),
        ]);

        $usr_has_role = UserHasRole::create([
            'user_id' => $user->id,
            'role_id' => $role->id_role,
        ]);

        event(new Registered($user));
        Auth::login($user);

        return redirect(RouteServiceProvider::PROFILE_USER);


    }

    public function cekRegisteredEmail(Request $request){
        $email = $request->input('email');
        $url = $this->BASE_URL_API."emailcek?email=".$email;

        $client = new \GuzzleHttp\Client();
        $response = $client->request('GET', $url);

        if ($response->getStatusCode() == 200){
            $json = $response->getBody();
            $data = (array)json_decode($json);

            return Respon($data,true,"Email anda telah terdaftar, silahkan untuk melanjutkan ",$data['code']);
        }else{
            return Respon("",false,"Email tidak terdaftar pada website private sale xomerce, silahkan daftarkan diri dahulu ",202);
        }
    }
}
