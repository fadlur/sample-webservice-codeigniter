<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Register extends CI_Controller{

    public function __construct()
    {
        parent::__construct();
		$this->load->library('session');
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->library('ion_auth');
        $this->load->library('form_validation');
        $this->load->helper('security');
    }

    function index()
    {

        if (!$this->ion_auth->logged_in()) {
			$data = array('content' => 'formregister',
				'message'=>$this->session->set_flashdata('message', $this->ion_auth->messages()),
				'title'=>'Registration Page',
				'description'=>'Registration Page');
			$this->load->view('templates/template-home',$data);
		}else{
            if ($this->ion_auth->in_group('admin')) {
                redirect('admin','refresh');
            }elseif ($this->ion_auth->in_group('user')) {
            	redirect('user','refresh');
            }else{
				redirect('register','refresh');
			}
        }
    }
    function prosesdaftar(){
        if (!$this->input->is_ajax_request()) {
            show_404();
        }else{
            $this->form_validation->set_rules('first_name', 'Nama Depan', 'trim|required|xss_clean');
            $this->form_validation->set_rules('last_name', 'Nama Belakang', 'trim|required|xss_clean');
            $this->form_validation->set_rules('username', 'Username', 'trim|required|xss_clean');
            $this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean');
            $this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');
            if ($this->form_validation->run()==false) {
                $status = 'error';
                $msg = validation_errors();
            }else{
                if ($this->ion_auth->username_check($this->input->post('username'))){
                    $status = 'error';
                    $msg = 'Username sudah ada, coba yang lain';
                }else if ($this->ion_auth->email_check($this->input->post('email'))){
                    $status = 'error';
                    $msg = 'Username sudah ada, coba yang lain';
                }else{
                    $username = $this->input->post('username');
            		$password = $this->input->post('password');
            		$email = $this->input->post('email');
            		$additional_data = array(
            								'first_name' => $this->input->post('first_name'),
            								'last_name' => $this->input->post('last_name'),
            								);
            		$group = array('2'); // Sets user to user

            		if($this->ion_auth->register($username, $password, $email, $additional_data, $group)){
                        $status = 'success';
                        $msg = "Selamat proses pendaftaran anda berhasil";
                    }
                }
            }
            $this->output->set_content_type('application/json')->set_output(json_encode(array('status'=>$status,'msg'=>$msg)));
        }
    }

}
