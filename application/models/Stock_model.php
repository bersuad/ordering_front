<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Stock_model extends MY_Model
{

    function __construct()
    {

        parent::__construct();
        $this->table       = 'stock';
        $this->primary_key = 'stock_id';

    }

}