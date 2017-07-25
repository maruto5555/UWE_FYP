<?php

class ManageVR extends MX_Controller
{
    public function addVRResource($taId)
    {
        $submit = $this->input->post('submit');
        if ($submit == 'Submit') {
            $config['upload_path'] = './picture/resource/content/';
            $config['allowed_types'] = 'gif|jpg|png|mp4';
            $config['max_size'] = 0;
            $config['max_width'] = 0;
            $config['max_height'] = 0;
            $config['max_filename'] = 0;
            $config['remove_spaces'] = TRUE;
            $this->load->library('upload', $config);
            if (!$this->upload->do_upload('VRfile')) {
                $flash_msg = $this->upload->display_errors();
                $value = '<div class="alert alert-danger" role="alert">' . $flash_msg . '</div>';
                $this->session->set_flashdata('item', $value);
            } else {
                $filename = $this->upload->data('file_name');;
                $setThumbnail = $this->_generate_thumbnail($filename);
                if ($setThumbnail) {
                    $picPath = base_url('picture/resource/content/' . $filename);
                    $thumbnailPath = base_url('picture/resource/thumbnail/' . $filename);
                    $rawName = $this->upload->data('raw_name');
                    $this->load->model('ManageVR_model');
                    $this->ManageVR_model->insertVRResource($taId,$picPath,$thumbnailPath,$rawName);
                    $flash_msg = 'Upload Success!';
                    $value = '<div class="alert alert-success" role="alert">' . $flash_msg . '</div>';
                    $this->session->set_flashdata('item', $value);
                } else {
                    $flash_msg = $this->image_lib->display_errors();
                    $value = '<div class="alert alert-danger" role="alert">' . $flash_msg . '</div>';
                    $this->session->set_flashdata('item', $value);
                }
            }
        }
        $this->load->module('Template');
        $data['content_view'] = 'manageVR/addVR_v';
        $data['flash'] = $this->session->flashdata('item');
        $data['taId'] = $taId;
        $data['header'] = 'Insert VR resource';
        $this->template->adminTemp($data);
    }
public function getAttractionList(){
    $this->load->model('ManageVR_model');
    $this->load->library('pagination');
    $config['total_rows'] = $this->ManageVR_model->countAttraction();
    $config['per_page'] = 6;
    $config['uri_segment'] = 3;
    $config['num_links'] = 2;
    $config['base_url'] = site_url("manageVR/getAttractionList/");
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
    $data['records'] = $this->ManageVR_model->attractionList($config['per_page'],$start_num);
    $data['header']='Attraction List';
    $data['content_view'] = 'manageVR/attractionList_v';
    $data['flash']=$this->session->flashdata('item');
    $this->load->module('Template');
    $this->template->adminTemp($data);
}
    public function _generate_thumbnail($filename)
    {
        $config1['image_library'] = 'gd2';
        $config1['source_image'] = './picture/resource/content/' . $filename;
        $config1['new_image'] = './picture/resource/thumbnail/' . $filename;
        $config1['maintain_ratio'] = TRUE;
        $config1['width'] = 200;
        $config1['height'] = 200;
        $this->load->library('image_lib', $config1);
        if ($this->image_lib->resize()) {
            return true;
        } else {
            return false;
        }

    }

}