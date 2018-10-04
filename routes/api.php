<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::post('/v1/public/pagamentos', function () {

    request()->validate([
        'numero_cartão'=>'required',
        'valor'=>'required',
        'pedidos_id'=>'required'
    ]);

    $client = new \GuzzleHttp\Client();

    $token = request()->header('Authorization');
    if(!$token){
        return response(['message'=>'Authorization header is missing'],400);
    }
    try{
        $res = $client->request('GET', 'http://localhost:5001/user/'.$token);
        $status = $res->getStatusCode();
        if($status==200){
            return([
                'user'=>[
                    'id'=>0,
                    'name'=>'Diego Matias de Oliviera',
                    'cpf'=>'111.111.111-11'
                ],
                'numero_cartão'=> request()->numero_cartão,
                'valor'=> request()->valor,
                'pedidos_id'=> request()->pedidos_id
            ]);
        }
        else{
            return response(['message'=>'Not authorized'],400);
        }
    }catch(Exception $e){
        $class = get_class($e);
        if($class == 'GuzzleHttp\Exception\ConnectException'){
            return response(['message'=>'Could not comunicate with authentication service'],500);
        }
        return get_class('Server error',500);
    }
});

Route::get('/v1/public/pagamentos/{pagamentoId}', function ($pagamentoId) {
    return([
        'id'=>$pagamentoId,
        'user'=>[
            'id'=>0,
            'name'=>'Diego Matias de Oliviera',
            'cpf'=>'111.111.111-11'
        ],
        'numero_cartão'=> '1234567891112',
        'valor'=> '150',
        'pedidos_id'=> 1
    ]);
});

Route::get('/',function(){
    return(['message'=>'worked']):
}):
