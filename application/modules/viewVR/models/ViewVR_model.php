<?php
/**
 * Created by PhpStorm.
 * User: wong
 * Date: 5/20/2017
 * Time: 1:16 AM
 */
class ViewVR_model extends CI_Model
{
public function viewVR(){
   $query= $this->db->get('image');
   if($query->num_rows()>0){
       return $query;
   }else{
       return false;
   }
}
public function deleteVR($iid){
    $this->db->where('iid',$iid);
   return $this->db->delete('image');
}
}