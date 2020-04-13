<?php

namespace Cmsimple;

class Post
{
    protected $post = [];
    protected $path = '../content/';

    /**
     * Undocumented function
     *
     * @param array $post
     */
    public function __construct(array $post)
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
        
        if($this->filterId($post['id']) == true)
        {
            $this->post['id'] = $post['id'];
        }
        else
        {
            $this->post['id'] = uniqid();
        }

        $this->post['date'] = date("Y-m-d");

    }

    /**
     * Undocumented function
     *
     * @param string $string
     * @return boolean
     */
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

    /**
     * Undocumented function
     *
     * @param string $text
     * @param boolean $html
     * @return boolean
     */
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

    /**
     * Undocumented function
     *
     * @param string $id
     * @return void
     */
    protected function filterId(string $id = null)
    {
        if($id == null):
            return false;

        elseif(strlen($id) > 20):
            return false;
        
        elseif(!ctype_alnum($id)):
            return false;

        else:
            return true;
        
        endif;
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function create()
    {
        $file = @fopen($this->path . $this->post['id'] . '.txt', 'w');
        @fwrite($file, json_encode($this->post, JSON_PRETTY_PRINT));
        @fclose($file);
    }
}