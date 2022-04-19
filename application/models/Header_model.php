<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Header_model extends MY_Model
{

    function __construct()
    {

        parent::__construct();
        $this->table       = 'header';
        $this->primary_key = 'header_id';

    }

}