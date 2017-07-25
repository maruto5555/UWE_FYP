<?php

class TravelPlanning_model extends CI_Model
{
    public function getAttractionList($travelId)
    {
        $this->db->select('taId,placeName,image,travel.city_id,cityName');
        $this->db->from('travel');
        $this->db->join('tourismAttractions', 'travel.city_id=tourismAttractions.city_id');
        $this->db->join('city', 'travel.city_id=city.cityId');
        $this->db->where('travelId', $travelId);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query;
        } else {
            return false;
        }
    }

    public function getCityList()
    {
        $query = $this->db->get('city');
        if ($query->num_rows() > 0) {
            return $query;
        } else {
            return false;
        }
    }

    public function insertTravel()
    {
        $travelId = uniqid();
        $new_insert_data = array(
            'travelId' => $travelId,
            'travelName' => $this->input->post('title'),
            'startDate' => $this->input->post('travelDate'),
            'city_id' => $this->input->post('city_id'),
            'user_id' => $_SESSION['uid'],
            'dayNum' => $this->input->post('dayNum')
        );
        $insert = $this->db->insert('travel', $new_insert_data);
        $insert_data = array();
        for ($i = 0; $i < $this->input->post('dayNum'); $i++) {
            array_push($insert_data, array(
                'dayId' => uniqid(),
                'travel_id' => $travelId,
                'dayOrder' => $i + 1
            ));
        }
        $insert1 = $this->db->insert_batch('travel_day', $insert_data);
        if ($insert && $insert1) {
            return true;
        } else {
            return false;
        }

    }

    public function showDayNum($travelId)
    {
        $this->db->select('dayId,dayOrder');
        $this->db->from('travel_day');
        $this->db->where('travel_id', $travelId);
        $this->db->order_by('dayOrder', 'ASC');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query;
        } else {
            return false;
        }
    }

    public function countMyPlan($uid)
    {
        return $this->db->where('user_id', $uid)->get('travel')->num_rows();
    }

    public function getMyPlan($uid, $per_page, $start_num)
    {
        $this->db->select('travelId,travelName,startDate');
        $this->db->from('travel');
        $this->db->where('user_id', $uid);
        $this->db->limit($per_page, $start_num);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query;
        } else {
            return false;
        }
    }
public function insertDayItem($dayId){
        $itemId=uniqid();
        $insert_data=array(
            'itemId'=>$itemId,
            'day_id'=>$dayId,
            'attraction_id'=>$this->input->post('attraction_id'),
            'travel_id' => $this->input->post('travel_id')
        );
    $this->db->insert('travelDay_item', $insert_data);
    $this->db->set('likeCount', 'likeCount+1',FALSE);
    $this->db->where('taId', $this->input->post('attraction_id'));
    $this->db->update('tourismAttractions'); // gives UPDATE mytable SET field = field+1 WHERE id = 2
        return $itemId;
}
public function getAttractionById($attractionId){
    return $this->db->where('taId',$attractionId)->get('tourismAttractions');
}
    public function updateDayItemTime($itemId)
    {
        $update_data = array(
            'time' => $this->input->post('time')
        );
        $this->db->where('itemId', $itemId);
        $update = $this->db->update('travelDay_item', $update_data);
        return $update;
    }
    public function insertDayNum(){
        $dayId=uniqid();
        $insert_day=array(
            'dayId'=>$dayId,
            'travel_id'=>$this->input->post('travelId'),
            'dayOrder'=>$this->input->post('dayOrder')
        );
        $this->db->insert('travel_day',$insert_day);
        return $dayId;
    }
    public function deleteDayNum(){
        $delete=$this->db->delete('travel_day',array('dayId'=>$this->input->post('dayId')));
        $delete2=$this->db->delete('travelDay_item',array('day_id'=>$this->input->post('dayId')));
       $this->db->set('dayNum','dayNum-1',FALSE);
       $this->db->where('travelId',$this->input->post('travelId'));
       $update= $this->db->update('travel');
       $this->db->set('dayOrder','dayOrder-1',FALSE);
       $this->db->where('dayOrder >',$this->input->post('deleteDayOrder'));
       $this->db->where('travel_id',$this->input->post('travelId'));
       $update2=$this->db->update('travel_day');
        if($delete2&&$delete&&$update&&$update2){
            return true;
        }else{
            return false;
        }
    }

    public function updateNote($dayId)
    {
        $update_data = array(
            'note' => $this->input->post('note')
        );
        $this->db->where('dayId', $dayId);
        $update = $this->db->update('travel_day', $update_data);
        return $update;
    }

    public function getAllSelectedItem($travelId)
    {
        $this->db->select('*');
        $this->db->from('travel');
        $this->db->join('travel_day', 'travelId=travel_id');
        $this->db->join('city', 'city_id=cityId');
        $this->db->where('travelId', $travelId);
        $this->db->order_by('dayOrder','ASC');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query;
        } else {
            return false;
        }
    }

    public function getAllSelectedAttraction($dayId)
    {
        $this->db->select('*');
        $this->db->from('travelDay_item');
        $this->db->join('tourismAttractions', 'attraction_id=taId');
        $this->db->join('travel_day','day_id=dayId');
        $this->db->where('day_id', $dayId);
        $this->db->order_by('time', 'ASC');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query;
        } else {
            return false;
        }
    }


    public function deleteDayItem($itemId)
    {
        $query = $this->db->where('itemId', $itemId)->delete('travelDay_item');
        $this->db->set('likeCount','likeCount-1',FALSE);
        $this->db->where('taId',$this->input->post('taId'));
        $this->db->update('tourismAttractions');
        return $query;
    }

    public function deleteTravel($travelId)
    {
        $this->db->where('travel_id', $travelId)->delete('travelDay_item');
        $this->db->where('travel_id', $travelId)->delete('travel_day');
        $this->db->where('travelId', $travelId)->delete('travel');
    }
}