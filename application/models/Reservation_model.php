<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reservation_model extends MY_Model {

    function __construct() {

        parent::__construct();
        $this->table       = 'reservation';
        $this->primary_key = 'reservation_id';

       
    }
    public $rules = array(
        'reservation_name' => array(
            'field' => 'reservation_name',
            'label' => 'Reserver Name',
            'rules' => 'required|trim',
        ),
        'reservation_phone' => array(
            'field' => 'reservation_phone',
            'label' => 'Reserver Phone',
            'rules' => 'required|trim',
        ),
       
        'reservation_time' => array(
            'field' => 'reservation_time',
            'label' => 'Reserver time',
            'rules' => 'required|trim',
        ),
        'reservation_num_people' => array(
            'field' => 'reservation_num_people',
            'label' => 'Reserver numbers',
            'rules' => 'required|trim',
        ),
        'reservation_branch' => array(
            'field' => 'reservation_branch',
            'label' => 'Reserver Phone',
            'rules' => 'required|trim',
        ),
        'reservation_message' => array(
            'field' => 'reservation_message',
            'label' => 'Reserver message',
            'rules' => 'trim',
        ),
   

    );


}