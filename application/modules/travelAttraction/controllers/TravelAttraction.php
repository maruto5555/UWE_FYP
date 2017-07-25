<?php

/**
 * Created by PhpStorm.
 * User: wong
 * Date: 3/3/2017
 * Time: 12:24 AM
 */
class TravelAttraction extends MX_Controller
{
    public function selectCountry()
    {
        $this->load->model('TravelAttraction_model');
        $data['records'] = $this->TravelAttraction_model->getCountry();
        $this->load->module('Template');
        $data['headerText']='Travel Attraction';
        $data['content_view'] = 'travelAttraction/selectCountry_v';
        $this->template->temp($data);
    }

//    public function allCountryJSON()
//    {
//        $this->load->model('TravelAttraction_model');
//       $query= $this->TravelAttraction_model->getCountry();
//       if($query!=false){
//           $countryList=array();
//           $arrayCount=0; //get array number
//           foreach ($query->result() as $row){
//               array_push($countryList,array(
//                   'countryId'=>$row->countryId,
//                   'countryName'=>$row->countryName,
//                   'city'=>array()
//               ));
//               $query1=$this->TravelAttraction_model->getCity($row->countryId);
//               if($query1!=false){
//                 foreach ($query1->result() as $row1){
//                     array_push($countryList[$arrayCount]['city'], array( //push city
//                             'cityId'=>$row1->cityId,
//                             'cityName'=>$row1->cityName
//                     ));
//                 }
//               }
//               $arrayCount++;
//           }
//           $myJSON=json_encode($countryList);
//           echo $myJSON;
//       }else{
//           $result = array('error' => 'no result');
//           $myJSON = json_encode($result);
//           echo $myJSON;
//       }
//    }

    public function allAttractionJSON()
    {
        $this->load->model('TravelAttraction_model');
        if (isset($_GET['cityId'])) { //search by city id
            $query = $this->TravelAttraction_model->getAttractionList($this->input->get('cityId'));
            if ($query != false) {
                $attractionList = array();
                foreach ($query->result() as $row) {
                    array_push($attractionList, array(
                        'taId' => $row->taId,
                        'placeName' => $row->placeName,
                        'image' => $row->image
                    ));
                }
                $myJSON = json_encode($attractionList);
                echo $myJSON;
            } else {
                $result = array('error' => 'no result');
                $myJSON = json_encode($result);
                echo $myJSON;
            }
        } else if (isset($_GET['keyword'])) { //search by keyword
            $query = $this->TravelAttraction_model->searchAttraction($this->input->get('keyword'));
            if ($query != false) {
                $attractionList = array();
                foreach ($query->result() as $row) {
                    array_push($attractionList, array(
                        'taId' => $row->taId,
                        'placeName' => $row->placeName,
                        'image' => $row->image
                    ));
                }
                $myJSON = json_encode($attractionList);
                echo $myJSON;
            } else {
                $result = array('error' => 'no result');
                $myJSON = json_encode($result);
                echo $myJSON;
            }
        } else { //get all
            $query = $this->TravelAttraction_model->getAllAttraction();
            if ($query != false) {
                $attractionList = array();
                foreach ($query->result() as $row) {
                    array_push($attractionList, array(
                        'taId' => $row->taId,
                        'placeName' => $row->placeName,
                        'image' => $row->image
                    ));
                }
                $myJSON = json_encode($attractionList);
                echo $myJSON;
            } else {
                $result = array('error' => 'no result');
                $myJSON = json_encode($result);
                echo $myJSON;
            }
        }

    }
    public function getAttractionVRJSON()
    {
        $this->load->model('TravelAttraction_model');
        $query = $this->TravelAttraction_model->getAttractionVR($this->input->get('taId'));
        if ($query != false) {
            $VRList = array();
            foreach ($query->result() as $row) {
                array_push($VRList, array(
                    'iid' => $row->iid,
                    'source' => $row->source,
                    'thumbnail' => $row->thumbnail,
                    'name' => $row->name
                ));
            }
            $myJSON = json_encode($VRList);
            echo $myJSON;
        } else {
            $result = array('error' => 'no result');
            $myJSON = json_encode($result);
            echo $myJSON;
        }
    }

    public function showAttraction($taId)
    {
        $this->load->model('TravelAttraction_model');
        $data['records'] = $this->TravelAttraction_model->getAttraction($taId);
        $data['vrImage'] = $this->TravelAttraction_model->getAttractionVR($taId);
        $data['taId'] = $taId;
        $this->load->module('Template');
        $data['content_view'] = 'travelAttraction/travelAttraction_v';
        $this->template->temp($data);
    }

}