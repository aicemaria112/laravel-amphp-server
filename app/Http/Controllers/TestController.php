<?php

namespace App\Http\Controllers;

use Amp\Http\Server\Request as ServerRequest;
use Amp\Http\Server\RequestHandler\CallableRequestHandler;
use Amp\Http\Server\Response;
use Amp\Http\Status;

use Illuminate\Http\Request;
use Amp\Http\Server\Router;
use App\Http\Controllers\Services;
use Amp\Http\Server\FormParser;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\DB;
use Throwable;

class TestController extends Controller
{
   public function index(ServerRequest $request){

        $value = self::query($request,'data');

        $form = yield FormParser\parseForm($request);

     //   $data = ["data"=>$form->getValue('data')];
        try {
            //code...

        $data = User::allD();
    } catch (\Throwable $th) {
        dd($th);
    }

        return new Response(Status::OK, self::$headers, json_encode($data,true)?? "" );

   }

   public function show(ServerRequest $request){

    $args = $request->getAttribute(Router::class);

    $data =["hola"=>$args['name']];

    return new Response(Status::OK,  self::$headers,json_encode($data));
   }


}
