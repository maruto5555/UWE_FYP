<?php
class TestData_model extends CI_Model {
    public function selectImg($IID){
        $query=$this->db->where('iid',$IID)->get('image');
        if($query->num_rows()>0){
            return $query;
        }else{
            return false;
        }
    }
    public function listVideo(){
        $this->db->where('category','1');
        $query=$this->db->limit(8)->get('image');
        if($query->num_rows()>0){
            return $query;
        }else{
            return false;
        }
    }
    public function listImg(){
        $this->db->where('category','0');
        $query=$this->db->get('image');
        if($query->num_rows()>0){
            return $query;
        }else{
            return false;
        }
    }
    public function getComment($IID){
        $query=$this->db->where('id_post',$IID)->get('comments');
        if($query->num_rows()>0){
            return $query;
        }else{
            return false;
        }
    }
    public function insertComment($name,$email,$comment,$id_post){
$new_comment_insert_data=array(
    'id'=>uniqid(),
    'name'=>$name,
    'email'=>$email,
    'comment'=>$comment,
    'id_post'=>$id_post
);
       $insert= $this->db->insert('comments',$new_comment_insert_data);
        return $insert;
    }
}
?>