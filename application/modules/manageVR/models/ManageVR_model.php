<?php

class ManageVR_model extends CI_Model
{
public function insertVRResource($taId,$picPath,$thumbnailPath,$rawName){
    $insert_data=array(
        'iid'=>uniqid(),
        'source'=>$picPath,
        'thumbnail'=>$thumbnailPath,
        'name'=>$rawName,
        'attraction_id'=>$taId,
        'category'=>$this->input->post('category')
    );
   $this->db->insert('image',$insert_data);
}
    public function countAttraction(){
        return $this->db->get('tourismAttractions')->num_rows();
    }
    public function attractionList($per_page, $start_num){
        $this->db->limit($per_page, $start_num);
        $query = $this->db->get('tourismAttractions');
        if ($query->num_rows() > 0) {
            return $query;
        } else {
            return false;
        }
    }
}