<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customer_model extends MY_Model {

    function __construct() {
        $this->has_many['orders'] = array('foreign_model' => 'Order_model', 'foreign_table' => 'orders', 'foreign_key' => 'customer_id', 'local_key' => 'customer_id');
        parent::__construct();
        $this->table       = 'customers';
        $this->primary_key = 'customer_id';
    }

    /**
     * @var array
     */
    public $rules = array(
        'customer_full_name' => array(
            'field' => 'name',
            'label' => 'Full Name',
            'rules' => 'required|trim',
        ),
        'customer_phone'     => array(
            'field' => 'phone_no',
            'label' => 'phone Number',
            'rules' => 'required|trim',
        ),
        // 'customer_password'  => array(
        //     'field' => 'password',
        //     'label' => 'Password',
        //     'rules' => 'required|trim',
        // ),

    );

}