<?php
class Template extends MX_Controller {

    public function temp($data=null){
        $this->load->view('temp_v',$data);
    }
    public function adminTemp($data=null){
        $this->load->view('adminTemp_v',$data);
    }
    public function drawBreadCrumbs($data){
$this->load->view('breadCrumb_v',$data);
    }
}
?>