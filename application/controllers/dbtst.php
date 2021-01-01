<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class DbTST extends REST_Controller {

    function __construct($config = 'rest') {
        parent::__construct($config);
        $this->load->database();
    }

    //Menampilkan data anggota
    function index_get() {
        $id = $this->get('id');
        if ($id == '') {
            $anggota = $this->db->get('t_profile')->result();
        } else {
            $this->db->where('id', $id);
            $anggota = $this->db->get('t_profile')->result();
        }
        $this->response($anggota, 200);
    }
    //Mengirim atau menambah data anggota baru
    function index_post() {
        $data = array(
            'id'       => $this->post('id'),
            'name'     => $this->post('name'),
            'email'    => $this->post('email'),
            'birthday' => $this->post('birthday'),
            'address'   => $this->post('address'));
        $insert = $this->db->insert('t_profile', $data);
        if ($insert) {
            $this->response($data, 200);
        } else {
            $this->response(array('status' => 'fail', 502));
        }
    }
    //Memperbarui data anggota yang telah ada
    function index_put() {
        $id = $this->put('id');
        $data = array(
            'id'        => $this->put('id'),
            'name'      => $this->put('name'),
            'address'   => $this->put('address'));
        $this->db->where('id', $id);
        $update = $this->db->update('t_profile', $data);
        if ($update) {
            $this->response($data, 200);
        } else {
            $this->response(array('status' => 'fail', 502));
        }
    }
    //Menghapus salah satu data anggota
    function index_delete() {
        $id = $this->delete('id');
        $this->db->where('id', $id);
        $delete = $this->db->delete('t_profile');
        if ($delete) {
            $this->response(array('status' => 'success'), 201);
        } else {
            $this->response(array('status' => 'fail', 502));
        }
    }
}
?>