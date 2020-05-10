<?php

namespace Cmsimple;

class Validation
{
    /**
     * filterString
     *
     * @param string $string
     * @return boolean
     */
    public function filterString(string $string = null): bool
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
     * filterText
     *
     * @param string $text
     * @param boolean $html
     * @return boolean
     */
    public function filterText(string $text = null, $html = true): bool
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
     * filterID
     *
     * @param string $id
     * @return boolean
     */
    public function filterID(string $id = null): bool
    {
        if($id == null):
            return false; ///////UPDATE same name files

        elseif(strlen($id) > 20):
            return false;
        
        elseif(!ctype_alnum($id)):
            return false;

        else:
            return true;
        
        endif;
    }
}