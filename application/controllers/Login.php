<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->library('ion_auth');
	}
	public function index()
	{
		if ($this->input->post()) {
			$this->load->library('form_validation');
			$this->form_validation->set_rules('username', 'Username', 'required');
			$this->form_validation->set_rules('remember', 'Remember me', 'integer');
			if ($this->form_validation->run()==TRUE) {
				$remember = (bool) $this->input->post('remember');
				if ($this->ion_auth->login($this->input->post('username'),$this->input->post('password'),$remember)) {
					redirect('member','refresh');
				}else{
					$this->session->flashdata('message',$this->ion_auth->errors());
					redirect('login','refresh');
				}
			}
		}
		if (!$this->ion_auth->logged_in()) {
			$data = array('content' => 'formlogin',
				'message'=>$this->session->set_flashdata('message', $this->ion_auth->messages()),
				'title'=>'Login Page',
				'description'=>'Login page');
			$this->load->view('templates/template-home',$data);
		}else{
            if ($this->ion_auth->in_group('admin')) {
                redirect('admin','refresh');
            }elseif ($this->ion_auth->in_group('user')) {
            	redirect('member','refresh');
            }else{
				redirect('login','refresh');
			}
        }
	}
	public function logout(){
		$this->ion_auth->logout();
  		redirect('login', 'refresh');
	}

}

/* End of file Login.php */
/* Location: .//var/www/fadlur/apps/controllers/Login.php */
