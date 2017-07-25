<?php

/**
 * Created by PhpStorm.
 * User: wong
 * Date: 5/20/2017
 * Time: 1:10 AM
 */
class ViewVR extends MX_Controller
{
    public function index()
    {
        $this->load->model('ViewVR_model');
        $data['header'] = 'View VR resource';
        $data['records'] = $this->ViewVR_model->viewVR();
        $data['content_view'] = 'viewVR/viewVR_v';
        $this->load->module('Template');
        $this->template->adminTemp($data);
    }

    public function deleteVR($iid)
    {
        $this->load->model('ViewVR_model');
        $query = $this->ViewVR_model->deleteVR($iid);
        if ($query) {
            $flash_msg = 'Delete Success!';
            $value = '<div class="alert alert-success" role="alert">' . $flash_msg . '</div>';
            $this->session->set_flashdata('item', $value);
        }else{
            $flash_msg = 'Delete Fail!';
            $value = '<div class="alert alert-danger" role="alert">' . $flash_msg . '</div>';
            $this->session->set_flashdata('item', $value);
        }
        $data['flash'] = $this->session->flashdata('item');
        redirect(site_url('viewVR'));
    }
}