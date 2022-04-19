<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Item_model extends MY_Model
{

    function __construct()
    {

        parent::__construct();
        $this->table       = 'items';
        $this->primary_key = 'item_id';        
        $this->has_one['company']  = array('foreign_model' => 'Company_model', 'foreign_table' => 'company', 'foreign_key' => 'company_id', 'local_key' => 'item_company_id');
        

    }

    /**
     * @var array
     */
    public $rules = array(
        'item_name'  => array(
            'field' => 'item_name',
            'label' => 'Item Name',
            'rules' => 'required|trim',
        ),
        'item_value' => array(
            'field' => 'item_price',
            'label' => 'Item Price',
            'rules' => 'required|trim',
        ),
        'item_category' => array(
            'field' => 'category',
            'label' => 'Item Category',
            'rules' => 'required|trim',
        ),

    );
    public function get_company($id)
    {
        $query = "SELECT
                    distinct company_id, company_name, company_logo, company_cover_image, company_passenger_id,company_opening_hour,company_closing_hour
                FROM 
                    companies

                 INNER JOIN 
                    branches
                ON 
                    branches.branch_company_id=companies.company_id 
                INNER JOIN 
                    items
                ON 
                    items.item_branch_id=branches.branch_id
                WHERE
                    items.item_category = '$id' ";
        $result = $this->db->query($query);
        // print_r($result); die();
        return $result->result_array();
    }

    public function get_product_detail($id)
    {
        $query = "SELECT
			    			item_description::json, item_id, item_name, item_value
			    		FROM
			    			items
			    		where item_id=$id";

        $result = $this->db->query($query);
        // print_r($result); die();
        return $result->result_array();
    }

}