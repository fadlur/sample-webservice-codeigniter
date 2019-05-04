<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';//lokasi library rest

class Monitoring extends REST_Controller{
    public function __construct(){
      parent::__construct();
      $this->load->model(array('model_monitor',
        'model_unit'));
    }

    function unit_get(){
        //$data = array('respon : '.$this->get('id'));
        if($this->get('id')!=null){
            if($this->model_monitor->getLastOrder($this->get('id'),$this->get('key'))->num_rows()!=null){
                foreach ($this->model_monitor->getLastOrder($this->get('id'),$this->get('key'))->result() as $unit) {
                    $data = array($unit->output);
                    $this->response($data);
                }
            }else{
                $this->response([
                    'status' => FALSE,
                    'message' => 'No order found',
                    'output' => null
                ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
            }
        }
    }
    function unit_put(){
        if ($this->model_unit->verifyUnit($this->put('id'),$this->put('key'))->num_rows()==null) {//
            $this->set_response(array('status'=>'error'));
        }else{
            $intruksi = $this->model_monitor->create($this->put('id'),$this->put('output'),$this->put('key'));
            if ($intruksi==FALSE) {
                $this->set_response(array('status'=>'error'));
            }else{
                $this->set_response(REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            }
        }
    }
    function unit_post(){
        $data = array('respon : '.$this->post('id'));
        $this->response($data);
    }
    function unit_delete(){
        $data = array('respon : '.$this->delete('id'));
        $this->response($data);
    }

}
