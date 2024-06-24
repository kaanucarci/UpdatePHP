<?php
 class ClientDal{
     public function getAll()
     {
         $data = json_decode(file_get_contents(PATH.'\app\model\fakedatabase.json'), true);
         return $data;
     }

 }
?>