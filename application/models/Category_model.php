<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Category_model extends MY_model
{
    public function __construct()
    {
        parent::__construct();
        $this->table = 'category';
        $this->primary_key = 'category_id';
    }
}