<?php

namespace Controller;

class Country {

    function listJson() {
        $data = (new \Model\Country())->findAll();        
        echo json_encode($data);
        
    }

}