<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller{

    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('model_unit','model_monitor'));
        $this->load->library(array('form_validation','pagination'));
        $this->load->helper(array('security'));
        $this->load->library('ion_auth');
        if (!$this->ion_auth->logged_in()) {
            redirect('login','refresh');
        }else{
            if (!$this->ion_auth->in_group('admin')) {
                redirect('login','refresh');
            }
        }
    }

    function index()
    {
        $user = $this->ion_auth->user()->row();
        $data = array('content' => 'admin/formmember',
        'itemmember'=>$this->ion_auth->users(2)->result(),
        'itemuser'=>$user);
        $this->load->view('templates/template-admin', $data);
    }
    function create(){
        if (!$this->input->is_ajax_request()) {
            show_404();
        }else{
            $this->form_validation->set_rules('username', 'Username', 'trim|required|xss_clean');
            $this->form_validation->set_rules('first_name', 'Nama', 'trim|required|xss_clean');
            $this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');
            if ($this->form_validation->run()==false) {
                $status = "error";
                $msg = validation_errors();
            }else{
                $username = $this->input->post('username');
        		$password = $this->input->post('password');
        		$email = '';
                $phone = $this->input->post('phone');
        		$additional_data = array(
        								'first_name' => $this->input->post('first_name'),
        								'last_name' => $this->input->post('last_name'),
                                        'phone'=>$phone,
        								);
        		$group = array(2); // Sets user to admin.

                if (!$this->ion_auth->username_check($username)) {
                    if ($this->ion_auth->register($username, $password, $email, $additional_data, $group)) {
                        $status = 'success';
                        $msg = "Data user akun berhasil disimpan";
                    }else{
                        $status = 'error';
                        $msg = 'Terjadi kesalahan saat menyimpan data user akun';
                    }
                }else{
                    $status = 'error';
                    $msg = 'Username sudah terdaftar';
                }
            }
            $this->output->set_content_type('application/json')->set_output(json_encode(array('status'=>$status,'msg'=>$msg)));
        }
    }
    function edit(){
        if (!$this->input->is_ajax_request()) {
            show_404();
        }else{
            $status = 'success';
            $msg = "Data user akun ditemukan";
            $user = $this->ion_auth->user($this->input->post('id'))->row();
            $this->output->set_content_type('application/json')->set_output(json_encode(array('status'=>$status,'msg'=>$msg,'user'=>$user)));
        }
    }
    function update(){
        if (!$this->input->is_ajax_request()) {
            show_404();
        }else{
            $id = $this->input->post('id_user');
            $this->form_validation->set_rules('first_name', 'Nama Depan', 'trim|required|xss_clean');
            $this->form_validation->set_rules('last_name', 'Nama Belakang', 'trim|required|xss_clean');
            $this->form_validation->set_rules('username', 'Username', 'trim|required|xss_clean');
            $this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');
            if ($this->form_validation->run()==false) {
                $status = "error";
                $msg = validation_errors();
            }else{
                $data = array(
                            'first_name' => $this->input->post('first_name'),
                            'last_name' => $this->input->post('last_name'),
                            'phone'=>$this->input->post('phone'),
                            'username'=>$this->input->post('username'),
                            'password'=>$this->input->post('password')
        					 );
        		if ($this->ion_auth->update($id, $data))
        		{
                    $status = "success";
        			$msg = $this->ion_auth->messages();
        		}
        		else
        		{
                    $status = "error";
                    $msg = "Terjadi kesalahan saat mengupdate data userakun";
        		}
            }
            $this->output->set_content_type('application/json')->set_output(json_encode(array('status'=>$status,'msg'=>$msg)));
        }
    }
    function delete(){
        if (!$this->input->is_ajax_request()) {
            show_404();
        }else{
            $id = $this->input->post('id');
    		if ($this->ion_auth->delete_user($id))
    		{
                $status = "success";
                $msg = "Data user akun berhasil dihapus";
    		}
    		else
    		{
                $status = "error";
                $msg = "Terjadi kesalahan saat menghapus data userakun";
    		}
            $this->output->set_content_type('application/json')->set_output(json_encode(array('status'=>$status,'msg'=>$msg)));
        }
    }
    function profil(){
        $data = array('content' => 'admin/formprofil',
        'itemuser'=>$this->ion_auth->user()->row());
        $this->load->view('templates/template-admin', $data);
    }
    function updateprofil(){
        if (!$this->input->is_ajax_request()) {
            show_404();
        }else{
            $user = $this->ion_auth->user()->row();
            $id = $user->id;
    		$data = array(
                        'first_name' => $this->input->post('first_name'),
                        'last_name' => $this->input->post('last_name'),
                        'phone'=>$this->input->post('phone'),
                        'email'=>$this->input->post('email'),
                        'username'=>$this->input->post('username')
    					 );
    		if ($this->ion_auth->update($id, $data))
    		{
                $status = "success";
    			$msg = $this->ion_auth->messages();
    		}
    		else
    		{
                $status = "error";
                $msg = "Terjadi kesalahan saat mengupdate data userakun";
    		}
            $this->output->set_content_type('application/json')->set_output(json_encode(array('status'=>$status,'msg'=>$msg)));
        }
    }
    function ubahpassword(){
        $data = array('content' => 'admin/formubahpassword',
        'itemuser'=>$this->ion_auth->user()->row());
        $this->load->view('templates/template-admin', $data);
    }
    function updatepassword(){
        if (!$this->input->is_ajax_request()) {
            show_404();
        }else{
            $this->form_validation->set_rules('password', 'Password Baru', 'trim|required|min_length[5]|xss_clean');
            $this->form_validation->set_rules('repeatpassword', 'Konfirmasi Password Baru', 'trim|required|min_length[5]|matches[password]|xss_clean');
            if ($this->form_validation->run()==false) {
                $status = "error";
                $msg = validation_errors();
            }else{
                $user = $this->ion_auth->user()->row();
                $id = $user->id;
        		$data = array(
                            'password'=>$this->input->post('password')
        					 );
        		if ($this->ion_auth->update($id, $data))
        		{
                    $status = "success";
        			$msg = $this->ion_auth->messages();
        		}
        		else
        		{
                    $status = "error";
                    $msg = "Terjadi kesalahan saat mengupdate data userakun";
        		}
            }
            $this->output->set_content_type('application/json')->set_output(json_encode(array('status'=>$status,'msg'=>$msg)));
        }
    }
    //combine petugas pemilu
    function createpetugaspemilu(){
        if (!$this->input->is_ajax_request()) {
            show_404();
        }else{
            $this->form_validation->set_rules('user_id', 'Petugas', 'trim|required|xss_clean');
            $this->form_validation->set_rules('pemilu_id', 'Pemilu', 'trim|required|xss_clean');
            if ($this->form_validation->run()==false) {
                $status = "error";
                $msg = validation_errors();
            }else{
                $user = $this->ion_auth->user()->row();
                if ($this->model_petugaspemilu->verifyPetugas($this->input->post('user_id'),$this->input->post('pemilu_id'))->num_rows()!=null) {
                    $status = "error";
                    $msg = "Petugas sudah terdaftar sebagai petugas di pemilu tersebut, coba yang lain";
                }else{
                    if ($this->model_petugaspemilu->create($user->id)) {
                        $status = "success";
                        $msg = "Data petugas pemilu berhasil disimpan";
                    }
                }
            }
            $this->output->set_content_type('application/json')->set_output(json_encode(array('status'=>$status,'msg'=>$msg)));
        }
    }
    //delete petugas pemilu
    function deletepetugaspemilu(){
        if (!$this->input->is_ajax_request()) {
            show_404();
        }else{
            $this->form_validation->set_rules('user_id', 'Petugas', 'trim|required|xss_clean');
            $this->form_validation->set_rules('pemilu_id', 'Pemilu', 'trim|required|xss_clean');
            if ($this->form_validation->run()==false) {
                $status = "error";
                $msg = validation_errors();
            }else{
                if ($this->model_petugaspemilu->delete($this->input->post('user_id'),$this->input->post('pemilu_id'))) {
                    $status = "success";
                    $msg = "Data petugas pemilu tersebut berhasil dihapus";
                }else{
                    $status = "error";
                    $msg = "Terjadi kesalahan saat menghapus data petugas pemilu";
                }
            }
            $this->output->set_content_type('application/json')->set_output(json_encode(array('status'=>$status,'msg'=>$msg)));
        }
    }

}
