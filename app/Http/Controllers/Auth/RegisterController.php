<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Rules\AdminPassRule;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $pass = "clab_atom";
        return Validator::make($data, [
            'family_name' => ['required', 'string', 'max:8'],
            'given_name' => ['required', 'string', 'max:8'],
            'number' => ['required', 'integer'],
            'role' => ['required', 'string'],
            'admin' => ['required', 'string'],
            'admin_password' => new AdminPassRule,
            'img_path' => ['image', 'file'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $user = new User;

        $name = $data['family_name'] . " " . $data['given_name'];

        if ($data['admin'] == 'assignment') {
            $admin = "assignment";
        }else{
            $admin = "nonassignment";
        }
        
        if(isset($request->img_path)){
            $img_path = Storage::putFile('/public/profiles', $data['img_path']);
            $img_path = str_replace('public', '/storage', $img_path);

            return User::create([
                'name' => $name,
                'number' => $data['number'],
                'role' => $data['role'],
                'admin' => $admin,
                'img_path' => $img_path,
                'password' => Hash::make($data['password']),
            ]);
        }else{
            return User::create([
                'name' => $name,
                'number' => $data['number'],
                'role' => $data['role'],
                'admin' => $admin,
                'password' => Hash::make($data['password']),
            ]);
        }
   
    }
}
