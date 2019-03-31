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
   
   
   function findLast7Days($codigo){
       $sql = "	SELECT
               ch1.price,
               ch1.vol24h 
           FROM coin_history ch1
			INNER JOIN (
				SELECT 
				min(id) as id,
				date_format(created,'%Y-%m-%d %H') as dt 
				FROM coin_history
                WHERE codigo=:codigo
				AND created >=  DATE(NOW()) - INTERVAL 7 DAY
				GROUP BY dt
			) ch2 ON ch2.id=ch1.id
        WHERE ch1.created >= DATE(NOW()) - INTERVAL 7 DAY
        ORDER BY ch2.id ASC";
       
       $par = ['codigo'=>$codigo];
       return $this->query($sql,$par);
   }


 }