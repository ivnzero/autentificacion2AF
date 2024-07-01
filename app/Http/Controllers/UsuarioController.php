<?php

namespace App\Http\Controllers;

use App\Models\UsuarioM;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    //

    public function index(Request $request){
        if( !$request->session()->has('logeado') or $request->session()->get('logeado') != 1 ){
            $request->session()->forget(['usuario','clave','logeado']);
            return view('login');
        }
        else{
            return redirect('dashboard');
        }
    }

    public function dobleFactorW(Request $request){
        if( (!$request->session()->has('2afActivo') or $request->session()->get('2afActivo') != 1) and ($request->session()->has('logeado') or $request->session()->get('logeado') == 1) ){
            return view('activar_autentificacion');
        }
        else if($request->session()->has('logeado') or $request->session()->get('logeado') == 1){
            return redirect('dashboard');
        }
        else{
            return redirect('/');
        }
    }

    public function login(Request $request){
        $mensaje = '';
        $mensaje .= ( empty($request['usuario']) ) ? 'Falta el usuario. <br>' : "";
        $mensaje .= ( empty($request['contrasenia']) ) ? "Falta la contraseña." : "";

        if( !empty($mensaje) ) return view('login')->with(compact('mensaje'));

        $passCif = md5( (strrev($request['contrasenia']) . '&' . $request['contrasenia']) );

        $where = [
            ['usuario','=',$request['usuario']],
            ['contrasenia','=',$passCif],
        ];

        $usuario = UsuarioM::login($where);

        if( count($usuario) <= 0 ) return view('login')->with(['mensaje'=>'El usuario no existe o están mal sus credenciales.']);

        if( empty($usuario[0]->key_2af) ) {
            $clave =  $request->session()->get('clave');

            $ga = new \GoogleAuthenticator\PHPGangsta_GoogleAuthenticator();
            $secret = ( empty($clave) ) ? $ga->createSecret() : $clave;
            $qrCodeUrl = $ga->getQRCodeGoogleUrl('BeltSoft', $secret);
            $oneCode = $ga->getCode($secret);
    
            $request->session()->put('usuario',$usuario[0]->id_user);
            $request->session()->put('clave',$secret);
            $request->session()->put('codigo',$oneCode);

            return view('activar_autentificacion')->with([
                'qrURL'=>$qrCodeUrl,
                'codigo'=>$oneCode,
            ]);
        }else{
            $request->session()->put('usuario',$usuario[0]->id_user);
            $request->session()->put('clave',$usuario[0]->key_2af);

            return view('validar2af');
        }
        
        return redirect('dashboard');
    }

    public function activar2AF(Request $request){

        $codigoInput = '';
        $clave =  $request->session()->get('clave');

        for ($i=0; $i < 6; $i++) { 
            $codigoInput .= $request->input('digito-'.($i+1));
        }

        $ga = new \GoogleAuthenticator\PHPGangsta_GoogleAuthenticator();
        $secret = $clave;
        $checkResult = $ga->verifyCode($secret, $codigoInput, 1); 
    
        if(!$checkResult ){
            $qrCodeUrl = $ga->getQRCodeGoogleUrl('BeltSoft', $secret);
            $oneCode = $ga->getCode($secret);

            return view('activar_autentificacion')->with([
                'qrURL'=>$qrCodeUrl,
                'codigo'=>$oneCode,
                'errorMessage'=>'Los códigos no coinciden. <br> Recargue la pagina si sigue el problema continua.'
            ]);
        }
        else{
            $whereParam = [
                ['id_user','=',$request->session()->get('usuario')]
            ];
            $updateParam = ['key_2af'=>$secret];

            $update2AF = UsuarioM::actualizarUsuario($whereParam,$updateParam);

            if($update2AF != 1){
                $qrCodeUrl = $ga->getQRCodeGoogleUrl('BeltSoft', $secret);
                $oneCode = $ga->getCode($secret);
    
                return view('activar_autentificacion')->with([
                    'qrURL'=>$qrCodeUrl,
                    'codigo'=>$oneCode,
                    'errorMessage'=>'No se activo su doble factor de seguridad. <br> Intente otra vez por favor.'
                ]);
            }

            $request->session()->put('logeado',1);
            $request->session()->put('2afActivo',1);
            
            return redirect('dashboard');
        }       
    }


    public function validar2AF(Request $request){
        $clave = $request->session()->get('clave');
        $codigoInput = '';

        for ($i=0; $i < 6; $i++) { 
            $codigoInput .= $request->input('digito-'.($i+1));
        }

        $ga = new \GoogleAuthenticator\PHPGangsta_GoogleAuthenticator();
        $secret = $clave;
        $checkResult = $ga->verifyCode($secret, $codigoInput, 1); 
    
        if(!$checkResult ){
            return view('validar2af')->with([
                'errorMessage'=>'El codigo ya caduco, intente de nuevo.'
            ]);
        }
        else{
            $request->session()->put('logeado',1);
            $request->session()->put('2afActivo',1);
            
            return redirect('dashboard');
        }
    }

    public function logout(Request $request){
        $request->session()->flush();
        return redirect('/');
    }
}
