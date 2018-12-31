<?php

namespace Controller;

class Compare {

    function view() {
        $input_coins = (isset($_GET['coins']) && !empty($_GET['coins'])) ? explode(',', $_GET['coins']) : ['bitcoin'];

        return [
            'input_coins' => $input_coins,
        ];
    }

    function data() {
        $input_coins = (isset($_GET['coins']) && !empty($_GET['coins'])) ? explode(',', $_GET['coins']) : ['bitcoin'];
        $input_date = (isset($_GET['date']) && !empty($_GET['date'])) ? $_GET['date'] : false;
        
        $data = (new \Model\CoinHistory())->findHistory($input_coins,$input_date);

        $coins = [];

        foreach ($data as $d) {
            $coins[$d['id_externo']][] = $d;
        }

        $series = [];
        $price_date = [];


        foreach ($coins as $name => $val) {
            $row = [];
            $row['name'] = $name;
            $row['type'] = 'line';
            $row['showSymbol'] = false;
            $row['hoverAnimation'] = false;
//            $row['color'] = $val[0]['color'];
            $row['data'] = [];

            $row_v = $row;
            $row_p = $row;

            $price_base = $val[0]['price_usd'];

            foreach ($val as $v) {
                //marketcap
                $row_v['data'][] = [
                    $v['date_c'],
                    $v['marketcap_usd']
                ];

                //price data
                $price_date[$v['date_c']][$name] = decimalAmericano($v['price_usd'], 2, true);

                // porc price
                $porc = number_format(($v['price_usd'] - $price_base) * 100 / $price_base, 2, '.', '');
                $row_p['data'][] = [
                    $v['date_c'], $porc
                ];
            }

            $series_p[] = $row_p;
            $series_v[] = $row_v;
        }


        echo json_encode([
            'price' => [
                'legend' => array_keys($coins),
                'series' => $series_p
            ],
            'marketcap' => [
                'legend' => array_keys($coins),
                'series' => $series_v
            ],
            'price_date' => $price_date
        ]);
    }
    
    function change(){
        $input_coins = (isset($_GET['coins']) && !empty($_GET['coins'])) ? explode(',', $_GET['coins']) : ['bitcoin'];
        $data = (new \Model\CoinHistoryChange())->findChangePorcByCoin($input_coins);
        return ['data'=>$data];
    }

    function redirect() {
        header('Location: ' . siteUrl('/compare/coin'));
    }

}
