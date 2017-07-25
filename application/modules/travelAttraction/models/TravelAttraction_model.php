<?php
class TravelAttraction_model extends CI_Model {
    public function getAttraction($taId){
        $this->db->where('taId',$taId);
        $query=$this->db->get('tourismAttractions');
        if($query->num_rows()>0){
            return $query;
        }else{
            return false;
        }
    }
    public function searchAttraction($keyword){
        $this->db->select('taId,placeName,image');
        $this->db->like('placeName',$keyword);
       $query= $this->db->get('tourismAttractions');
        if($query->num_rows()>0){
            return $query;
        }else{
            return false;
        }
    }
    public function getCountry(){
       $query= $this->db->get('country');
        if($query->num_rows()>0){
            return $query;
        }else{
            return false;
        }
    }
    public function getCity($countryId){
        $query= $this->db->where('country_id',$countryId)->get('city');
        if($query->num_rows()>0){
            return $query;
        }else{
            return false;
        }
    }
    public function getAttractionVR($taId){
        $query=$this->db->where('attraction_id',$taId)->where('category','0')->get('image');
        if($query->num_rows()>0){
            return $query;
        }else{
            return false;
        }
    }
    public function getAllAttraction(){
        $this->db->select('taId,placeName,image');
        $this->db->order_by('likeCount','DESC');
       $query= $this->db->get('tourismAttractions');
        if($query->num_rows()>0){
            return $query;
        }else{
            return false;
        }
    }
    public function getAttractionList($cityId){
        $this->db->select('taId,placeName,image');
        $this->db->from('tourismAttractions');
        $this->db->where('city_id',$cityId);
        $query= $this->db->get();
        if($query->num_rows()>0){
            return $query;
        }else{
            return false;
        }
    }
}