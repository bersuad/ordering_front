<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Permission_model extends MY_Model
{

    function __construct()
    {

        parent::__construct();
        $this->table       = 'permission';
        $this->primary_key = 'permission_id';

    }

}