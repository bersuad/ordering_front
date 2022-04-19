<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transaction_model extends MY_Model
{

    function __construct()
    {

        parent::__construct();
        $this->table       = 'transaction';
        $this->primary_key = 'transaction_id';
    }

}