<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

class login_controlador extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    //

    public function verLogin(){
        return view('login', ['msg' => "", 'base_url' => $this -> BASE_URL]);
    }
    public function Login(Request $request){
        $correo = $request -> input('correo');
        $clave = $request -> input('clave');
        //echo $name;

        $client = new \GuzzleHttp\Client();
        try{
            $response = $client -> request('POST', $this -> URL."/login",[
                "json" => [
                    "correo" => $correo,
                    "clave" => $clave
                ]
            ]);
            $data = json_decode($response -> getBody());
            if($response -> getStatusCode()==200){
                $_SESSION["user"] = $data -> data;
                return redirect('/principal');
                //print_r($data -> data);
        }else{
            echo $data -> msg;
        }
        }catch(\GuzzleHttp\Exception\ClientException $th){
            if($th -> hasResponse()){
                $dataE = $th -> getResponse();
                $dataError = json_decode($dataE -> getBody());
                if(is_string($dataError -> data)){
                    return view('login', ['msg' => $dataError -> data, 'base_url' => $this -> BASE_URL]);
                }else{
                    $data = $dataError -> data -> errors;
                    $aux = "";
                    foreach($data as $e){
                        $aux = $aux.$e -> msg."\n";
                    }
                    return view('login', ['msg' => $aux, 'base_url' => $this -> BASE_URL]);
                }
            }else{
                return view('login', ['msg' => $dataError -> data, 'base_url' => $this -> BASE_URL]);
            }
        }
    }
    public function tests(){
        echo "Hola Colegam";
    }
    public function cerrar_session(){
        session_destroy();
        return  redirect('/');
    }
}
