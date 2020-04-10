<?php

namespace Cmsimple;

class Post
{
    protected $post = [];
    protected $path = '../content/';

    public function __construct(array $post) //verificarlo a livello di API e resitituire BAD REQUEST in caso mancasse una proprietà necessaria
    {
        if($this->filterString($post['title']) == true)
        {
            $this->post['title'] = $post['title'];
        }
        else
        {
            $this->post['title'] = 'Title undefined';
        }

        if($this->filterString($post['description']) == true)
        {
            $this->post['description'] = $post['description'];
        }
        else
        {
            $this->post['description'] = 'Description undefined';
        }

        if($this->filterText($post['text']) == true)
        {
            $this->post['text'] = $post['text'];
        }
        else
        {
            $this->post['text'] = 'Text undefined';
        }
    }

    protected function filterString(string $string = null): bool
    {
        if(isset($string)):

            $string = filter_var($string, FILTER_SANITIZE_STRING);
            
            if(trim($string) !== null):
                return true;
            else:
                return false;
            endif;

        else:
            return false;
        endif;
    }

    protected function filterText(string $text = null, $html = FALSE): bool
    {
        if(isset($text))
        {
            if($html == FALSE) 
            {
                $text = filter_var($text, FILTER_SANITIZE_STRING);
            
                if(trim($text) !== null):

                    return true;
                else:

                    return false;
                endif;
            }
            else
            {
                $tags = [

                    "#( on[a-zA-Z]+=\"?'?[^\s\"']+'?\"?)#is"=> "",
                    "#(javascript:[^\s\"']+)#is"			=> "",
                    "#(<script.*?>.*?(<\/script>)?)#is" 	=> "",
                    "#(<iframe.*?\/?>.*?(<\/iframe>)?)#is" 	=> "",
                    "#(<object.*?>.*?(<\/object>)?)#is"		=> "",
                    "#(<embed.*?\/?>.*?(<\/embed>)?)#is"	=> "",
                    "#( on[a-zA-Z]+=\"?'?[^\s\"']+'?\"?)#is"=> "",
                    "#(javascript:[^\s\"']+)#is"			=> ""
                
                ];

                $text = preg_replace(array_keys($tags), array_values($tags), $text);

                if(trim($text) !== null):

                    return true;
                else:

                    return false;
                endif;
            }
        }
        else
        {
            return false;
        }

    }

    public function create()
    {
        $id = uniqid();
        $file = fopen($this->path . $id . '.txt', 'w') or die("Unable to open file!");
        fwrite($file, json_encode($this->post, JSON_PRETTY_PRINT));
        fclose($file);
    }

    public function update()
    {

    }

    public function delete()
    {

    }

    public function read()
    {

    }
}