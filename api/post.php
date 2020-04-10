<?php
require('../vendor/autoload.php');

header('Content-Type: application/json');

if(strtolower($_SERVER['REQUEST_METHOD']) == 'post')
{
    $headers = getallheaders();

    if(isset($headers['authorization'])) 
    {
        if(preg_match('/Bearer\s(\S+)/', $headers['authorization'], $matches)) 
        {
            $jwt = new Cmsimple\Token;

            if($jwt->verify($matches[1]) == true)
            {
                $json = json_decode(file_get_contents('php://input'), TRUE);
                
                if(empty($json))
                {
                    header('HTTP/1.0 400 Bad Request');
                    exit();
                }
                else
                {
                    $post = new Cmsimple\Post($json);
                    $post->create();
                }
            }
            else
            {
                header('HTTP/1.0 401 Unauthorized');
                exit();
            }
        }
    }
    else
    {
        header('HTTP/1.0 401 Unauthorized');
        exit();
    }
}
else 
{
    header('HTTP/1.0 400 Bad Request');
    exit();
}