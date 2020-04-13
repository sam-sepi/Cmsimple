<?php

namespace Cmsimple;

use \Firebase\JWT\JWT;

class Token
{
    protected $key = 'MyS3cre7K3y';
    protected $users = [
        'SamSepi' => [
            'email' => 'sam.sepi.84@gmail.com',
            'role' => 'admin'
        ]
    ];

    /**
     * Undocumented function
     *
     * @param string $user
     * @return string
     */
    public function getToken(string $user): string
    {
        if(array_key_exists($user, $this->users))
        {
            $payload = [

                'iat' => time(),
                'expire' => time() + 7200, //+2 hr.
                'data' => [
                    'user' => $user,
                    'role' => $this->users[$user]['role']
                ]
            ];
    
            $jwt = JWT::encode($payload, $this->key);
    
            return $jwt;
        }
        else
        {
            exit('User error');
        }
    }

    /**
     * Undocumented function
     *
     * @param string $jwt
     * @return boolean
     */
    public function verify(string $jwt = null): bool
    {
        if($jwt == null) return false;

        $decode = JWT::decode($jwt, $this->key, array('HS256'));

        if(time() >= $decode->expire) return false;

        if(!array_key_exists($decode->data->user, $this->users)) return false;

        return true;
    }
}