<?php

namespace Base;

class Route {

    private $routes;
    private $server;
    private $request_uri;
    private $request_method;
    private $base;

    function __construct() {
        //atribui as variaveis do server
        $this->server = $_SERVER;

        //obtem a uri acessada
        $this->request_uri = $this->server['REQUEST_URI'];

        //obtem o verbo da requisicao
        $this->request_method = $this->server['REQUEST_METHOD'];


        //obtem apenas a url com barras
        $base = explode('?', $this->request_uri)[0];

        //redireciona para / as urls com finais sem  barra
        if (substr($base, -1) != '/') {

            header('Location:' . $base . '/');
            exit();
        }
        //remove a ultima barra para comparar
        $size = strlen($base);
        $base = substr($base, 0, $size - 1);

        //remove o parametro idioma da url
        $baseArray = explode('/', $base);
        $lang = isset($baseArray[1]) ? $baseArray[1] : null;

        unset($baseArray[1]);

        //obtem o idioma atual
        //obtem a lista de idiomas
        $i18n = \Base\I18n::getListLangs();

        //verifica se existe na lista de idiomas
        if (isset($i18n[$lang])) {
            //seta a linguagem atual
            \Base\I18n::setCurrentLang($lang);
        } else {


            //regra de rederecionamento para o brasil
            $ipCountry = isset($_SERVER["HTTP_CF_IPCOUNTRY"]) ? $_SERVER["HTTP_CF_IPCOUNTRY"] : false;
            if ($ipCountry === "BR") {
                header('Location: /pt-br' . $this->request_uri);
                 exit();
            }
            
            //=====
            $langDefault = 'en';

            if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
                $firstLangUser = explode(',', $_SERVER['HTTP_ACCEPT_LANGUAGE'])[0];
                $acceptLang = strtolower($firstLangUser);

                if (isset($i18n[$acceptLang])) {
                    $langDefault = $acceptLang;
                }
            }
            //se ao existir redireciona para o idioma padrao
            header('Location: /' . $langDefault . $this->request_uri);
            exit();
        }
        //gera a base para compara com as rotas
        $this->base = implode('/', $baseArray);
    }

    function post($url, $controller) {
        $this->routes[$url . '@POST'] = $controller;
    }

    function get($url, $controller) {
        $this->routes[$url . '@GET'] = $controller;
    }

    function all($url, $controller) {
        $this->routes[$url . '@ALL'] = $controller;
    }

    function ajax($url, $controller) {
        $this->routes[$url . '@AJAX'] = $controller;
    }

    function json($url, $controller) {
        $this->routes[$url . '@JSON'] = $controller;
    }

    function notFount() {
        http_response_code(404);
        echo "404";
    }

    function execute() {
        //obtem apenas todas as rotas definidas
        $routes = array_keys($this->routes);

        $request = explode('/', $this->base);

        foreach ($routes as $r) {

            $par = [];
            //separa o verbo da uri
            $base = explode('@', $r);
            //uri esperada
            $uri = $base[0];
            //verbo esperada
            $verbo = $base[1];

            //quebra a uri esperada nas barras
            $folders = explode('/', $uri);

            //recebe as uri estatica com os parametros dinamicos substituidos
            $staticUrl = [];

            //percorre a uri esperada para substituir os parametros dinamicos

            foreach ($folders as $seq => $f) {
                //verifica se e um parametro dinamico dentro da url definida
                $isPar = (substr($f, 0, 1) == ':') ? true : false;

                if ($isPar) {
                    $staticUrl[$seq] = isset($request[$seq]) ? $request[$seq] : null;
                    $par[] = $staticUrl[$seq];
                } else {
                    $staticUrl[$seq] = $f;
                }
            }

            $urlParser = implode('/', $staticUrl);

            //compara a quantidade de pasta das url esperada com a requisicao 
            if (count($folders) == count($request)) {

                //compara se a uri esperada e igual a da requisicao
                if ($urlParser == $this->base) {

                    $permitido = [
                        'ALL',
                        'AJAX',
                        'JSON'
                    ];

                    //compara se o verbo e permitido
                    if (in_array($verbo, $permitido) || $verbo == $this->request_method) {
                        $class = explode(':', $this->routes[$r]);
                        $controller = $class[0];
                        $action = $class[1];

                        //executa o controller e renderiza a view
                        return (new View($controller, $action, $par, $verbo, $this->base))->render();
                    } else {
                        return Log::erro('Verbo "' . $this->request_method . '" nao permitido');
                    }
                }
            }
        }

        $this->notFount();
    }

}
