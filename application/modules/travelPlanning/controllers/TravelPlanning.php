<?php

class TravelPlanning extends MX_Controller
{
    public function index()
    {
        $this->load->model('TravelPlanning_model');
        $data['records'] = $this->TravelPlanning_model->getCityList();
        $data['content_view'] = 'travelPlanning/travelPlanningHome_v';
        $this->load->module('Template');
        $this->template->temp($data);
    }

    public function insertTravel()
    {
        $this->load->model('TravelPlanning_model');
        $query = $this->TravelPlanning_model->insertTravel();
        if ($query) {
            echo '<div class="alert alert-success">Success</div>';
            echo '<a href="' . site_url("travelPlanning/getTravelPlan/" . $_SESSION["uid"] . "/") . '">Go to my plan list</a>';
        } else {
            echo '<div class="alert alert-danger">Insert fail</div>';
        }
    }

    public function showDayNum($travelId)
    {
        $this->load->model('TravelPlanning_model');
        $data['records'] = $this->TravelPlanning_model->showDayNum($travelId);
        $data['travelId'] = $travelId;
        $data['content_view'] = 'travelPlanning/insertDayNum_v';
        $this->load->module('Template');
        $this->template->temp($data);
    }

    public function getTravelPlan($uid)
    {
        $this->load->model('TravelPlanning_model');
        $this->load->library('pagination');
        $config['total_rows'] = $this->TravelPlanning_model->countMyPlan($uid);
        $config['per_page'] = 6;
        $config['uri_segment'] = 4;
        $config['num_links'] = 2;
        $config['base_url'] = site_url('travelPlanning/getTravelPlan/' . $uid . '/');
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
        $data['records'] = $this->TravelPlanning_model->getMyPlan($uid, $config['per_page'], $start_num);
        $data['content_view'] = 'travelPlanning/myPlan_v';
        $data['headerText'] = 'My travel plan';
        $data['flash'] = $this->session->flashdata('item');
        $this->load->module('Template');
        $this->template->temp($data);
    }

    public function showAttractionForPlanning($travelId)
    {
        $this->load->model('TravelPlanning_model');
        $data['records'] = $this->TravelPlanning_model->getAttractionList($travelId);
//        $data['travelDay'] = $this->TravelPlanning_model->showDayNum($travelId);
//        $data['dayOrder'] = $this->TravelPlanning_model->getDayOrder($dayId);
        $data['travelId'] = $travelId;
        $data['headerText'] = 'Make your plan';
//        $data['selectedAttraction'] = $this->TravelPlanning_model->getAllSelectedAttraction($dayId);
        $data['content_view'] = 'travelPlanning/travelPlanningForm_v';
        $this->load->module('Template');
        $this->template->temp($data);
    }

//    public function getAttractionListJSON()
//    {
//        $this->load->model('TravelPlanning_model');
//        $query = $this->TravelPlanning_model->getAttractionList($this->input->get('travelId'));
//        if ($query != false) {
//            $attractionList=array();
//            foreach ($query->result() as $row){
//                array_push($attractionList,array(
//                    'taId'=>$row->taId,
//                    'placeName'=>$row->placeName,
//                    'image'=>$row->image,
//                    'cityId'=>$row->city_id,
//                    'cityName'=>$row->cityName
//                ));
//            }
//            $myJSON = json_encode($attractionList);
//            echo $myJSON;
//        }else{
//            $result = array('error' => 'no result');
//            $myJSON = json_encode($result);
//            echo $myJSON;
//        }
//    }

    public function insertDayNum()
    {
        $this->load->model('TravelPlanning_model');
        $dayId = $this->TravelPlanning_model->insertDayNum(); //get day id for echo
        $data = array(
            'dayId' => $dayId,
            'travel_id' => $this->input->post('travelId'),
            'dayOrder' => $this->input->post('dayOrder')
        );
        $myJSON = json_encode($data);
        echo $myJSON;
    }

    public function deleteDayNum()
    {
        $this->load->model('TravelPlanning_model');
        $query = $this->TravelPlanning_model->deleteDayNum();
        if ($query) {
            echo '<div class="alert alert-success">Delete Success</div>';
        } else {
            echo '<div class="alert alert-danger">Delete fail</div>';
        }
    }

    public function loadDayJSON()
    {
        $this->load->model('TravelPlanning_model');
        $query = $this->TravelPlanning_model->showDayNum($this->input->get('travelId'));
        if ($query != false) {
            $dayList = array();
            foreach ($query->result() as $row) {
                array_push($dayList, array(
                    'dayId' => $row->dayId,
                    'dayOrder' => $row->dayOrder
                ));
            }
            $myJSON = json_encode($dayList);
            echo $myJSON;
        } else {
            $result = array('error' => 'no result');
            $myJSON = json_encode($result);
            echo $myJSON;
        }
    }

    public function loadSelectedAttractionJSON()
    {
        $this->load->model('TravelPlanning_model');
        $selected = $this->TravelPlanning_model->getAllSelectedAttraction($this->input->get('dayId'));
        if ($selected != false) {
            $selectedList = array();
            foreach ($selected->result() as $row) {
                array_push($selectedList, array(
                    'image' => $row->image,
                    'taId' => $row->taId,
                    'placeName' => $row->placeName,
                    'itemId' => $row->itemId,
                    'time' => $row->time,
                    'place_id' => $row->place_id,
                    'note' => $row->note
                ));
            }
            $myJSON = json_encode($selectedList);
            echo $myJSON;
        } else {
            $result = array('error' => 'no result');
            $myJSON = json_encode($result);
            echo $myJSON;
        }

    }

    public function getAllSelectedItem($travelId)
    {
        $this->load->model('TravelPlanning_model');
        $data['records'] = $this->TravelPlanning_model->getAllSelectedItem($travelId);
        $data['content_view'] = 'travelPlanning/allItem_v';
        $this->load->module('Template');
        $this->template->temp($data);
    }

    public function insertDayItem($dayId)
    {
        $this->load->model('TravelPlanning_model');
        $itemId = $this->TravelPlanning_model->insertDayItem($dayId);
        $query = $this->TravelPlanning_model->getAttractionById($this->input->post('attraction_id'));//get attraction data
        $row = $query->row();
        $data = array(
            'image' => $row->image,
            'placeName' => $row->placeName,
            'itemId' => $itemId,
            'taId' => $this->input->post('attraction_id'),
            'time' => '07:00'
        );
        $myJSON = json_encode($data);
        echo $myJSON;
    }


    public function updateDayItemTime($itemId)
    {
        $this->load->model('TravelPlanning_model');
        $query = $this->TravelPlanning_model->updateDayItemTime($itemId);
        if ($query) {
            echo '<div class="alert alert-success">Update Success</div>';
        } else {
            echo '<div class="alert alert-danger">update fail</div>';
        }
    }

    public function updateNote($dayId)
    {
        $this->load->model('TravelPlanning_model');
        $query = $this->TravelPlanning_model->updateNote($dayId);
        if ($query) {
            echo '<div class="alert alert-success">Success</div>';
        } else {
            echo '<div class="alert alert-danger">update fail</div>';
        }
    }

    public function deleteDayItem($itemId)
    {
        $this->load->model('TravelPlanning_model');
        $query = $this->TravelPlanning_model->deleteDayItem($itemId);
        if ($query) {
            echo '<div class="alert alert-success">Delete Success</div>';
        }
    }

    public function deleteTravel($travelId)
    {
        $this->load->model('TravelPlanning_model');
        $this->TravelPlanning_model->deleteTravel($travelId);
        $flash_msg = 'Delete Success!';
        $value = '<div class="alert alert-success" role="alert">' . $flash_msg . '</div>';
        $this->session->set_flashdata('item', $value);
        redirect(site_url('travelPlanning/getTravelPlan/' . $_SESSION['uid']));
    }

}