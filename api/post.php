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

            try
            {
                if($jwt->verify($matches[1]) == true)
                {
                    $json = json_decode(file_get_contents('php://input'), TRUE);
                    
                    $post = new Cmsimple\Post();
                    $response = $post->create($json);

                    if($post->error == TRUE)
                    {
                        echo json_encode($response, JSON_PRETTY_PRINT);
                        header('HTTP/1.0 400 Bad Request');
                        exit();
                    }
                    else
                    {
                        echo json_encode($response, JSON_PRETTY_PRINT);
                    }
                }
                else
                {
                    header('HTTP/1.0 401 Unauthorized');
                    exit();
                }

            } catch(Exception $e) //intercept firebase Exception
            {
                header('HTTP/1.0 401 Unauthorized');
                exit();
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
        header('HTTP/1.0 401 Unauthorized');
        exit();
    }
}
else 
{
    header('HTTP/1.0 400 Bad Request');
    exit();
}