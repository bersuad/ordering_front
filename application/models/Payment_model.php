<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Payment_model extends MY_Model
{

    function __construct()
    {

        parent::__construct();
        $this->table       = 'payment';
        $this->primary_key = 'payment_id';

    }

}
