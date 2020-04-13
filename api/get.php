<?php

header('Content-Type: application/json');

if(strtolower($_SERVER['REQUEST_METHOD']) == 'get')
{
    $param = strtolower($_SERVER['QUERY_STRING']);

    if(ctype_alnum($param) == TRUE)
    {
        if(@file_get_contents('../content/' . $param . '.txt') == false)
        {
            $post = [
                'title' => 'Page 404',
                'description' => 'Not Found',
                'text' => 'Resource not found'
            ];

            echo json_encode($post);

            header('HTTP/1.0 404 Not Found');
            exit();

        }
        else
        {
            $data = json_decode(@file_get_contents('../content/' . $param . '.txt'), TRUE);

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