<?php

class Admin_model extends CI_Model
{
    public function insertAttraction($cityId)
    {
        $insert_attraction_data = array(
            'taId' => uniqid(),
            'placeName' => $this->input->post('placeName'),
            'place_id' => $this->input->post('place_id'),
            'city_id' => $cityId,
            'lat' => $this->input->post('lat'),
            'lng' => $this->input->post('lng'),
            'image' => $this->input->post('image')
        );
        $insert = $this->db->insert('tourismAttractions', $insert_attraction_data);
        return $insert;
    }
public function countAttractionById($cityId){
    return $this->db->where('city_id',$cityId)->get('tourismAttractions')->num_rows();
}
public function getAttractionById($taId){
    return $this->db->where('taId',$taId)->get('tourismAttractions');
}
public function deleteAttraction($taId){
    return $this->db->delete('tourismAttractions', array('taId' => $taId));
}
public function editAttraction($taId){
    $update_data=array(
        'placeName'=>$this->input->post('placeName'),
        'place_id'=>$this->input->post('place_id'),
        'city_id'=>$this->input->post('cityId'),
        'lat'=>$this->input->post('lat'),
        'lng'=>$this->input->post('lng'),
        'image'=>$this->input->post('image')
    );
    $update=$this->db->where('taId',$taId)->update('tourismAttractions',$update_data);
    return $update;
}
public function attractionList($cityId,$per_page, $start_num){
    $this->db->where('city_id',$cityId);
    $this->db->limit($per_page, $start_num);
    $query = $this->db->get('tourismAttractions');
    if ($query->num_rows() > 0) {
        return $query;
    } else {
        return false;
    }
}
    public function countryList($per_page, $start_num)
    {
        $this->db->limit($per_page, $start_num);
        $query = $this->db->get('country');
        if ($query->num_rows() > 0) {
            return $query;
        } else {
            return false;
        }
    }
    public function cityList($countryId,$per_page, $start_num){
        $this->db->where('country_id',$countryId);
        $this->db->limit($per_page, $start_num);
        $query = $this->db->get('city');
        if ($query->num_rows() > 0) {
            return $query;
        } else {
            return false;
        }
    }

public function getCountryById($countryId){
   return $this->db->where('countryId',$countryId)->get('country');
}

public function editCountry($countryId){
    $update_data=array(
        'countryName'=>$this->input->post('editCountryName')
    );
    $update=$this->db->where('countryId',$countryId)->update('country',$update_data);
    return $update;
}
public function deleteCountry($countryId){
    return $this->db->delete('country', array('countryId' => $countryId));
}
    public function countCountry()
    {
        return $this->db->get('country')->num_rows();
    }
    public function countryCityById($countryId){
        return $this->db->where('country_id',$countryId)->get('city')->num_rows();
    }
    public function insertCountry()
    {
        $insert_country_data = array(
            'countryId' => uniqid(),
            'countryName' => $_POST['countryName']
        );
        $insert = $this->db->insert('country', $insert_country_data);
        return $insert;
    }
    public function insertCity($countryId){
        $insert_city_data=array(
            'cityId'=>uniqid(),
            'country_id'=>$countryId,
            'cityName'=>$this->input->post('cityName')
        );
        $insert=$this->db->insert('city',$insert_city_data);
        return $insert;
    }
    public function getCityById($cityId){
        return $this->db->where('cityId',$cityId)->get('city');
    }
    public function editCity($cityId){
        $update_data=array(
            'cityName'=>$this->input->post('cityName')
        );
        $update=$this->db->where('cityId',$cityId)->update('city',$update_data);
        return $update;
    }
    public function deleteCity($cityId){
        return $this->db->delete('city', array('cityId' => $cityId));
    }
    public function getCountryIdByCity($cityId){
        $this->db->select('country_id');
        $this->db->where('cityId',$cityId);
        $query=$this->db->get('city');
        if ($query->num_rows() > 0) {
            return $query;
        } else {
            return false;
        }
    }
}