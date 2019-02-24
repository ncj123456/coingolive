<?php 

namespace Model ;

 class VideoChannel extends \Base\DAO {

   protected $_table = "video_channel"; 
   protected $id; 
   protected $title; 
   protected $link; 
   protected $published; 
   protected $created; 


     function setId($id){ 
           $this->id=$id;
   }

     function setTitle($title){ 
           $this->title=$title;
   }

     function setLink($link){ 
           $this->link=$link;
   }

     function setPublished($published){ 
           $this->published=$published;
   }

     function setCreated($created){ 
           $this->created=$created;
   }

 }