<?php

class Login extends MX_Controller
{
    public function loginForm()
    {
        $submit=$this->input->post('submit');
        if($submit=='Submit'){
            $this->load->library('form_validation');
            $this->form_validation->set_rules('email', 'Email', 'trim|required');
            $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]|max_length[32]');
            if ($this->form_validation->run() == TRUE) {
                $this->load->model('Login_model');
                $query = $this->Login_model->login();
                if ($query != false) {
                    $rows = $query->row();
                    $data = array(
                        'email' => $this->input->post('email'),
                        'username' => $rows->username,
                        'uid' => $rows->uid,
                        'is_logged_in' => true,
                        'is_admin' => $rows->uLevel
                    );
                    $this->session->set_userdata($data);
                    $flash_msg='Login Success!';
                    $value='<div class="alert alert-success" role="alert">'.$flash_msg.'</div>';
                    $this->session->set_flashdata('item',$value);
                    redirect(site_url('Home'));
                } else {
                    $flash_msg='Login Fail!';
                    $value='<div class="alert alert-danger" role="alert">'.$flash_msg.'</div>';
                    $this->session->set_flashdata('item',$value);
                }
            }
        }
        $data['headerText']='Login';
        $data['flash']=$this->session->flashdata('item');
        $data['content_view'] = 'Login/loginForm_v';
        $this->load->module('Template');
        $this->template->temp($data);
    }

    public function signUpForm()
    {
        $submit=$this->input->post('submit');
        if($submit=='Submit'){
            $this->load->library('form_validation');
            $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_unique[user.email]');
            $this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[3]|max_length[32]|is_unique[user.username]');
            $this->form_validation->set_rules('firstname', 'First name', 'trim|required');
            $this->form_validation->set_rules('lastname', 'Last name', 'trim|required');
            $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]|max_length[32]');
            $this->form_validation->set_rules('cpassword', 'Password Confirmation', 'trim|required|matches[password]');
            if ($this->form_validation->run() == TRUE) {
                $this->load->model('Login_model');
                $query = $this->Login_model->signUp();
                if ($query) {
                    $flash_msg='SignUp Success!';
                    $value='<div class="alert alert-success" role="alert">'.$flash_msg.'</div>';
                    $this->session->set_flashdata('item',$value);
                    redirect(site_url('Login/loginForm'));
                } else {
                    $flash_msg='SignUp Fail!';
                    $value='<div class="alert alert-danger" role="alert">'.$flash_msg.'</div>';
                    $this->session->set_flashdata('item',$value);
                }
            }
        }
        $data['headerText']='SignUp';
        $data['flash']=$this->session->flashdata('item');
        $data['content_view'] = 'Login/signUpForm_v';
        $this->load->module('Template');
        $this->template->temp($data);
    }
    public function logout()
    {
        $this->session->sess_destroy();
        $flash_msg='Logout Success!';
        $value='<div class="alert alert-success" role="alert">'.$flash_msg.'</div>';
        $this->session->set_flashdata('item',$value);
        redirect(base_url('index.php/Login/loginForm'));
    }

    public function profile()
    {
        $data['content_view'] = 'Login/profile_v';
        $this->load->model('Login_model');
        $query = $this->Login_model->profile();
        $data['profile'] = $query;
        $data['headerText']='Profile';
        $this->load->module('Template');
        $this->template->temp($data);
    }

    public function updateProfile()
    {
        $submit=$this->input->post('submit');
        if($submit=='Submit'){
            $this->load->library('form_validation');
            if ($_POST['email'] != $_SESSION['email']) {
                $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_unique[user.email]');
            }
            if ($_POST['username'] != $_SESSION['username']) {
                $this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[3]|max_length[32]|is_unique[user.username]');
            }
            $this->form_validation->set_rules('firstname', 'First name', 'trim|required');
            $this->form_validation->set_rules('lastname', 'Last name', 'trim|required');
            if ($this->form_validation->run() == TRUE) {
                $this->load->model('Login_model');
                $query = $this->Login_model->updateProfile();
                if ($query) {
                    $flash_msg='Update Success!';
                    $value='<div class="alert alert-success" role="alert">'.$flash_msg.'</div>';
                    $this->session->set_flashdata('item',$value);
                } else {
                    $flash_msg='Update Fail!';
                    $value='<div class="alert alert-danger" role="alert">'.$flash_msg.'</div>';
                    $this->session->set_flashdata('item',$value);
                }
            }
        }
        $data['flash']=$this->session->flashdata('item');
        $data['content_view'] = 'Login/updateProfile_v';
        $data['headerText']='Update Profile';
        $this->load->model('Login_model');
        $query = $this->Login_model->profile();
        $data['profile'] = $query;
        $this->load->module('Template');
        $this->template->temp($data);
    }
    public function updatePassword(){
        $submit=$this->input->post('submit');
        if($submit=='Submit'){
            $this->load->library('form_validation');
            $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]|max_length[32]');
            $this->form_validation->set_rules('cpassword', 'Password Confirmation', 'trim|required|matches[password]');
            if ($this->form_validation->run() == TRUE) {
                $this->load->model('Login_model');
                $query = $this->Login_model->updatePassword();
                if ($query) {
                    $flash_msg='Password Update Success!';
                    $value='<div class="alert alert-success" role="alert">'.$flash_msg.'</div>';
                    $this->session->set_flashdata('item',$value);
                } else {
                    $flash_msg='Update Fail!';
                    $value='<div class="alert alert-danger" role="alert">'.$flash_msg.'</div>';
                    $this->session->set_flashdata('item',$value);
                }
            }
        }
        $data['flash']=$this->session->flashdata('item');
        $data['content_view'] = 'Login/updatePassword_v';
        $data['headerText']='Update Password';
        $this->load->model('Login_model');
        $this->load->module('Template');
        $this->template->temp($data);
    }
    public function updateIcon(){
        $submit=$this->input->post('submit');
        if($submit=='Submit'){
            $config['upload_path'] = './picture/userIcon/';
            $config['allowed_types'] = 'gif|jpg|png';
            $config['overwrite']=TRUE;
            $config['max_size'] = 2000;
            $config['max_width'] = 1024;
            $config['max_height'] = 768;
            $config['max_filename'] = 60;
            $config['remove_spaces'] = TRUE;
            $config['file_name']=$this->session->userdata('email').".jpg";
            $this->load->library('upload', $config);
            if (!$this->upload->do_upload('userfile')) {
                $data['error'] = $this->upload->display_errors('<div class="alert alert-danger">','</div>');
            } else {
                $picName = $this->upload->data('file_name');
                $picPath = base_url('picture/userIcon/'.$picName);
                $this->load->model('Login_model');
                $query = $this->Login_model->updateIcon($picName, $picPath);
                if ($query) {
                    $flash_msg='Update Icon Success!';
                    $value='<div class="alert alert-success" role="alert">'.$flash_msg.'</div>';
                    $this->session->set_flashdata('item',$value);
                } else {
                    $flash_msg='Update Icon Fail!';
                    $value='<div class="alert alert-danger" role="alert">'.$flash_msg.'</div>';
                    $this->session->set_flashdata('item',$value);
                }
            }
        }
        $data['headerText']='Update Icon';
        $data['flash']=$this->session->flashdata('item');
        $data['content_view'] = 'Login/updateIcon_v';
        $this->load->module('Template');
        $this->template->temp($data);
    }
}

?>