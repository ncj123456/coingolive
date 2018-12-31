<?php 

namespace Model ;

 class CoinIndex extends \Base\DAO {

   protected $_table = "coin_index"; 
   protected $id; 
   protected $id_origin; 
   protected $rank; 
   protected $symbol; 
   protected $created; 


     function setId($id){ 
           $this->id=$id;
   }

     function setIdOrigin($id_origin){ 
           $this->id_origin=$id_origin;
   }

     function setRank($rank){ 
           $this->rank=$rank;
   }

     function setSymbol($symbol){ 
           $this->symbol=$symbol;
   }

     function setCreated($created){ 
           $this->created=$created;
   }

       function findByCoin($symbol) {
           $par=[
               'symbol'=>$symbol
           ];
           $sql = "
                SELECT 
                    v.id_origin,
                    v.rank,
                    v.symbol,
                    s.name as name_site,
                    DATE_FORMAT(v.created,'%Y-%m-%d %H:%i') as created
               FROM coin_index v
               INNER JOIN coin_index_site s ON v.id_origin=s.id_site
               WHERE v.symbol=:symbol
               ORDER BY v.id DESC                    
            ";
           return $this->query($sql,$par);
       }
 }