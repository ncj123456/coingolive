<?php

namespace Model;

class User extends \Base\DAO {

    protected $_table = "user";
    protected $id;
    protected $id_country;
    protected $name;
    protected $email;
    protected $password;
    protected $status;
    protected $token;
    protected $ip;

    function setId($id) {
        $this->id = $id;
    }

    function setIdCountry($id_country) {
        $this->id_country = $id_country;
    }

    function setName($name) {
        $this->name = $name;
    }

    function setEmail($email) {
        $this->email = $email;
    }

    function setPassword($password) {
        $this->password = $password;
    }

    function setStatus($status) {
        $this->status = $status;
    }

    function setToken($token) {
        $this->token = $token;
    }

    function setIp($ip) {
        $this->ip = $ip;
    }

    function auth($email, $password) {
        $sql = "SELECT 
                            id,
                            name 
                        FROM user 
                        WHERE email=:email
                        AND password=:password";
        $par = [
            'email' => $email,
            'password' => $password
        ];
        $rs = $this->query($sql, $par);
        if (count($rs) === 1) {
            return $rs[0];
        }
        return false;
    }

}
