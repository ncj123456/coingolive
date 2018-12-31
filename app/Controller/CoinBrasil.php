<?php

namespace Controller;

class CoinBrasil {

    function __construct() {

    }
    function view() {                
        header("Location: /pt-br/");
        die();
        return [1];
    }

    function data() {
        
        die();
        $moeda = isset($_GET['moeda']) ? $_GET['moeda'] : '';
        $name = isset($_GET['name']) ? $_GET['name'] : '';
        $order = isset($_GET['order']) ? $_GET['order'] : '';

        $data = (new \Model\ExchangePrice())->findLastPrice($moeda, $name, $order);
        return [
            'moeda' => $moeda,
            'data' => $data,
            'column' => $name,
            'order' => $order
        ];
    }

    function series() {
        
        die();
        
        $moeda = isset($_GET['moeda']) ? $_GET['moeda'] : '';
        $data = (new \Model\ExchangePrice())->findHistoryPrice($moeda);
        $exchange = [];
        $series_price = [];
        $series_volume = [];

        foreach ($data as $v) {
            $exchange[$v['exchange']][] = $v;
        }

        foreach ($exchange as $name => $val) {
            $row = [];
            $row['name'] = $name;
            $row['type'] = 'line';
            $row['showSymbol'] = false;
            $row['hoverAnimation'] = false;
            $row['animation'] = false;
            $row['color'] = $val[0]['color'];


            $row['data'] = [];

            $row_price = $row;
            $row_volume = $row;

            foreach ($val as $v) {
                //preco
                $row_price['data'][] = [
                    $v['created'], $v['last_price']
                ];

                $row_volume['data'][] = [
                    $v['created'], $v['volume']
                ];
            }
            $series_price[] = $row_price;
            $series_volume[] = $row_volume;
        }

        echo json_encode([
            'price' => [
                'legend' => array_keys($exchange),
                'series' => $series_price
            ],
            'volume' => [
                'legend' => array_keys($exchange),
                'series' => $series_volume
            ]
        ]);
    }

    function price() {
        
        die();
        
        $data = (new \Model\ExchangePrice())->findPriceCalc();
        $data24h = (new \Model\ExchangePrice())->findPriceCalcTime('24h');
//       $data7d =  (new \Model\ExchangePrice())->findPriceCalcTime('7d');

        return [
            'data' => $data,
            'data24h' => $data24h,
//            'data7d'=>$data7d,
        ];
    }

    function media() {
        
        die();
        
        $data = (new \Model\ExchangePrice())->findCalcPriceHistory();
        $moeda_base = [];
        $series = [];

        foreach ($data as $v) {
            $moeda_base[$v['moeda_base']][] = $v;
        }

        foreach ($moeda_base as $name => $val) {
            $row = [];
            $row['name'] = $name;
            $row['type'] = 'line';
            $row['showSymbol'] = false;
            $row['hoverAnimation'] = false;
            $row['animation'] = false;

            $row['data'] = [];

            foreach ($val as $v) {
                if ($v['moeda_base'] === 'BRL') {
                    $v['price_media'] = $v['price_media'] / 3.65;
                }
                //preco
                $row['data'][] = [
                    $v['minuto'], round($v['price_media'],2)
                ];
            }
            if ($name === 'BRL') {
                $row['color'] = "#9e57b0";
            } elseif ($name === 'USD') {
                $row['color'] = "#3C4858";
            }
            $series[] = $row;
        }
        $legend = array_keys($moeda_base);
        echo json_encode([
            'legend' => $legend,
            'series' => $series
        ]);
    }

    function volumeSum() {
        
        die();
        
        $data = (new \Model\ExchangePrice())->findVolumeSum('BRL');
        $series = [];

        $row = [];
        $row['name'] = 'Volume 24h BTC/BRL';
        $row['type'] = 'line';
        $row['showSymbol'] = false;
        $row['hoverAnimation'] = false;
        $row['animation'] = false;
        $row['color'] = "#9e57b0";

        $row['data'] = [];

        foreach ($data as $v) {
            //volume
            $row['data'][] = [
                $v['minuto'], round($v['volume_sum'], 2)
            ];
        }
        $series[] = $row;

        echo json_encode([
            'legend' => ['Volume 24h BTC/BRL'],
            'series' => $series,
            'last_volume' => round(end($data)['volume_sum'], 2)
        ]);
    }

    function resume() {
        
        die();
        
        $data = (new \Model\ExchangePrice())->findPriceCalc();
        $data24h = (new \Model\ExchangePrice())->findPriceCalcTime('24h');

        return [
            'data' => $data,
            'data24h' => $data24h
        ];
    }

}
