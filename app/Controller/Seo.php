<?php

namespace Controller;

class Seo {

    function sitemap() {
        header("Content-type: text/xml; charset=utf-8");

        $data = (new \Model\Moeda())->findListAll();
        return ['data' => $data];
    }

}
