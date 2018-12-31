<?php

namespace Controller;

class UserFavorite extends \Base\Controller {

    function favoriteCoin() {
        $id_user = \Base\Auth::getIdUser();
        if ($id_user) {
            $id_coin = $this->getPost()['id_coin'];

            //verifica se existe
            $exists = (new \Model\UserFavoriteCoin())->findExists($id_user, $id_coin);

            //remove o favorito se ja existir
            if ($exists) {
                $par = [
                    'id_user' => $id_user,
                    'id_coin' => $id_coin
                ];
                $favorite = new \Model\UserFavoriteCoin();
                $favorite->delete("id_user=:id_user AND id_coin=:id_coin", $par);
                echo $this->jsonSuccess('delete');
                return;
            }

            //insere caso nao exista
            $favorite = new \Model\UserFavoriteCoin();
            $favorite->setIdUser($id_user);
            $favorite->setIdCoin($id_coin);
            $favorite->insert();
            if ($favorite->getLastInsertId()) {
                echo $this->jsonSuccess('insert');
            }
        } else {
            echo $this->jsonError('not');
        }
    }

}
