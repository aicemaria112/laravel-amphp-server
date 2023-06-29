<?php
// dd();
require base_path().'/vendor/autoload.php';

use Amp\Http\Server\RequestHandler\CallableRequestHandler;
use Amp\Http\Server\HttpServer;
use Amp\Http\Server\Request;
use Amp\Http\Server\Response;
use Amp\Http\Status;
use Amp\Socket\Server;
use Psr\Log\NullLogger;
use Amp\Http\Server\Router;
use App\Http\Controllers\TestController;

$router = new Router();


$router->addRoute('POST', '/a', new CallableRequestHandler([TestController::class,'index']));
// $router->addRoute('POST', '/a', [new TestController,'index']);


$router->addRoute('GET', '/{name}', new CallableRequestHandler([TestController::class,'show']));


return $router;
