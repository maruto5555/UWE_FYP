<?php
/**
 * Created by PhpStorm.
 * User: wong
 * Date: 5/21/2017
 * Time: 2:11 AM
 */
class AdminChart extends MX_Controller
{
    public function index(){
        $data['header'] = 'View VR resource';
        $data['content_view'] = 'adminChart/chart_v';
        $this->load->module('Template');
        $this->template->adminTemp($data);
    }
}