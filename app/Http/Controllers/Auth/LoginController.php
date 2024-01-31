<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Illuminate\Auth\Authenticatable as AuthenticableTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\validateCredentials;
use App\Models\VerificarLogin;

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
    protected $redirectTo;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function username(){
        

        return 'alias';
    }
    
    public function logout(){
        Auth::logout();
        session()->invalidate();
        return redirect()->route('login');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->only('alias', 'password');

        if (Auth::attempt($credentials)) {
            // Authentication passed...
            return redirect()->intended('');
        }
        
    }
    function redirectTo()
    {    
        $cadena = "";
        
        $user_user = $_POST['alias'];
        $password = $_POST['password'];
        $dato = 0;
        $verificar_solicitante = VerificarLogin::verificar_solicitante($user_user);
        if(!empty($verificar_solicitante)){
            
            foreach ($verificar_solicitante as $val) {
                session(['cadena' => $val->tipo]);
                session(['usuario' => $val->alias]);
                session(['id' => $val->id]);
            }
            $dato = 1;
            return route('inicio.solicitante');   
        }      
        $verificar_presupuesto = VerificarLogin::verificar_presupuesto($user_user);
        if(!empty($verificar_presupuesto)){
            foreach ($verificar_presupuesto as $val) {
                session(['cadena' => $val->tipo]);
                session(['usuario' => $val->alias]);
                session(['id' => $val->id]);
            }
            $dato = 1;
            return route('inicio.presupuesto');
        }
        $verificar_daf = VerificarLogin::verificar_daf($user_user);
        if(!empty($verificar_daf)){
            foreach ($verificar_daf as $val) {
                session(['cadena' => $val->tipo]);
                session(['usuario' => $val->alias]);
                session(['id' => $val->id]);
            }
            $dato = 1;
            return route('inicio.daf');
        }
        $verificar_bien = VerificarLogin::verificar_bien($user_user);
        if(!empty($verificar_bien)){
            foreach ($verificar_bien as $val) {
                session(['cadena' => $val->tipo]);
                session(['usuario' => $val->alias]);
                session(['id' => $val->id]);
            }
            $dato = 1;
            return route('inicio.bien');
        }
        $verificar_almacen = VerificarLogin::verificar_almacen($user_user);
        if(!empty($verificar_almacen)){
            foreach ($verificar_almacen as $val) {
                session(['cadena' => $val->tipo]);
                session(['usuario' => $val->alias]);
                session(['id' => $val->id]);
            }
            $dato = 1;
            return route('inicio.almacen');
        }

        $verificar_cotizador = VerificarLogin::verificar_cotizador($user_user);
        if(!empty($verificar_cotizador)){
            foreach ($verificar_cotizador as $val) {
                session(['cadena' => $val->tipo]);
                session(['usuario' => $val->alias]);
                session(['id' => $val->id]);
            }
            $dato = 1;
            return route('inicio.cotizador');
        }

        $verificar_adquisicion = VerificarLogin::verificar_adquisicion($user_user);
        if(!empty($verificar_adquisicion)){
            foreach ($verificar_adquisicion as $val) {
                session(['cadena' => $val->tipo]);
                session(['usuario' => $val->alias]);
                session(['id' => $val->id]);
            }
            $dato = 1;
            return route('inicio.adquisicion');
        }
        if($dato == 0){
            echo '<script>alert("Este usuario no cuenta con acceso.");window.location("http://127.0.0.1:8000/");</script>';    
        }
            
    }
}
