<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_monitor extends CI_Model{

    public function create($unit,$output,$apikey){
        $data = array('unit_id' => $unit,
        'output'=>$output,
        'api_key'=>$apikey,
        'monitor_created'=>date('Y-m-d H-i-s'));
        $query = $this->db->insert('monitor_client', $data);
        return $query;
    }
    public function getByUnitId($id){
        $this->db->where('unit_id', $id);
        $query = $this->db->get('monitor_client');
        return $query;
    }
    public function getByApiKey($key){
        $this->db->where('api_key', $key);
        $this->db->order_by('monitor_created','desc');
        $query = $this->db->get('monitor_client');
        return $query;
    }
    public function deleteByUnitId($id){
        $this->db->where('unit_id', $id);
        $query = $this->db->delete('monitor_client');
        return $query;
    }
    public function getLastByUnitId($unit){
        $this->db->where('unit_id', $unit);
        $this->db->limit(1);
        $this->db->order_by('id_monitor','desc');
        $query = $this->db->get('monitor_client');
        return $query;
    }
    public function getLastOrder($unit,$key){
        $this->db->where('unit_id', $unit);
        $this->db->where('api_key', $key);
        $this->db->limit(1);
        $this->db->order_by('id_monitor','desc');
        $query = $this->db->get('monitor_client');
        return $query;
    }
    function getByUnitIdReport($id){
        $this->db->where('unit_id', $id);
        $this->db->order_by('monitor_created','desc');
        $this->db->limit(200);
        $query = $this->db->get('monitor_client');
        return $query;
    }

}
