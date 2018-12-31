<?php

namespace Controller;

class Change {

    function view($exchange, $market) {
        $column = isset($_GET['order']) ? $_GET['order'] : 'diff_porc';
        $type = isset($_GET['type']) ? $_GET['type'] : 'desc';
        $where = [
            'exchange' => $exchange,
            'market' => strtoupper($market)
        ];
        $data = (new \Model\CoinChange())->findAllOrder($where, $column, $type);

        //get exchange
        $exchange_list = (new \Model\CoinChange())->findAllExchange();

        //get market exchange
        $market_list = (new \Model\CoinChange())->findAllMarket($exchange);

        return [
            'data' => $data,
            'column' => $column,
            'order' => $type,
            'exchange_list' => $exchange_list,
            'exchange_current' => $exchange,
            'market_list' => $market_list,
            'market_current' => $market,
        ];
    }

}
