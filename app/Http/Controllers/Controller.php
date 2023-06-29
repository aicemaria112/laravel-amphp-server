<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Symfony\Component\Mime\Header\Headers;
use Amp\Coroutine;
use Amp\Http\Server\FormParser;


use Amp\Http\Server\Request as ServerRequest;

use function Amp\Promise\wait;

class Controller extends BaseController
{
    protected static $headers = ['content-type' => 'application/json'];

    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected static function query(ServerRequest $request, string $key)
    {
        $uri = $request->getUri();
        $query = $uri->getQuery();
        $queryParams = [];

        parse_str($query, $queryParams);

        if (!array_key_exists($key, $queryParams)) {
            return null;
        }
        return $queryParams[$key];
    }

    protected static function ginput(ServerRequest $request, string $key)
    {
       return FormParser\parseForm($request);

    }

    public static function input(ServerRequest $request, string $key){

        $in = self::ginput($request,$key);
        $out =  wait($in);
        return $in;
    }
    // protected static function input2 (ServerRequest $request,string $key){
    //     dd(self::input($request, $key)->getReturn());
    // }

}
