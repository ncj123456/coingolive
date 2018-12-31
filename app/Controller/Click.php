<?php

namespace Controller;

class Click {

    function save() {
        $id_link = isset($_GET['id']) ? $_GET['id'] : false;
        $ip = $_SERVER['REMOTE_ADDR'];
        
        if (is_numeric($id_link)) {

            $url = (new \Model\Link())->findLink($id_link);

            if ($url) {
                $click = new \Model\Click();
                $click->setIdLink($id_link);
                $click->setIp($ip);
                $click->insert();

                header("location: " . $url);
                return;
            }
        }
        header("location: /");
    }
    
    function listar(){
        $click = new \Model\Click();
        $rs = $click->findList();
        return [
            'rs'=>$rs
        ];
    }

}
