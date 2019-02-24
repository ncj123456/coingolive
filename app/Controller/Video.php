<?php

namespace Controller;

class Video {

    function view() {
        $rs = (new \Model\Video())->findList();
//        print_r($rs);
        return [
            'rs'=>$rs
        ];
    }
}
