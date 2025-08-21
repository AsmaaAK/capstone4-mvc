<?php
declare(strict_types=1);



if (session_status()== PHP_SESSION_NONE)
    { 
    session_start();}   

require __DIR__ . '/../vendor/autoload.php';

use App\Core\Router;

$router = new Router();
require __DIR__.'/../App/routes/web.php';

$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
$uri    = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);

$router->dispatch($method, $uri);
