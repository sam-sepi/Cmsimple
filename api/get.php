<?php

header('Content-Type: application/json');

if(strtolower($_SERVER['REQUEST_METHOD']) == 'get')
{
    $param = strtolower($_SERVER['QUERY_STRING']);

    if(ctype_alnum($param) == TRUE)
    {
        if(file_get_contents('../content/' . $param . '.txt') == false)
        {
            //404
        }
        else
        {
            $data = json_decode(file_get_contents('../content/' . $param . '.txt'), TRUE);

            echo json_encode($data);
        }

    }
    else
    {
        header('HTTP/1.0 400 Bad Request');
        exit();
    }
}
else
{
    header('HTTP/1.0 400 Bad Request');
    exit();
}