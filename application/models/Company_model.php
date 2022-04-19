<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Company_model extends MY_Model {

    function __construct() {

        parent::__construct();
        $this->table       = 'companies';
        $this->primary_key = 'company_id';

        $this->has_many['branches'] = array('foreign_model' => 'Branch_model', 'foreign_table' => 'branch', 'foreign_key' => 'branch_company_id', 'local_key' => 'company_id');
        
    }

    public $rules = array(
        'company_name' => array(
            'field' => 'comp_name',
            'label' => 'Company Name',
            'rules' => 'required|trim',
        ),
        'company_passenger_id' => array(
            'field' => 'pass_id',
            'label' => 'Balderasu Passenger ID',
            'rules' => 'required|trim',
           
        )
       
    );

    public function get_compnay_list($id)
    {
        $query = "SELECT 
                    branch_id,
                    branch_name, 
                    company_name, 
                    branch_description, 
                    company_logo, 
                    company_cover_image,
                    branch_image,
                    company_opening_hour,
                    company_closing_hour 
                from branches 
                inner join companies 
                on companies.company_id = branches.branch_company_id 
                where branch_company_id = '$id' 
                and branch_is_active = '1'";

        $result = $this->db->query($query);
        // print_r($result); die();
        return $result->result_array();
    }

    public function get_promotion(){
        $query = "SELECT *
                    FROM ads
                    WHERE ad_start_date <= current_date AND ad_end_date >= current_date
                ";
        $result = $this->db->query($query);
        return $result->result_array();
    }
}