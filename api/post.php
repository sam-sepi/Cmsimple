<?php

header('Content-Type: application/json');

if(strtolower($_SERVER['REQUEST_METHOD']) == 'post')
{
    if(isset($_SERVER['Authorization'])) 
    {
        $headers = trim($_SERVER["Authorization"]);
        
        if(!empty($headers)) 
        {
            if (preg_match('/Bearer\s(\S+)/', $headers, $matches)) 
            {
                if($jwt->decode($matches[1]) == true)
                {

                }
                else
                {
                    header('HTTP/1.0 401 Unauthorized');
                    exit();
                }
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