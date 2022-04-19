<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Branch_model extends MY_Model
{

    function __construct()
    {

        parent::__construct();
        $this->table       = 'branches';
        $this->primary_key = 'branch_id';
        $this->has_many['company']  = array('foreign_model' => 'Company_model', 'foreign_table' => 'company', 'foreign_key' => 'company_id', 'local_key' => 'branch_company_id');

    }

    /**
     * @var array
     */
    public $rules = array(
        'branch_name' => array(
            'field' => 'branch_name',
            'label' => 'Branch Name',
            'rules' => 'required|trim|is_unique[branch.branch_name]',
        ),
        'branch_description' => array(
            'field' => 'branch_description',
            'label' => 'Branch location',
            'rules' => 'required|trim|is_unique[branch.branch_description]',
            'errors' => array(
                'required' => "Branch coordinate is required.",
                'is_unique' => 'Branch of given location exists.'
            )
        )
       
    );

    public function fetch_branch($coordinate)
    {
        $query = "SELECT
            * FROM
            branch
            WHERE 
            branch_description -> 'coordinates' = '$coordinate'";
        
        $result = $this->db->query($query);

        return $result->result_array();
    }

}