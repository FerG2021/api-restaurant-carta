<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use \Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


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
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     *  The user has been authenticated
     * 
     * @param Request $request
     * @param mixed $user
     * @return mixed
     * 
     */
    protected function authenticated(Request $request, $user){
        return response()->json($user);
    }


    // public function login( Request $request ){
    //     $user = User::where('email', '=', $request->email)->first();

            
    //     if (isset($user->id)) {
    //         if (Hash::check($request->password, $user->password)) {
    //             # creamos el token 
    //             $token = $user->createToken("auth_token")->plainTextToken;
    //             return response()->json([
    //                 "status" => 1,
    //                 "msg" => "Usuario entra",
    //                 "access_token" => $token,
    //             ], 404);
    //         } else {
    //             # no valido
    //             return response()->json([
    //                 "status" => 0,
    //                 "msg" => "Usuario o contraseña incorrecta",
    //             ], 404);
    //         }
            
    //     } else {
    //         # no valido
    //         return response()->json([
    //             "status" => 0,
    //             "msg" => "Usuario no existe",
    //         ], 404);
    //     }
        

    // }

    
    /**
     * 
     * @param Request $request
     * @return mixed
     */
    protected function loggedOut(Request $request){
        return response()->json(null);

    }


    // traer los datos de mi cuenta para poder visualizarlos
    public function getDatos($id){
        $miCuentaBD = User::find($id);

        if ($miCuentaBD) {
            $listaDevolver = [
                'id' => $miCuentaBD->id,
                'nombre' => $miCuentaBD->name,
                'email' => $miCuentaBD->email,                
            ];

            return $listaDevolver;
        } else {
            return 0;
        }
    }


}
