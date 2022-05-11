<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pages extends MY_Controller {

	public function __construct() {
        parent::__construct();
        $this->load->model('admin_model');
        $this->load->model('action_model');
        $this->load->model('customer_model');
        $this->load->model('Customer_model');
        $this->load->model('company_model');
        $this->load->model('header_model');
        $this->load->model('item_model');
        $this->load->model('order_model');
        $this->load->model('permission_model');
        $this->load->model('stock_model');
        $this->load->model('transaction_model');
        $this->load->model('branch_model');
        $this->load->model('role_model');
		$this->load->model('Category_model');
		$this->load->model('reservation_model');
		$this->load->model('Payment_model');
    }
	

	public function index($url_name)
	{
		$company = $this->company_model->where('url_name',$url_name)->get_all();
		if(empty($company)){
			echo "no page";
		}else{

			$restaurant_id = $company[0]->company_id;
			$this->session->set_userdata('restaurant_id', $restaurant_id);
			$this->session->set_userdata('menu_url', $url_name);
	
			$sql  = "SELECT DISTINCT on (item_name) item_name, item_id,item_value, item_description->'image' AS image,
					item_description->'description' AS description,company_cover_image, company_logo,company_name, company_opening_hour, company_closing_hour, item_category, category_name, extra_list, item_size
					from items
					INNER JOIN category ON category.category_id = items.item_category
					INNER JOIN branches ON items.item_branch_id = branches.branch_id
					INNER JOIN companies ON branches.branch_company_id = companies.company_id
					WHERE company_id = $restaurant_id 
					AND items.item_category != 13";
			$data['items'] = $this->item_model->sql($sql);
	
			$sql_extra  = "SELECT DISTINCT on (item_name) item_name, item_id,item_value, item_description->'image' AS image,
					item_description->'description' AS description,item_category
					from items
					INNER JOIN branches ON items.item_branch_id = branches.branch_id
					INNER JOIN companies ON branches.branch_company_id = companies.company_id
					WHERE company_id = $restaurant_id 
					AND items.item_status =  1::bit 
					AND items.item_category = 13";
			$data['extras'] = $this->item_model->sql($sql_extra);
	
			$sql_drink  = "SELECT DISTINCT on (item_name) item_name, item_id,item_value, item_description->'image' AS image,
					item_description->'description' AS description,item_category
					from items
					INNER JOIN branches ON items.item_branch_id = branches.branch_id
					INNER JOIN companies ON branches.branch_company_id = companies.company_id
					WHERE company_id = $restaurant_id  
					AND items.item_status = 1::bit
					AND items.item_category = 14";
			
			$data['drinks'] = $this->item_model->sql($sql_drink);
			
			$data['companies'] = $this->company_model->where('company_id', $restaurant_id)->get_all();
	
			// $sql_category ="SELECT category_name
			// 			FROM category
			// 			RIGHT JOIN items ON items.item_category = category.category_id
			// 			INNER JOIN branches ON items.item_branch_id = branches.branch_id
			// 			INNER JOIN companies ON branches.branch_company_id = companies.company_id
			// 			WHERE company_id = $restaurant_id 
			// 			AND category_status = 1
			// 			AND category_name != 'Extra' 
			// 			GROUP BY category_name
			// 			";
			
			// $data['category_list'] 	= $this->Category_model->sql($sql_category);
			$data['category_list']  = $this->Category_model->where(['category_company_id'=>$restaurant_id, 'category_status' => 1 ] )->get_all();
	
			$this->data = $data;
			
			$this->load->view('included/header', $this->data );
			$this->load->view('pages/index');
			$this->load->view('included/footer');

		}
	}

	public function reservation()
	{
		$restaurant_id = $this->session->userdata('restaurant_id');
		$sql  = "SELECT DISTINCT on (item_name) item_name, item_id,item_value, item_description->'image' AS image,
				item_description->'description' AS description,company_cover_image, company_logo,company_name, company_opening_hour, company_closing_hour, item_category
				from items
				INNER JOIN branches ON items.item_branch_id = branches.branch_id
				INNER JOIN companies ON branches.branch_company_id = companies.company_id
				WHERE company_id = $restaurant_id";
		$data['items'] = $this->item_model->sql($sql);
		$sql_extra  = "SELECT DISTINCT on (item_name) item_name, item_id,item_value, item_description->'image' AS image,
				item_description->'description' AS description,item_category
				from items
				INNER JOIN branches ON items.item_branch_id = branches.branch_id
				INNER JOIN companies ON branches.branch_company_id = companies.company_id
				WHERE company_id = $restaurant_id 
				AND items.item_status =  1::bit 
				AND items.item_category = 13";
		$data['extras'] = $this->item_model->sql($sql_extra);
		$sql_drink  = "SELECT DISTINCT on (item_name) item_name, item_id,item_value, item_description->'image' AS image,
				item_description->'description' AS description,item_category
				from items
				INNER JOIN branches ON items.item_branch_id = branches.branch_id
				INNER JOIN companies ON branches.branch_company_id = companies.company_id
				WHERE company_id = $restaurant_id  
				AND items.item_status = 1::bit
				AND items.item_category = 14";


		$data['branches'] = $this->branch_model->where(['branch_company_id' => $restaurant_id])->get_all();
		$data['drinks'] = $this->item_model->sql($sql_drink);
		$data['companies'] = $this->company_model->where('company_id', $restaurant_id)->get_all();

		$this->data = $data;

		$this->load->view('included/header', $this->data);
		$this->load->view('pages/reservation');
		$this->load->view('included/footer');
	}

	public function addReservation()
	{
		$name		= $this->input->post('reservation_name');
		$phone_no 	= $this->input->post('reservation_phone');
		$date		= $this->input->post('reservation_date');
		$time		= $this->input->post('reservation_time');
		$num_people	= $this->input->post('reservation_num_people');
		$branch		= $this->input->post('reservation_branch');
		$message	= $this->input->post('reservation_message');

		if ($phone_no) {
				$reservation = array(
					'reservation_name' => $name,
					'reservation_phone' => $phone_no,
					'reservation_time'=> $time,
					'reservation_date' => $date,
					'reservation_num_people'=>$num_people,
					'reservation_branch'=> $branch,
					'reservation_message'=> $message
				);	
				
				$result = $this->reservation_model->insert($reservation);


				$this->session->set_flashdata('reservation_added', TRUE);

				redirect('index.php/pages/reservation', 'refresh');

		}

	
	}

	public function order_history()
	{
		$restaurant_id = $this->session->userdata('restaurant_id');
		$sql  = "SELECT DISTINCT on (item_name) item_name, item_id,item_value, item_description->'image' AS image,
				item_description->'description' AS description,company_cover_image, company_logo,company_name, company_opening_hour, company_closing_hour, item_category
				from items
				INNER JOIN branches ON items.item_branch_id = branches.branch_id
				INNER JOIN companies ON branches.branch_company_id = companies.company_id
				WHERE company_id = $restaurant_id";
		$data['items'] = $this->item_model->sql($sql);
		$sql_extra  = "SELECT DISTINCT on (item_name) item_name, item_id,item_value, item_description->'image' AS image,
				item_description->'description' AS description,item_category
				from items
				INNER JOIN branches ON items.item_branch_id = branches.branch_id
				INNER JOIN companies ON branches.branch_company_id = companies.company_id
				WHERE company_id = $restaurant_id 
				AND items.item_status =  1::bit 
				AND items.item_category = 13";
		$data['extras'] = $this->item_model->sql($sql_extra);
		$sql_drink  = "SELECT DISTINCT on (item_name) item_name, item_id,item_value, item_description->'image' AS image,
				item_description->'description' AS description,item_category
				from items
				INNER JOIN branches ON items.item_branch_id = branches.branch_id
				INNER JOIN companies ON branches.branch_company_id = companies.company_id
				WHERE company_id = $restaurant_id  
				AND items.item_status = 1::bit
				AND items.item_category = 14";
		
		$data['drinks'] = $this->item_model->sql($sql_drink);
		$data['companies'] = $this->company_model->where('company_id', $restaurant_id)->get_all();
		$this->data = $data;
		
		$this->load->view('included/header', $data);
		$this->load->view('pages/order_history');
		$this->load->view('included/footer');
	}


	public function order_view($order_id) 
	{
		$restaurant_id = $this->session->userdata('restaurant_id');
		$order = $this->order_model->fields("order_item, order_id, order_timestamp, order_customer_id, order_status")->get($order_id);
		if (!$order) {
			redirect('checkout');
		}
		$data['order']= $order;
		$data['companies'] = $this->company_model->where('company_id', $restaurant_id)->get_all();
		$data['job_id'] = property_exists(json_decode($order->order_item), "job_id") ? json_decode($order->order_item)->job_id : "";
		$data['request_id'] = $order->order_id;
		$order_code = json_decode($order->order_item)->code;
		// print_r($order_code); die();
		$this->session->set_userdata('code', $order_code);
		$this->data = $data;
		
	
		$this->load->view('included/header', $this->data);
		$this->load->view('pages/order_track');
		$this->load->view('included/footer');
	}

	public function history() {
        $restaurant_id = $this->session->userdata('restaurant_id');
        $user_id = $this->session->userdata('customer_id');
		$sql  = "SELECT DISTINCT on (item_name) item_name, item_id,item_value, item_description->'image' AS image,
				item_description->'description' AS description,company_cover_image, company_logo,company_name, company_opening_hour, company_closing_hour, item_category
				from items
				INNER JOIN branches ON items.item_branch_id = branches.branch_id
				INNER JOIN companies ON branches.branch_company_id = companies.company_id
				WHERE company_id = $restaurant_id";
		$data['companies'] = $this->company_model->where('company_id', $restaurant_id)->get_all();
        
        $data['order_list'] = $this->order_model->orders($user_id);
        $data['resturants'] = $this->company_model->order_by('company_id', "asc")->get_all();
		$data['items'] = $this->item_model->sql($sql);
        $this->data = $data;
		// print_r($data['order_list']); die();
        $this->load->view('included/header', $this->data);
        $this->load->view('pages/order_history');
        $this->load->view('included/footer');
    }
}
