<?php

class Admin extends MX_Controller
{
    public function insertAttraction($cityId)
    {
        $submit=$this->input->post('submit');
        if($submit=='Submit'){
            $this->load->model('Admin_model');
            $query = $this->Admin_model->insertAttraction($cityId);
            if ($query) {
                $flash_msg='Submit Success!';
                $value='<div class="alert alert-success" role="alert">'.$flash_msg.'</div>';
                $this->session->set_flashdata('item',$value);
            } else {
                $flash_msg='Submit Fail!';
                $value='<div class="alert alert-danger" role="alert">'.$flash_msg.'</div>';
                $this->session->set_flashdata('item',$value);
            }
        }
        $breadCrumbs_data['current_page_title']='insert';
        $breadCrumbs_data['breadCrumbs_array']=$this->_generate_breadcrumbs_array_forInsert($cityId);
        $data['breadCrumbs_data']=$breadCrumbs_data;
        $this->load->module('Template');
        $data['content_view'] = 'admin/addAttraction_form_v';
        $data['cityId']=$cityId;
        $data['flash']=$this->session->flashdata('item');
        $data['header']='Add attraction';
        $this->template->adminTemp($data);
    }
    public function editAttraction($taId,$cityId){
        $submit=$this->input->post('submit');
        if($submit=='Submit'){
            $this->load->model('Admin_model');
            $query=$this->Admin_model->editAttraction($taId);
            if ($query) {
                $flash_msg='Edit Success!';
                $value='<div class="alert alert-success" role="alert">'.$flash_msg.'</div>';
                $this->session->set_flashdata('item',$value);
            } else {
                $flash_msg='Edit Fail!';
                $value='<div class="alert alert-danger" role="alert">'.$flash_msg.'</div>';
                $this->session->set_flashdata('item',$value);
            }
        }
        $this->load->model('Admin_model');

        $breadCrumbs_data['current_page_title']='edit';
        $breadCrumbs_data['breadCrumbs_array']=$this->_generate_breadcrumbs_array_forInsert($cityId);
        $data['breadCrumbs_data']=$breadCrumbs_data;
        $this->load->module('Template');
        $data['content_view'] = 'admin/editAttraction_form_v';
        $data['records'] = $this->Admin_model->getAttractionById($taId);
        $data['flash']=$this->session->flashdata('item');
        $data['taId']=$taId;
        $data['cityId']=$cityId;
        $data['header']='Edit attraction';
        $this->template->adminTemp($data);
    }
    public function insertCountry(){
        $submit=$this->input->post('submit');
        if($submit=='Submit'){
            $this->load->model('Admin_model');
            $query = $this->Admin_model->insertCountry();
            if ($query) {
                $flash_msg='Submit Success!';
                $value='<div class="alert alert-success" role="alert">'.$flash_msg.'</div>';
                $this->session->set_flashdata('item',$value);
            } else {
                $flash_msg='Submit Fail!';
                $value='<div class="alert alert-danger" role="alert">'.$flash_msg.'</div>';
                $this->session->set_flashdata('item',$value);
            }
        }
        $data['header']='Add Country';
        $data['flash']=$this->session->flashdata('item');
        $data['content_view'] = 'admin/addCountry_form_v';
        $this->load->module('Template');
        $this->template->adminTemp($data);
    }
    public function editCountry($countryId=null){
        $submit=$this->input->post('submit');
        if($submit=='Submit'){
            $this->load->model('Admin_model');
            $query=$this->Admin_model->editCountry($countryId);
            if ($query) {
                $flash_msg='Edit Success!';
                $value='<div class="alert alert-success" role="alert">'.$flash_msg.'</div>';
                $this->session->set_flashdata('item',$value);
            } else {
                $flash_msg='Edit Fail!';
                $value='<div class="alert alert-danger" role="alert">'.$flash_msg.'</div>';
                $this->session->set_flashdata('item',$value);
            }
        }
        $this->load->model('Admin_model');
        $data['records'] = $this->Admin_model->getCountryById($countryId);
        $data['content_view'] = 'admin/editCountry_form_v';
        $data['flash']=$this->session->flashdata('item');
        $data['header']='Edit Country';
        $this->load->module('Template');
        $this->template->adminTemp($data);
    }

    public function attractionList($cityId=null){
        $this->load->model('Admin_model');
        $this->load->library('pagination');
        $config['total_rows'] = $this->Admin_model->countAttractionById($cityId);
        $config['per_page'] = 6;
        $config['uri_segment'] = 4;
        $config['num_links'] = 2;
        $config['base_url'] = base_url("index.php/admin/attractionList/".$cityId."/");
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
        $query=$this->getCountryId($cityId);
        $row=$query->row();
        $country_id=$row->country_id;
        $breadCrumbs_data['current_page_title']='attraction';
        $breadCrumbs_data['breadCrumbs_array']=$this->_generate_breadcrumbs_array($country_id);
        $data['breadCrumbs_data']=$breadCrumbs_data;
        $data['link'] = $this->pagination->create_links();
        $data['records'] = $this->Admin_model->attractionList($cityId,$config['per_page'],$start_num);
        $data['cityId']=$cityId;
        $data['header']='Attraction List';
        $data['content_view'] = 'admin/attractionList_v';
        $data['flash']=$this->session->flashdata('item');
        $this->load->module('Template');
        $this->template->adminTemp($data);
    }
    public function cityList($countryId=null){
        $this->load->model('Admin_model');
        $this->load->library('pagination');
        $config['total_rows'] = $this->Admin_model->countryCityById($countryId);
        $config['per_page'] = 6;
        $config['uri_segment'] = 4;
        $config['num_links'] = 2;
        $config['base_url'] = base_url("index.php/admin/cityList/".$countryId."/");
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
        $data['records'] = $this->Admin_model->cityList($countryId,$config['per_page'],$start_num);
        $data['countryId']=$countryId;
        $data['content_view'] = 'admin/cityList_v';
        $data['header']='City List';
        $data['flash']=$this->session->flashdata('item');
        $this->load->module('Template');
        $this->template->adminTemp($data);
    }
    public function countryList(){
        $this->load->model('Admin_model');
        $this->load->library('pagination');
        $config['total_rows'] = $this->Admin_model->countCountry();
        $config['per_page'] = 6;
        $config['uri_segment'] = 3;
        $config['num_links'] = 2;
        $config['base_url'] = base_url("index.php/admin/countryList/");
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
        $data['records'] = $this->Admin_model->countryList($config['per_page'],$start_num);
        $data['content_view'] = 'admin/countryList_v';
        $data['header']='Country List';
        $data['flash']=$this->session->flashdata('item');
        $this->load->module('Template');
        $this->template->adminTemp($data);
    }
    public function insertCity($countryId=null){
        $submit=$this->input->post('submit');
        if($submit=='Submit'){
            $this->load->model('Admin_model');
            $query = $this->Admin_model->insertCity($countryId);
            if ($query) {
                $flash_msg='Submit Success!';
                $value='<div class="alert alert-success" role="alert">'.$flash_msg.'</div>';
                $this->session->set_flashdata('item',$value);
            } else {
                $flash_msg='Submit Fail!';
                $value='<div class="alert alert-danger" role="alert">'.$flash_msg.'</div>';
                $this->session->set_flashdata('item',$value);
            }
        }
        $data['content_view'] = 'admin/addCity_form_v';
        $data['flash']=$this->session->flashdata('item');
        $data['header']='Add City';
        $data['countryId']=$countryId;
        $this->load->module('Template');
        $this->template->adminTemp($data);
    }

public function editCity($cityId){
    $submit=$this->input->post('submit');
    if($submit=='Submit'){
        $this->load->model('Admin_model');
        $query=$this->Admin_model->editCity($cityId);
        if ($query) {
            $flash_msg='Edit Success!';
            $value='<div class="alert alert-success" role="alert">'.$flash_msg.'</div>';
            $this->session->set_flashdata('item',$value);
        } else {
            $flash_msg='Edit Fail!';
            $value='<div class="alert alert-danger" role="alert">'.$flash_msg.'</div>';
            $this->session->set_flashdata('item',$value);
        }
    }
    $this->load->model('Admin_model');
    $data['records'] = $this->Admin_model->getCityById($cityId);
    $data['cityId']=$cityId;
    $data['content_view'] = 'admin/editCity_form_v';
    $data['flash']=$this->session->flashdata('item');
    $data['header']='Edit City';
    $this->load->module('Template');
    $this->template->adminTemp($data);
}
public function deleteCity($cityId,$countryId){
    $this->load->model('Admin_model');
    $query=$this->Admin_model->deleteCity($cityId);
    if($query){
        $flash_msg='Delete Success!';
        $value='<div class="alert alert-success" role="alert">'.$flash_msg.'</div>';
        $this->session->set_flashdata('item',$value);
        redirect(site_url('admin/cityList/'.$countryId));
    }else{
        $flash_msg='Delete Fail!';
        $value='<div class="alert alert-danger" role="alert">'.$flash_msg.'</div>';
        $this->session->set_flashdata('item',$value);
        redirect(site_url('admin/cityList/'.$countryId));
    }
}
    public function deleteCountry($countryId=null){
        $this->load->model('Admin_model');
        $query=$this->Admin_model->deleteCountry($countryId);
        if ($query) {
            $flash_msg='Delete Success!';
            $value='<div class="alert alert-success" role="alert">'.$flash_msg.'</div>';
            $this->session->set_flashdata('item',$value);
            redirect(site_url('admin/countryList/'));
        } else {
            $flash_msg='Delete Fail!';
            $value='<div class="alert alert-danger" role="alert">'.$flash_msg.'</div>';
            $this->session->set_flashdata('item',$value);
            redirect(site_url('admin/countryList/'));
        }
    }
    public function deleteAttraction($taId,$cityId){
        $this->load->model('Admin_model');
        $query=$this->Admin_model->deleteAttraction($taId);
        if($query){
            $flash_msg='Delete Success!';
            $value='<div class="alert alert-success" role="alert">'.$flash_msg.'</div>';
            $this->session->set_flashdata('item',$value);
            redirect(site_url('admin/attractionList/'.$cityId));
        }else{
            $flash_msg='Delete Fail!';
            $value='<div class="alert alert-danger" role="alert">'.$flash_msg.'</div>';
            $this->session->set_flashdata('item',$value);
            redirect(site_url('admin/attractionList/'.$cityId));
        }

    }
    public function getCountryId($city_id){
        $this->load->model('Admin_model');
        $query=$this->Admin_model->getCountryIdByCity($city_id);
        return $query;
    }
public function _generate_breadcrumbs_array($country_id){
        $countryLink=site_url('admin/countryList');
        $cityLink=site_url('admin/cityList/'.$country_id);
        $breadCrumbs_array[$countryLink]='Country';
    $breadCrumbs_array[$cityLink]='City';
        return $breadCrumbs_array;
}
public function _generate_breadcrumbs_array_forInsert($city_id){
    $attractionLink=site_url('admin/attractionList/'.$city_id);
    $breadCrumbs_array[$attractionLink]='Attraction';
    return $breadCrumbs_array;
}
}