<?php

namespace Controller;

class CoinHistoryRank {

    function view() {
        return [
            1
        ];
    }

    function data() {
        $name = isset($_GET['name']) ? $_GET['name'] : '';
        $order = isset($_GET['order']) ? $_GET['order'] : '';
        $busca = isset($_GET['busca']) ? $_GET['busca'] : '';
        $page = (int) (isset($_GET['page']) ? $_GET['page'] : 0);
        $limit = 100;
        $min_rank = (int) ((isset($_GET['min_rank']) && !empty($_GET['min_rank'])) ? $_GET['min_rank'] : 1);
        $max_rank = (int) (isset($_GET['max_rank']) ? $_GET['max_rank'] : 0);


        if (empty($max_rank)) {
            $max_rank = (new \Model\CoinHistoryChange())->findMaxRank();
        }

        $id_user = \Base\Auth::getIdUser();
        $favorite = (isset($_GET['favorite']) && $_GET['favorite'] === "true") ? true : false;

        $data = (new \Model\CoinHistoryRank())->findPorcChange($id_user, $favorite, $limit, $page, $name, $order, $busca, $min_rank, $max_rank);
        return [
            'data' => $data,
            'limit' => $limit,
            'column' => $name,
            'order' => $order,
            'page' => $page,
            'max_rank' => $max_rank,
            'min_rank' => $min_rank
        ];
    }

    function generate() {

        try {
            $i = 0;
            $db = \Base\DB::connect();
            $db->beginTransaction();
            //deleta todos
            $history = new \Model\CoinHistoryRank($db);
            $history->deleteAll();

            $change = (new \Model\CoinHistoryRank($db))->findRankChange();

            foreach ($change as $d) {


                $history = new \Model\CoinHistoryRank($db);
                $history->setIdExterno($d['id_externo']);
                $history->setHighRank($d['high_rank']);
                $history->setRank7d($d['7d']);
                $history->setRank1m($d['1m']);
                $history->setRank3m($d['3m']);
                $history->setRank6m($d['6m']);
                $history->setRank1y($d['1y']);
                $history->insert();

                $i++;
//            echo $d['id_externo'] . "\n";            
            }
            $db->commit();

            echo json_encode(['success' => true, 'coins' => $i]);
        } catch (\Exception $e) {
            print_r($e->getMessage());
        }
    }

}
