<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_model extends MY_Model {

    function __construct() {

        parent::__construct();
        $this->table       = 'admin';
        $this->primary_key = 'admin_id';

        $this->has_one['vendor'] = array('foreign_model' => 'Vendor_model', 'foreign_table' => 'vendor', 'foreign_key' => 'vendor_id', 'local_key' => 'admin_vendor_id');
        $this->has_one['company'] = array('foreign_model' => 'Company_model', 'foreign_table' => 'company', 'foreign_key' => 'company_id', 'local_key' => 'admin_company_id');
    }

    /**
     * @var array
     */
    public $rules = array(
        'admin_name' => array(
            'field' => 'f_name',
            'label' => 'Full Name',
            'rules' => 'required|trim',
        ),

    );

    /**
     * @var array
     */
    public $login_rules = array(

        'admin_password' => array(
            'field' => 'password',
            'label' => 'Password',
            'rules' => 'trim|required',

        ),
    );

    /**
     * @var array
     */
    public $change_rules = array(
        'old_password' => array(
            'field'                  => 'old_password',
            'label'                  => 'Old Password',
            'rules'                  => 'required|trim|callback_valid_old_password',

        ),
        'admin_account_password' => array(
            'field' => 'password',
            'label' => 'Password',
            'rules' => 'required|trim|callback_check_password',
        ),
    );
}