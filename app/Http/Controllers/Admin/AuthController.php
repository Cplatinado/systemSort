<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\User as requestUser;
class AuthController extends Controller
{


    public function home()
    {
        return view('login');
    }


    public function Autenticate(Request $request)
    {
        if (in_array('', $request->only('email', 'password'))) {
            $json['message'] = 'Complete todos os campos';

            return response()->json($json);
        }

        if (!filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
            $json['message'] = 'informe um email valido';

            return response()->json($json);
        }

        $credenti =
            [
                'email' => $request->email,
                'password' => $request->password
            ];


        if (!Auth::attempt($credenti)) {
            $json['message'] = 'Usuario e ou senha incorretos';
            return response()->json($json);
        } else {



            $json['redirect'] = route('admin.sorteios.index');
            return response()->json($json);
        }


    }

    public function register()
    {
        return view('register');
    }


    public function registerDo(\App\Http\Requests\User $request)
    {


        $user = User::create($request->all());

        return redirect()->route('admin.login');


    }


    public function logout()
    {
        Auth::logout();
        return redirect()->route('admin.login');
    }

}
