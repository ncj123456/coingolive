<?php 

namespace Model ;

 class Video extends \Base\DAO {

   protected $_table = "video"; 
   public $id_video; 
   public $id_channel; 
   public $title; 
   public $thumbnail; 
   public $rating; 
   public $likes; 
   public $views; 
   public $link; 
   public $description; 
   public $published; 
   public $created; 

   
   function findList(){
       $sql = " SELECT  v.title,
                                    v.published,
                                    v.views,
                                    v.likes,
                                    v.rating,
                                    v.thumbnail,
                                    v.link,
                                    c.title as channel
                     FROM video v
                     INNER JOIN video_channel c ON c.id=v.id_channel
                    ORDER BY v.published DESC";
       
       return $this->query($sql);
   }
 }