<?php

namespace Controller;

class CronCoinRank {

    function save() {
        try {
            $i = 0;
            $db = \Base\DB::connect();
            $dates = (new \Model\CoinRank($db))->findDates();

            foreach ($dates as $d) {
                $rs = (new \Model\CoinRank($db))->findHistory2ByDate($d['dt']);

                foreach ($rs as $r) {

                    $sql = "
                    UPDATE coin_history_2
                        SET 
                            rank = " . $r['rank'] . "
                    WHERE id_externo='" . $r['id_externo'] . "'
                    AND date='" . $d['dt'] . "'";

                    $db->exec($sql);
                    $i++;
                }
            }
            echo json_encode(['success' => true, 'coins' => $i]);
        } catch (\Exception $e) {
            print_r($e->getMessage());
        }
    }

}
