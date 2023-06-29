<?php

use Illuminate\Support\Facades\DB;

$connection = DB::connection();

$GLOBALS['connection'] =$connection;
return $GLOBALS['connection'];
