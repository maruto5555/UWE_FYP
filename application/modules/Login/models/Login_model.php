<?php
class Login_model extends CI_Model {
public function signUp(){
    $new_member_insert_data=array(
        'uid'=>uniqid(),
        'username'=>$this->input->post('username'),
        'email'=>$this->input->post('email'),
        'password'=>md5($this->input->post('password')),
        'firstname'=>$this->input->post('firstname'),
        'lastname'=>$this->input->post('lastname'),
        'gender'=>$this->input->post('gender'),
    );
    $insert=$this->db->insert('user',$new_member_insert_data);
    return $insert;
}
public function login(){
    $this->db->where('email',$this->input->post('email'));
    $this->db->where('password',md5($this->input->post('password')));
    $query=$this->db->get('user');
    if($query->num_rows()==1){
        return $query;
    }else{
        return false;
    }
}
public function profile(){
    $query=$this->db->where('uid',$_SESSION['uid'])->get('user');
    if($query->num_rows()>0){
        return $query;
    }else{
        return false;
    }
}
public function updateProfile(){
$data_profile_update=array(
    'username'=>$this->input->post('username'),
    'email'=>$this->input->post('email'),
    'firstname'=>$this->input->post('firstname'),
    'lastname'=>$this->input->post('lastname'),
    'gender'=>$this->input->post('gender')
);
    $update=$this->db->where('uid',$_SESSION['uid'])->update('user',$data_profile_update);
return $update;
}
public function updatePassword(){
    $newPassword=array(
        'password'=>md5($this->input->post('password'))
    );
    $update=$this->db->where('uid',$_SESSION['uid'])->update('user',$newPassword);
    return $update;
}
public function updateIcon($picName, $picPath){
    $icon_data=array(
        'uicon'=>$picPath,
        'uiconFilename'=>$picName
    );
    $update=$this->db->where('uid',$_SESSION['uid'])->update('user',$icon_data);
    return $update;
}
}