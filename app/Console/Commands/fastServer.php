<?php

namespace App\Console\Commands;

use Amp\Http\Server\DefaultErrorHandler;
use Illuminate\Console\Command;
use Amp\Http\Server\RequestHandler\CallableRequestHandler;
use Amp\Http\Server\HttpServer;
use Amp\Http\Server\Request;
use Amp\Http\Server\Response;
use Amp\Http\Status;
use Amp\Socket\Server;
use Psr\Log\NullLogger;
use Amp\Http\Server\Router;
use Amp\Loop;
use Carbon\Carbon;
use Exception;
use Psr\Log\LoggerInterface;
class fastServer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fast:serve {host=0.0.0.0} {port=1337}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        require base_path().'/routes/microservices.php';
        $now = Carbon::now();
        $now = $now->toString();
        $php = phpversion();

        $host = $this->argument('host');

        $port = $this->argument('port');

        $this->info("[$now] $php Fast Microservice Server (http://$host:$port) started");

        Loop::run(function () use($router, $host,$port) {
            $ipv6 = inet_pton($host);
            $sockets = [
                Server::listen("$host:$port"),
                Server::listen("$ipv6:$port"),
            ];
            $log = new NullLogger();
            try{
            $server = new HttpServer($sockets, $router, $log);
            }catch(Exception $exp){
              dd($exp);
            }
            // $server->ErrorMiddleware();
            $server->start();
            });

        //    Loop::
    }

}
