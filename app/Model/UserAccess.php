<?php

namespace Model;

class UserAccess extends \Base\DAO {

    protected $_table = "user_access";
    protected $id_user;
    protected $token;
    protected $status;
    protected $ip;

    function setIdUser($id_user) {
        $this->id_user = $id_user;
    }

    function setToken($token) {
        $this->token = $token;
    }

    function setStatus($status) {
        $this->status = $status;
    }

    function setIp($ip) {
        $this->ip = $ip;
    }
    
    function findAccess($token){
        $sql ="SELECT
                             id_user  
                        FROM user_access
                        WHERE token=:token
                        AND status=1";
        $par=[
            'token'=>$token
        ];
        return $this->query($sql, $par);
    }
    
//    function disableToken($id_user){
//        $sql = "UPDATE user_access SET status=0 WHERE id_user=:id_user ";
//        $par = [
//                'id_user'=>$id_user
//        ];
//        return $this->query($sql,$par);
//    }

}
