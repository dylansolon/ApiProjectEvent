<?php

require 'vendor/autoload.php';

use App\Router;
use App\Controllers\User;
use App\Controllers\Auth;

new Router([
    'user/:id' => User::class,
    'auth' => Auth::class
]);
