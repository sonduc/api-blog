<?php

use Illuminate\Http\Request;



$router->get('/', function () use ($router) {
    return 'customer';
});
