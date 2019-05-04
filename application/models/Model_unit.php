<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_unit extends CI_Model{

    public function create($unit, $user,$api,$status){
        $data = array('unit'=>$unit,
        'user_id'=>$user,
        'api_key'=>$api,
        'status'=>$status,
        'unit_create'=>date('Y-m-d H-i-s'),
        'unit_update'=>date('Y-m-d H-i-s'));
        $query = $this->db->insert('unit_client', $data);
        return $query;
    }
    public function update($id_unit, $unit,$status){
        $data = array('unit'=>$unit,
        'status'=>$status,
        'unit_update'=>date('Y-m-d H-i-s'));
        $this->db->where('id_unit', $id_unit);
        $query = $this->db->update('unit_client', $data);
        return $query;
    }
    public function read($id){
        $this->db->where('id_unit', $id);
        $query = $this->db->get('unit_client');
        return $query;
    }
    public function verifyUnit($id,$apikey){//,$apikey
        $this->db->where('id_unit', $id);
        $this->db->where('api_key', $apikey);
        $query = $this->db->get('unit_client');
        return $query;
    }
    public function getAll(){
        $query = $this->db->get('unit_client');
        return $query;
    }
    public function getByUser($user){
        $this->db->where('user_id', $user);
        $query = $this->db->get('unit_client');
        return $query;
    }
    public function getMonitorByUnit($id){
        $this->db->select('*');
        $this->db->from('monitor_client');
        $this->db->where('unit_id', $id);
        $this->db->limit('100');
        $this->db->order_by('id_monitor','desc');
        $this->db->join('unit_client', 'unit_client.id_unit = monitor_client.unit_id');
        $query = $this->db->get('');
        return $query;
    }
    public function delete($id){
        $this->db->where('id_unit', $id);
        $query = $this->db->delete('unit_client');
        return $query;
    }

}
