<?php

namespace Controller;

class CoinSuport {

    function view($coin) {
        return ['coin' => $coin];
    }

    function data($coin) {
        $data = (new \Model\CoinHistory())->findHistory2($coin);
        $suport = (new \Model\CoinHistory())->findSuport($coin);
               
        
//        $legend = [];

//
//        $series = [];
//            $row = [];
//            $row['name'] = $legend;
//            $row['type'] = 'line';
//            $row['showSymbol'] = false;
//            $row['hoverAnimation'] = false;
//            $row['animation'] = false;
//            $row['markLine'] = [
//                'silent' => true,
//                'symbol' => 'none',
//                'data' => [
//                    [
//                        'yAxis' => 1
//                    ]
//                ],
//            ];

//              $row['color'] = "#9e57b0";

//        print_r($data);die;
        
            $row['data'] = [];
            foreach ($data as $v) {
                //preco
                $row['data'][] = [
                    $v['date'], $v['open'],$v['close'],$v['low'],$v['high']
                ];
        }
        
        $row['suport'] = [];
        foreach($suport as $s){
                $row['suport'][]=[
                    'yAxis'=>(float) $s['avg_close']
                ];
        }        

        echo json_encode($row);
    }

}
