<?php

class TravelShare extends MX_Controller
{
    public function index(){
        $this->load->model('TravelShare_model');
        $this->load->library('pagination');
        $config['total_rows'] = $this->TravelShare_model->countShare();
        $config['per_page'] = 6;
        $config['uri_segment'] = 2;
        $config['num_links'] = 2;
        $config['base_url'] = base_url("index.php/TravelShare/");
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';//use bootstrip interface
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['use_page_numbers'] = TRUE;
        $page = $this->uri->segment(2, 1);
        $start_num = ($page - 1) * $config['per_page'];
        $this->pagination->initialize($config);
        $data['link'] = $this->pagination->create_links();
        $data['records'] = $this->TravelShare_model->getShare($config['per_page'],$start_num);
        $data['content_view'] = 'TravelShare/ShareHome_v';
        $this->load->module('Template');
        $this->template->temp($data);
    }
    public function createShare(){
        $submit=$this->input->post('submit');
        if($submit=='Submit'){
            $this->load->library('form_validation');
            $this->form_validation->set_rules('title', 'Title', 'required|max_length[100]|min_length[3]');
            $this->form_validation->set_rules('text_content', 'Content', 'required|max_length[1000]|min_length[5]');
            if($this->form_validation->run()==TRUE){
                $this->load->model('TravelShare_model');
                $query=$this->TravelShare_model->createShare();
                if($query){
                    $flash_msg='Submit Success!';
                    $value='<div class="alert alert-success" role="alert">'.$flash_msg.'</div>';
                    $this->session->set_flashdata('item',$value);
                }else{
                    $flash_msg='Submit Fail!';
                    $value='<div class="alert alert-danger" role="alert">'.$flash_msg.'</div>';
                    $this->session->set_flashdata('item',$value);
                }
            }
        }
        $data['flash']=$this->session->flashdata('item');
        $data['headerText']='Create Share';
        $data['content_view'] = 'TravelShare/createShare_v';
        $this->load->module('Template');
        $this->template->temp($data);
    }
    public function travelShareContent($tid){
        $this->load->module('Home');
        $data['content_view'] = 'TravelShare/Content_v';
        $this->load->model('TravelShare_model');
        $this->load->model('TestData_model');
        $data['records']=$this->TravelShare_model->getShareContent($tid);
        $data['comments'] = $this->TestData_model->getComment($tid);
        $data['tid']=$tid;
        $this->load->module('Template');
        $this->template->temp($data);
    }
    public function editShare($tid){
        $submit=$this->input->post('submit');
        if($submit=='Submit'){
            $this->load->library('form_validation');
            $this->form_validation->set_rules('title', 'Title', 'required|max_length[100]|min_length[3]');
            $this->form_validation->set_rules('text_content', 'Content', 'required|max_length[1000]|min_length[5]');
            if($this->form_validation->run()==TRUE){
                $this->load->model('TravelShare_model');
                $query=$this->TravelShare_model->editShare();
                if($query){
                    $flash_msg='Edit Success!';
                    $value='<div class="alert alert-success" role="alert">'.$flash_msg.'</div>';
                    $this->session->set_flashdata('item',$value);
                }else{
                    $flash_msg='Edit Fail!';
                    $value='<div class="alert alert-danger" role="alert">'.$flash_msg.'</div>';
                    $this->session->set_flashdata('item',$value);
                }
            }
        }
        $data['flash']=$this->session->flashdata('item');
        $data['headerText']='Edit Share';
        $data['content_view'] = 'TravelShare/editShare_v';
        $this->load->model('TravelShare_model');
        $data['records']=$this->TravelShare_model->getShareContent($tid);
        $this->load->module('Template');
        $this->template->temp($data);
    }
    public function deleteShareProcess($tid){
        $this->load->model('TravelShare_model');
$query=$this->TravelShare_model->deleteShare($tid);
        if($query){
            $flash_msg='Delete Success!';
            $value='<div class="alert alert-success" role="alert">'.$flash_msg.'</div>';
            $this->session->set_flashdata('item',$value);
            redirect(base_url('index.php/TravelShare'));
        }
    }
    public function shareSearch($keyword){
        $this->load->model('TravelShare_model');
        $this->load->library('pagination');
        $config['total_rows'] = $this->TravelShare_model->countShareSearch($keyword);
        $config['per_page'] = 6;
        $config['uri_segment'] = 4;
        $config['num_links'] = 2;
        $config['base_url'] = base_url("index.php/TravelShare/shareSearch/".$keyword);
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';//use bootstrip interface
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['use_page_numbers'] = TRUE;
        $page = $this->uri->segment(4, 1);
        $start_num = ($page - 1) * $config['per_page'];
        $this->pagination->initialize($config);
        $data['link'] = $this->pagination->create_links();
$data['records']=$this->TravelShare_model->shareSearch($keyword,$config['per_page'],$start_num);
        $data['content_view'] = 'TravelShare/ShareHome_v';
        $this->load->module('Template');
        $this->template->temp($data);
    }
    public function MyShare(){
        $this->load->model('TravelShare_model');
        $this->load->library('pagination');
        $config['total_rows'] = $this->TravelShare_model->countMyShare();
        $config['per_page'] = 6;
        $config['uri_segment'] = 3;
        $config['num_links'] = 2;
        $config['base_url'] = base_url("index.php/TravelShare/MyShare");
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';//use bootstrip interface
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['use_page_numbers'] = TRUE;
        $page = $this->uri->segment(3, 1);
        $start_num = ($page - 1) * $config['per_page'];
        $this->pagination->initialize($config);
        $data['link'] = $this->pagination->create_links();
        $data['records'] = $this->TravelShare_model->getMyShare($config['per_page'],$start_num);
        $data['content_view'] = 'TravelShare/ShareHome_v';
        $this->load->module('Template');
        $this->template->temp($data);
    }
}