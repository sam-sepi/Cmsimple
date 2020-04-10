<?php

header("Content-Type: application/json;charset=utf-8");

require('../vendor/autoload.php');

$dotenv = Dotenv\Dotenv::createImmutable('../');
$dotenv->load();

$jwt = new Cmsimple\Token;

if(strtolower($_SERVER['REQUEST_METHOD']) == 'post')
{
    $json = json_decode(file_get_contents('php://input'));

    if(($json->user == null) or ($json->pass == null))
    {
        header('HTTP/1.0 400 Bad Request');
        exit('Bad Request'); 
    }

    if(($json->user == $_ENV['USER_NAME']) and (password_verify($json->pass, $_ENV['PASSWORD'])))
    {
        echo json_encode(['jwt' => $jwt->getToken($json->user)]);
    }
    else
    {
        header('HTTP/1.0 401 Unauthorized');
        exit('Unauthorized');
    }
}
else
{
    header('HTTP/1.0 400 Bad Request');
    exit('Bad Request');
}