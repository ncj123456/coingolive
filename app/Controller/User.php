<?php

namespace Controller;

class User extends \Base\Controller {

    protected $hash = '@##The!_Revolution$_Will%_Not&_Be*_Centralized##@';

//    function register() {
//        return [1];
//    }
//
//    function login() {
//         return [1];
//    }

    function auth() {
        $d = $this->getPost();
        $password = $this->generatePassword($d['password']);

        $auth = (new \Model\User())->auth($d['email'], $password);

        if (!$auth) {
            echo json_encode(['success' => false, 'msg' => _e('Usuário ou senha inválido')]);
            return false;
        }

        //seta o usuario logado
        \Base\Auth::setUser($auth['id']);

        echo json_encode(['success' => true, 'msg' => _e('Bem Vindo') . " " . $auth['name']]);
    }

    function register_ajax() {
        return [1];
    }

    function save() {
        $d = $this->getPost();

        $password = $this->generatePassword($d['password']);
        $ip = $this->getIp();

        $user = new \Model\User();
        $user->setIdCountry($d['country']);
        $user->setName($d['name']);
        $user->setEmail($d['email']);
        $user->setPassword($password);
        $user->setStatus(2); //pendente
        $user->setIp($ip);
        $user->insert();

        if ($user->getLastInsertId() > 0) {
            echo json_encode(['success' => true, 'msg' => _e('Usuário cadastrado com sucesso!')]);
        } else {
            echo json_encode(['success' => false, 'msg' => 'Ocorreu um erro a']);
        }
    }

    function logout() {
        \Base\Auth::logout();
        header("Location: " . siteUrl('/'));
    }

    function generatePassword($pass) {
        return md5($this->hash . $pass);
    }

    //login com o civic
    function civic() {
        if (isset($_POST['token'])) {
            $data = file_get_contents("http://127.0.0.1:3002/" . $_POST['token']);
            $rs = json_decode($data,1);
            
            if ($rs['success']) {
                //seta o usuario logado
                \Base\Auth::setUser($rs['id_user']);
                $success = true;
            } else {
                $success = false;
            }
            echo json_encode(['success' => $success]);
        }
    }

}
