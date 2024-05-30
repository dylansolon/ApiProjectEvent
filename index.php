<?php

require 'vendor/autoload.php';

use App\Router;
use App\Controllers\User;
use App\Controllers\Event;
use App\Controllers\Register;
use App\Controllers\Auth;

new Router([
  'user/:id' => User::class,
  'event' => Event::class,
  'register' => Register::class,
  'auth/:sessionid' => Auth::class,
  'login' => Auth::class,
]);
