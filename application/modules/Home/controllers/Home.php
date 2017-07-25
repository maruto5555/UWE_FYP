<?php

/**
 * Created by PhpStorm.
 * User: wong
 * Date: 2/12/2017
 * Time: 8:05 PM
 */
class Home extends MX_Controller
{
//    function __construct()
//    {
//        parent::__construct();
//        $this->load->module('Template');
//    }
    public function index()
    {
        $this->load->module('Template');
        $this->load->model('TestData_model');
        $data['records'] = $this->TestData_model->listImg();
        $data['headerText']='Sample VR picture';
       $data['flash']=$this->session->flashdata('item');
        $data['content_view'] = 'Home/home1_v';

        $this->template->temp($data);
    }
    public function sampleVRPic(){
        $this->load->model('TestData_model');
       $query= $this->TestData_model->listImg();
       if($query!=false){
           $picList = array();
           foreach ($query->result() as $row) {
               array_push($picList, array(
                   'iid'=>$row->iid,
                   'source'=>$row->source,
                   'thumbnail'=>$row->thumbnail,
                   'name'=>$row->name
               ));
           }
           $myJSON=json_encode($picList);
           echo $myJSON;
       }else{
           $result = array('error' => 'no result');
           $myJSON = json_encode($result);
           echo $myJSON;
       }
    }
    public function videoList()
    {
        $this->load->model('TestData_model');
        $data['records'] = $this->TestData_model->listVideo();
        $data['content_view'] = 'Home/videoList_v';
        $data['headerText']='Sample VR video';
        $this->load->module('Template');
        $this->template->temp($data);
    }
    public function video($VID){
        $this->load->model('TestData_model');
        $data['records'] = $this->TestData_model->selectImg($VID);
        $data['comments'] = $this->TestData_model->getComment($VID);
        $data['content_view'] = 'Home/video_v';
        $this->load->module('Template');
        $this->template->temp($data);
    }
    public function map_direction(){
        $data['headerText']='Direction';
        $data['content_view'] = 'Home/mapDirection_v';
        $this->load->module('Template');
        $this->template->temp($data);
    }

    public function image($IID)
    {
        $this->load->model('TestData_model');
        $data['records'] = $this->TestData_model->selectImg($IID);
        $data['comments'] = $this->TestData_model->getComment($IID);
        $data['image_id']=$IID;
        $data['content_view'] = 'Home/image_v';
        $this->load->module('Template');
        $this->template->temp($data);
    }

    public function addComment()
    {
        //extract($_POST);
        if ($_POST['act'] == 'add-com'):
            $name = htmlentities($_POST['name']);
            $email = htmlentities($_POST['email']);
            $comment = htmlentities($_POST['comment']);


            // Get gravatar Image
            // https://fr.gravatar.com/site/implement/images/php/
            $default = "mm";
            $size = 35;
            $grav_url = "http://www.gravatar.com/avatar/" . md5(strtolower(trim($email))) . "?d=" . $default . "&s=" . $size;

            if (strlen($name) <= '1') {
                $name = 'Guest';
            }
            //insert the comment in the database
            $this->load->model('TestData_model');
            $query = $this->TestData_model->insertComment($name, $email, $comment, $_POST['id_post']);
            if ($query) {
                echo '<div class="cmt-cnt">';
                echo '<img src="' . $grav_url . '" alt="">';
                echo '<div class="thecom">';
                echo '<h5>' . $name . '</h5><span class="com-dt">' . date("d-m-Y H:i") . '</span>';
                echo '<br/>';
                echo '<p>' . $comment . '</p>';
                echo '</div></div>';
            }
        endif;
    }

}

?>