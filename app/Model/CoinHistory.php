<?php 

namespace Model ;

 class CoinHistory extends \Base\DAO {

   protected $_table = "coin_history"; 
   protected $codigo; 
   protected $price; 
   protected $vol24h; 
   protected $available_supply; 
   
     function setCodigo($codigo){ 
           $this->codigo=$codigo;
   }

     function setPrice($price){ 
           $this->price=$price;
   }

     function setVol24h($vol24h){ 
           $this->vol24h=$vol24h;
   }

     function setAvailableSupply($available_supply){ 
           $this->available_supply=$available_supply;
   }


 }