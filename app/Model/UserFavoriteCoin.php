<?php

namespace Model;

class UserFavoriteCoin extends \Base\DAO {

    protected $_table = "user_favorite_coin";
    protected $id_user;
    protected $id_coin;

    function setIdUser($id_user) {
        $this->id_user = $id_user;
    }

    function setIdCoin($id_coin) {
        $this->id_coin = $id_coin;
    }

    function findExists($id_user, $id_coin) {
        $sql = "SELECT count(*) as qtde FROM user_favorite_coin
                       WHERE id_user=:id_user AND id_coin=:id_coin";

        $par = [
            'id_user' => $id_user,
            'id_coin' => $id_coin
        ];

        $rs = $this->query($sql,$par);
        if ($rs[0]['qtde'] > 0) {
            return true;
        }
        return false;
    }

}
