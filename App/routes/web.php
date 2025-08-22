<?php
declare(strict_types=1);

use App\Core\Router;
use App\Controllers\AuthController;
use App\Controllers\UserController;
use App\Controllers\EventController;
use App\Controllers\MatchController;

/** @var Router $router */

// Auth
$router->add('POST',  '#^/api/register$#', [AuthController::class, 'register']);
$router->add('POST',  '#^/api/login$#',    [AuthController::class, 'login']);
$router->add('POST',  '#^/api/logout$#',   [AuthController::class, 'logout']);
$router->add('GET',   '#^/api/me$#',       [AuthController::class, 'me']);

// Users (Admin-only for index & destroy; show/update يسمح لصاحب الحساب)
$router->add('GET',   '#^/api/users$#',            [UserController::class, 'index']);
$router->add('GET',   '#^/api/users/(\d+)$#',      [UserController::class, 'show']);
$router->add('PUT',   '#^/api/users/(\d+)$#',      [UserController::class, 'update']);
$router->add('DELETE','#^/api/users/(\d+)$#',      [UserController::class, 'destroy']);

// Events
$router->add('GET',   '#^/api/events$#',           [EventController::class, 'index']);
$router->add('GET',   '#^/api/events/(\d+)$#',     [EventController::class, 'show']);
$router->add('POST',  '#^/api/events$#',           [EventController::class, 'store']);
$router->add('PUT',   '#^/api/events/(\d+)$#',     [EventController::class, 'update']);
$router->add('DELETE','#^/api/events/(\d+)$#',     [EventController::class, 'destroy']);

// Matching
$router->add('GET',   '#^/api/matches$#',          [MatchController::class, 'index']);
