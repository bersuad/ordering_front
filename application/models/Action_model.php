<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Action_model extends MY_Model
{

    function __construct()
    {
        // $this->_database_connection = 'ayer';

        parent::__construct();
        $this->table       = 'action';
        $this->primary_key = 'action_id';

    }

}