<?php

namespace Base;

class Auth {

    static protected $id_user;

    static function getIdUser() {
        if (!self::$id_user && isset($_COOKIE['auth'])) {

            $token = $_COOKIE['auth'];
            $access = (new \Model\UserAccess())->findAccess($token);

            if (count($access) === 1) {
                self::$id_user = $access[0]['id_user'];
                return self::$id_user;
            }
        }

        return self::$id_user;
    }
    
   static  function getUser(){
        $id = self::getIdUser();
        $user = ( new \Model\User())->findId($id);
        return $user;
    }

    static function setUser($id_user) {
        //disabilita os outros tokens ativos
//        (new \Model\UserAccess())->disableToken($id_user);

        $token = md5($id_user . microtime() . rand());
        $ip = isset($_SERVER["HTTP_CF_CONNECTING_IP"]) ? $_SERVER["HTTP_CF_CONNECTING_IP"] : $_SERVER['REMOTE_ADDR'];

        $access = new \Model\UserAccess();
        $access->setIdUser($id_user);
        $access->setToken($token);
        $access->setIp($ip);
        $access->setStatus(1); //ativo
        $access->insert();

        setcookie('auth', $token, strtotime('+30 days'), '/');
    }

    static function logout() {
        if (isset($_COOKIE['auth'])) {

            $par = [
                'token' => $_COOKIE['auth']
            ];
            
            $access = new \Model\UserAccess();
            $access->setStatus(0);
            $access->update("token=:token", $par);

            //remove o cookie
            unset($_COOKIE['auth']);
            setcookie('auth', null, -1, '/');
        }
    }

}
