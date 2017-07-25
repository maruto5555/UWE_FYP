<?php
class TravelShare_model extends CI_Model {
    public function createShare(){
        $new_share_data_input=array(
            'tid'=>uniqid(),
'title'=>$this->input->post('title'),
            'content'=>$this->input->post('text_content'),
            'uid'=>$_SESSION['uid']
        );
        $insert=$this->db->insert('travelShare',$new_share_data_input);
        return $insert;
    }
    public function countShare(){
        return $this->db->get('travelShare')->num_rows();
    }
    public function countShareSearch($keyword){
        $this->db->like('title',$keyword);
        $this->db->or_like('content',$keyword);
       $query=$this->db->get('travelShare')->num_rows();
        return $query;
    }
    public function countMyShare(){
        return $this->db->where('uid',$_SESSION['uid'])->get('travelShare')->num_rows();
    }
    public function getShare($per_page,$start_num){
        $this->db->select('*');
        $this->db->from('travelShare');
        $this->db->join('user', 'travelShare.uid = user.uid');
        $this->db->order_by('datetime','DESC');
        $this->db->limit($per_page,$start_num);
       $query= $this->db->get();
        if($query->num_rows()>0){
            return $query;
        }else{
            return false;
        }
    }
public function getShareContent($tid){
    $this->db->select('*');
    $this->db->from('travelShare');
    $this->db->join('user', 'travelShare.uid = user.uid');
    $this->db->where('tid',$tid);
    $query= $this->db->get();
    if($query->num_rows()>0){
        return $query;
    }else{
        return false;
    }
}
public function editShare(){
    $time=date("Y-m-d H:i:s");//get current time
    $new_edit_data=array(
        'title'=>$this->input->post('title'),
        'content'=>$this->input->post('text_content'),
        'editedTime'=>$time
    );
    $update=$this->db->where('tid',$this->input->post('tid'))->update('travelShare',$new_edit_data);
    return $update;
}
public function deleteShare($tid){
    $query=$this->db->where('tid',$tid)->delete('travelShare');
    $this->db->where('id_post',$tid)->delete('comments');
    return $query;
}
public function shareSearch($keyword,$per_page,$start_num){
    $this->db->select('*');
    $this->db->from('travelShare');
    $this->db->join('user', 'travelShare.uid = user.uid');
    $this->db->order_by('datetime');
    $this->db->limit($per_page,$start_num);
    $this->db->like('title',$keyword);
    $this->db->or_like('content',$keyword);
    $query=$this->db->get();
    if($query->num_rows()>0){
        return $query;
    }else{
        return false;
    }
}
public function getMyShare($per_page,$start_num){
    $this->db->select('*');
    $this->db->from('travelShare');
    $this->db->join('user', 'travelShare.uid = user.uid');
    $this->db->where('travelShare.uid',$_SESSION['uid']);
    $this->db->order_by('datetime');
    $this->db->limit($per_page,$start_num);
    $query= $this->db->get();
    if($query->num_rows()>0){
        return $query;
    }else{
        return false;
    }
}
}