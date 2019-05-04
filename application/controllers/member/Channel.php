<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Channel extends CI_Controller{

    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('model_unit',
        'model_monitor',
        'model_key'));
        $this->load->library(array('form_validation','pagination'));
        $this->load->helper(array('security'));
        $this->load->library('ion_auth');
        if (!$this->ion_auth->logged_in()) {//cek login ga?
    		redirect('login','refresh');
    	}else{
            if (!$this->ion_auth->in_group('user')) {//cek admin ga?
                redirect('login','refresh');
            }
        }
    }

    function index()
    {
        $user = $this->ion_auth->user()->row();
        if ($this->model_key->getByUser($user->id)->num_rows()!=null) {
            foreach ($this->model_key->getByUser($user->id)->result() as $apikey) {
                $data = array('content' => 'member/formchannel',
                'title'=>'Daftar Channel',
                'itemuser'=>$user,
                'itemunit'=>$this->model_unit->getByUser($user->id),
                'itemmonitor'=>$this->model_monitor->getByApiKey($apikey->key));
                $this->load->view('templates/template-member', $data);
            }
        }else{
            $data = array('content' => 'member/formchannel',
            'title'=>'Daftar Channel',
            'itemuser'=>$user,
            'itemunit'=>$this->model_unit->getByUser($user->id),
            'itemmonitor'=>null);
            $this->load->view('templates/template-member', $data);
        }
    }
    function create(){
        if (!$this->input->is_ajax_request()) {
            show_404();
        }else{
            $this->form_validation->set_rules('unit', 'Unit', 'trim|required|xss_clean');
            if ($this->form_validation->run()==false) {
                $status = 'error';
                $msg = validation_errors();
            }else{
                $user = $this->ion_auth->user()->row();
                $unik = md5($user->email."+".$user->username);
                $apikey = substr($unik,2,17);
                if ($this->model_key->verifyCreate($user->id,$apikey)->num_rows()!=null) {
                    if($this->model_unit->create($this->input->post('unit'), $user->id,$apikey,$this->input->post('status'))){
                        $status = 'success';
                        $msg = 'Channel berhasil disimpan';
                    }else {
                        $status = 'error';
                        $msg = 'Gagal menyimpan channel';
                    }
                }else{
                    if ($this->model_key->create($user->id,$apikey)) {
                        if($this->model_unit->create($this->input->post('unit'), $user->id,$apikey,$this->input->post('status'))){
                            $status = 'success';
                            $msg = 'Channel berhasil disimpan';
                        }else {
                            $status = 'error';
                            $msg = 'Gagal menyimpan channel';
                        }
                    }else{
                        $status = 'error';
                        $msg = 'Gagal menyimpan api key, proses dihentikan';
                    }
                }
            }
            $this->output->set_content_type('application/json')->set_output(json_encode(array('status'=>$status,'msg'=>$msg)));
        }
    }
    function update(){
        if (!$this->input->is_ajax_request()) {
            show_404();
        }else{
            $this->form_validation->set_rules('unit', 'Unit', 'trim|required|xss_clean');
            $this->form_validation->set_rules('id_unit', 'ID Unit', 'trim|required|xss_clean');
            if ($this->form_validation->run()==false) {
                $status = 'error';
                $msg = validation_errors();
            }else{
                if($this->model_unit->update($this->input->post('id_unit'), $this->input->post('unit'),$this->input->post('status'))){
                    $status = 'success';
                    $msg = 'Channel berhasil diupdate';
                }else {
                    $status = 'error';
                    $msg = 'Gagal mengupdate channel';
                }
            }
            $this->output->set_content_type('application/json')->set_output(json_encode(array('status'=>$status,'msg'=>$msg)));
        }
    }
    function edit(){
        if (!$this->input->is_ajax_request()) {
            show_404();
        }else{
            if ($this->model_unit->read($this->input->post('id_unit'))->num_rows()!=null) {
                $status = 'success';
                $msg = 'Data unit ditemukan';
                $unit = $this->model_unit->read($this->input->post('id_unit'))->result();
            }else{
                $status = 'error';
                $msg = 'Data unit tidak ditemukan';
                $unit = null;
            }
            $this->output->set_content_type('application/json')->set_output(json_encode(array('status'=>$status,'msg'=>$msg,'unit'=>$unit)));
        }
    }
    function delete(){
        if (!$this->input->is_ajax_request()) {
            show_404();
        }else{
            if ($this->model_monitor->getByUnitId($this->input->post('id_unit'))->num_rows()!=null) {
                if ($this->model_monitor->deleteByUnitId($this->input->post('id_unit'))) {
                    if ($this->model_unit->delete($this->input->post('id_unit'))) {
                        $status = 'success';
                        $msg = "Data unit berikut data monitoringnya berhasil dihapus";
                    }else{
                        $status = 'error';
                        $msg = "Terjadi kesalahan saat menghapus data unit beserta data monitoringnya";
                    }
                }else{
                    $status = 'error';
                    $msg = "Terjadi kesalahan saat menghapus data unit beserta data monitoringnya";
                }
            }else{
                if ($this->model_unit->delete($this->input->post('id_unit'))) {
                    $status = 'success';
                    $msg = "Data unit berhasil dihapus";
                }else{
                    $status = 'error';
                    $msg = "Terjadi kesalahan saat menghapus data unit";
                }
            }
            $this->output->set_content_type("application/json")->set_output(json_encode(array('status'=>$status,'msg'=>$msg)));
        }
    }
    function createoutput(){
        if (!$this->input->is_ajax_request()) {
            show_404();
        }else{
            $this->form_validation->set_rules('output', 'Output', 'trim|required|xss_clean');
            $this->form_validation->set_rules('api_key', 'API key', 'trim|required|xss_clean');
            $this->form_validation->set_rules('id_unit', 'Id Unit', 'trim|required|xss_clean');
            if ($this->form_validation->run()==false) {
                $status = 'error';
                $msg = validation_errors();
            }else{
                if ($this->model_monitor->create($this->input->post('id_unit'),$this->input->post('output'),$this->input->post('api_key'))) {
                    $status = 'success';
                    $msg = 'Command berhasil disimpan';
                }else{
                    $status = 'error';
                    $msg = 'Terjadi kesalahan saat menyimpan command';
                }
            }
            $this->output->set_content_type('application/json')->set_output(json_encode(array('status'=>$status,'msg'=>$msg)));
        }
    }
    function loadmonitoring(){
        if (!$this->input->is_ajax_request()) {
            show_404();
        }else{
            $user = $this->ion_auth->user()->row();
            if ($this->model_unit->getByUser($user->id)->num_rows()==null) {
                $status = 'error';
                $msg = 'User belum membuat channel unit';
                $unit = null;
            }else{
                $status = 'success';
                $msg = 'Daftar channel unit ditemukan';
                $unit = $this->model_unit->getByUser($user->id)->result();
            }
            $this->output->set_content_type('application/json')->set_output(json_encode(array('status'=>$status,'msg'=>$msg,'unit'=>$unit)));
        }
    }
    function report(){
        if ($this->uri->segment(4)==null) {
            show_404();
        }else{
            $data = array('itemmonitor' => $this->model_monitor->getByUnitIdReport($this->uri->segment('4')),
            'itemunit'=>$this->model_unit->read($this->uri->segment('4')),
            'content'=>'member/formreport',
            'itemuser'=>$this->ion_auth->user()->row(),
            'title'=>"Report Data");
            $this->load->view('templates/template-member', $data);
        }
    }

}
