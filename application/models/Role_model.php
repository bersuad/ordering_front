<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Role_model extends MY_Model
{

    function __construct()
    {

        parent::__construct();
        $this->table       = 'role';
        $this->primary_key = 'role_id';

    }

    /**
     * @var array
     */
    public $rules = array(
        'role_name' => array(
            'field' => 'role_name',
            'label' => 'Role Name',
            'rules' => 'required|trim',
        ),

    );

}