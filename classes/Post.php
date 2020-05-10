<?php

namespace Cmsimple;

use Cmsimple\Validation;

class Post
{
    protected $path = '../content/';
    protected $validate;
    public $error = FALSE;
    protected $msg = [];


    /**
     * Constr.
     */
    public function __construct()
    {
        $this->validate = new Validation();
    }

   /**
    * create
    *
    * @param array $post
    * @return array
    */
    public function create(array $post = null): array
    {

        if($this->validate->filterString($post['title']) == false)
        {
            $this->error = TRUE;
            $this->message[] = 'Title error';
            return $this->message;
        }

        if($this->validate->filterString($post['description']) == false)
        {
            $this->error = TRUE;
            $this->message[] = 'Description error';
            return $this->message;
        }

        if($this->validate->filterText($post['text']) == false)
        {
            $this->error = TRUE;
            $this->message[] = 'Text error';
            return $this->message;
        }

        if($this->validate->filterText($post['id']) == false)
        {
            $this->error = TRUE;
            $this->message[] = 'ID error';
            return $this->message;
        }

        $file = @fopen($this->path . $post['id'] . '.txt', 'w');

        //clean array
        $post = [

            'title' => $post['title'],
            'description' => $post['description'],
            'text' => $post['text'],
            'date' => date("Y-m-d")
        ];

        if(@fwrite($file, json_encode($post, JSON_PRETTY_PRINT)) != FALSE)
        {
            @fclose($file);
            $this->message[] = 'Post saved';
            return $this->message;
        }
        else
        {
            $this->error = TRUE;
            $this->message[] = 'Save Error!';
            return $this->message;
        }
    }
}