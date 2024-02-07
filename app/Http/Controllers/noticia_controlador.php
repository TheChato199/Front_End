<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

class noticia_controlador extends Controller
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

    public function principal(){

        $client = new \GuzzleHttp\Client();
        try{
            $response = $client -> request('GET', $this -> URL."/admin/noticias");
            $data = json_decode($response -> getBody());
            return view('fragmentos/principal', ['msg' => "", 'base_url' => $this -> BASE_URL, 'noticia' => $data -> data]);

        }catch(\GuzzleHttp\Exception\ClientException $th){
            return view('fragmentos/principal', ['msg' => "", 'base_url' => $this -> BASE_URL, 'noticia' => []]);
        }
    }
    public function noticia(Request $request){

        $client = new \GuzzleHttp\Client();
        $session = $_SESSION["user"];
        //print_r($session);
        try{
            $response = $client -> request('GET', $this -> URL."/admin/noticias/user/".$session -> external, ['headers' => ['api-token' => $session -> token]]);
            $data = json_decode($response -> getBody());
            return view('fragmentos/noticia', ['msg' => "", 'base_url' => $this -> BASE_URL, 'noticia' => $data -> data]);
            //print_r($session);

        }catch(\GuzzleHttp\Exception\ClientException $th){
            return view('fragmentos/noticia', ['msg' => "", 'base_url' => $this -> BASE_URL, 'noticia' => []]);
        }
    }
    public function view_guardar(Request $request){
        return view('fragmentos/reg_noticia', ['msg' => "", 'base_url' => $this -> BASE_URL]);
        
    }
    public function guardar(Request $request){
        $titulo = $request -> input('titulo');
        $cuerpo = $request -> input('cuerpo');
        //echo $name;

        $client = new \GuzzleHttp\Client();
        try{
            $session = $_SESSION['user'];
            $response = $client -> request('POST', $this -> URL."/admin/noticias/guardar",[
                "json" => [
                    "titulo" => $titulo,
                    "cuerpo" => $cuerpo,
                    "fecha" => date("Y-m-d "),
                    "external_user" => $session -> external 
                ], 'headers' => ['api-token' => $session -> token]
            ]);
            $data = json_decode($response -> getBody());
            if($response -> getStatusCode()==200){
                return redirect('/admin/noticias');
        }
        }catch(\GuzzleHttp\Exception\ClientException $th){
            if($th -> hasResponse()){
                $dataE = $th -> getResponse();
                $dataError = json_decode($dataE -> getBody());
                if(is_string($dataError -> data)){
                    return view('fragmentos/reg_noticia', ['msg' => $dataError -> data, 'base_url' => $this -> BASE_URL]);
                }else{
                    $data = $dataError -> data -> errors;
                    $aux = "";
                    foreach($data as $e){
                        $aux = $aux.$e -> msg."\n";
                    }
                    return view('fragmentos/reg_noticia', ['msg' => $aux, 'base_url' => $this -> BASE_URL]);
                }
            }else{
                return view('fragmentos/reg_noticia', ['msg' => $dataError -> data, 'base_url' => $this -> BASE_URL]);
            }
        }
    }
    public function view_editar(Request $request, $external){
        $client = new \GuzzleHttp\Client();
        try{
            $response = $client -> request('GET', $this -> URL."/admin/noticias/".$external);
            $data = json_decode($response -> getBody());
            return view('fragmentos/mod_noticia', ['msg' => "", 'base_url' => $this -> BASE_URL, 'noticia' => $data -> data]);

        }catch(\GuzzleHttp\Exception\ClientException $th){
            return view('admin/noticia');
        }
    }
    public function modificar(Request $request){
        $titulo = $request -> input('titulo');
        $cuerpo = $request -> input('cuerpo');
        $external = $request -> input('external');
        $client = new \GuzzleHttp\Client();
        try{
            $session = $_SESSION['user'];
            $response = $client -> request('POST', $this -> URL."/admin/noticias/modificar",[
                "json" => [
                    "titulo" => $titulo,
                    "cuerpo" => $cuerpo,
                    "external_noticia" => $external 
                ], 'headers' => ['api-token' => $session -> token]
            ]);
            $data = json_decode($response -> getBody());
            if($response -> getStatusCode()==200){
                return redirect('/admin/noticias');
        }
        }catch(\GuzzleHttp\Exception\ClientException $th){
            if($th -> hasResponse()){
                $dataE = $th -> getResponse();
                $dataError = json_decode($dataE -> getBody());
                if(is_string($dataError -> data)){
                    return view('fragmentos/mod_noticia', ['msg' => $dataError -> data, 'base_url' => $this -> BASE_URL]);
                }else{
                    $data = $dataError -> data -> errors;
                    $aux = "";
                    foreach($data as $e){
                        $aux = $aux.$e -> msg."\n";
                    }
                    return view('fragmentos/mod_noticia', ['msg' => $aux, 'base_url' => $this -> BASE_URL]);
                }
            }else{
                return view('fragmentos/mod_noticia', ['msg' => $dataError -> data, 'base_url' => $this -> BASE_URL]);
            }
        }
    }
}
