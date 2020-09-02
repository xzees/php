<?php

namespace App\Http\Middleware;

use Closure;

class RemoveInjection
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {   
        // if(isset($_POST)){
        //     $this->realEscapeString($_POST);
        // }
        // if(isset($_GET)){
        //     $this->realEscapeString($_GET);
        // }
        // $this->realEscapeString($request);

        return $next($request);
    }
    public function realEscapeString(&$data)
    {
        // dd(env("DB_HOST_PG"),env('DB_USERNAME_PG'),env('DB_PASSWORD_PG'))
        try{
            if(!isset($this->connect)){
                $this->connect = new \mysqli(env("DB_HOST_PG"),env('DB_USERNAME_PG'),env('DB_PASSWORD_PG'));
            }
            if(is_object($data)){
                $array = $data->toArray();
            }else{
                $array = $data;
            }
            foreach($array as $k=>$v) {
                if(is_array($v)){
                    $this->realEscapeString($v);
                }else{
                    $data[$k] = htmlspecialchars(mysqli_real_escape_string($this->connect,$v));
                }
            }
        }catch(\Exception $e){
            dd($e->getMessage());
        }
    }
}
