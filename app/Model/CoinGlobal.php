<?php 

namespace Model ;

 class CoinGlobal extends \Base\DAO {

   protected $_table = "coin_global"; 
   protected $id; 
   protected $data_json; 
   
     function setId($id){ 
           $this->id=$id;
    }
   
    function setDataJson($data_json){ 
           $this->data_json=$data_json;
   }

   function findData(){
        $sql = "SELECT data_json FROM coin_global";
        $rs = $this->query($sql)[0]['data_json'];
        
        return json_decode($rs,1);
   }

 }