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
			$this->no_page();
		}else{

			$restaurant_id = $company[0]->company_id;
			$this->session->set_userdata('restaurant_id', $restaurant_id);
			$this->session->set_userdata('menu_url', $url_name);
	
			$sql  = "SELECT DISTINCT on (item_name) item_name, item_id,item_value, item_description->'image' AS image,
					item_description->'description' AS description,company_cover_image, company_logo,company_name, company_opening_hour, company_closing_hour, item_category, category_name, extra_list, item_size, group_list
					from items
					INNER JOIN category ON category.category_id = items.item_category
					INNER JOIN branches ON items.item_branch_id = branches.branch_id
					INNER JOIN companies ON branches.branch_company_id = companies.company_id
					WHERE company_id = $restaurant_id 
					AND companies.company_status = 1
					AND items.item_category != 13";
			$data['items'] = $this->item_model->sql($sql);
			
			$data['companies'] = $this->company_model->where(['company_id' => $restaurant_id, 'company_status' => 1])->get_all();
	
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

	public function reservation_list($url_name)
	{
		$company = $this->company_model->where('url_name',$url_name)->get_all();

		if(empty($company)){
			$this->no_page();
		}else{

			$restaurant_id = $company[0]->company_id;

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

	public function getFood()
	{
		$items_list = 0;
		$restaurant_id = $this->session->userdata('restaurant_id');
		$output = '';
		$input  = ucfirst($_POST['search']);
		$image_url = $_POST['admin_url'];
		$sql  = "SELECT DISTINCT on (item_name) item_name, item_id,item_value, item_description->'image' AS image,
					item_description->'description' AS description,company_cover_image, company_logo,company_name, company_opening_hour, company_closing_hour, item_category, category_name, extra_list, item_size
					from items
					INNER JOIN category ON category.category_id = items.item_category
					INNER JOIN branches ON items.item_branch_id = branches.branch_id
					INNER JOIN companies ON branches.branch_company_id = companies.company_id
					WHERE company_id = $restaurant_id
					AND UPPER(item_name) LIKE UPPER('%{$input}%')
				";

		$items = $this->item_model->sql($sql);

		$items_list = count($items);
		if(!empty($items)){
			foreach($items as $key => $item){
				$output .= '<div class="col-sm-6 col-md-4 col-lg-4 col-xs-6 list-of-items">';
				$output .= '<a href="#" data-toggle="modal" data-target="#modalQuickView'.$item->item_id .'" id="add_to_cart block fancybox" class="to_cart" data-name="'.$item->item_name.'" data-price="'.$item->item_value.'" data-desc="$detail" data-image="$photo" data-id="'.$item->item_id.'">';
				$output .= '<div class="content">
								<div class="filter_item_img">
									<i class="fa fa-search-plus"></i>';
				if($item->image != 'uploads/'){
					$output .= '<img src="'.$image_url.$item->image .'" alt="food image" />';
				}else{
					$output .= '<img src="'.base_url().'assets/img/eat.png" alt="placeholder" />';
				}
				$output .= '</div>
							<div class="info">
								<div class="name">'.$item->item_name.'</div>
								<span class="filter_item_price">Br. '.$item->item_value.' </span>
							</div>';
				$output	.= '</div>
					</a>';
				echo $output .= '</div>';
				if($key == $items_list){
					return;
				}
					$key++;
			}
		}else{
			$output .="<h5>Sorry, No food found!</h5>";
		}
		echo $output;

	}

	public function no_page()
	{
		$data['companies'] = $this->company_model->where(['company_status' => 1])->get_all();
		// print_r($data); die();
		$this->load->view('pages/404', $data);
	}


	public function login()
	{
		// print_r($_POST);

		if ($this->input->post('phone_no')) {
            $phone_no = $this->input->post('phone_no');
            $url = $this->input->post('url');
            $where = array( 'customer_phone' => $phone_no);
            $user = $this->Customer_model->where($where)->get();

            $this->session->set_userdata('page_url', $url);
            
            $user_info = $user->customer_is_in_blacklist;
            
            if($user_info == 1){
                unset($_SESSION["phone_no"]);
                
				redirect($url);
            }else{
                $this->sms_send($phone_no);
            }
            
        }

	}

	public function verify_page()
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
		$this->load->view('pages/verification');
		$this->load->view('included/footer');
	}

	public function verify()
	{
		$home = base_url('menu/'.$this->session->userdata('menu_url'));

        $url = $this->session->userdata('page_url');

		$code =  $this->session->userdata('code');
		$v_code = $this->input->post('reservation_name');

        if ($v_code == $code) {
            $this->session->set_userdata('logged_in', true);
            header('Location:'.$home);            
        } else {
			$this->session->set_userdata('logged_in', false);
            redirect('/'.$url);
        }
	}

	public function sms_send($phone)
	{
		$phone_no = $phone;

		$user_id = $this->Customer_model->where('customer_phone',$phone_no);
		
		if ($user_id) {
            $phone_no = str_replace('-', '', $phone_no);
				
			if (strpos($phone_no, "2519") 			=== 0) {
				$phone_no = str_replace('251', '', $phone_no);
			} else if (strpos($phone_no, "09") 		=== 0) {
				$phone_no = str_replace('0', '', $phone_no);
			} else if (strpos($phone_no, "+2519") 	=== 0) {
				$phone_no = str_replace('+251', '', $phone_no);
			}


			$phone_no = "251".$phone_no;

			$code = (string) random_int(1111, 9999);
			$curl = curl_init();

			curl_setopt_array($curl, array(
			CURLOPT_URL => 'https://api.geezsms.com/api/v1/sms/send',
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'POST',
			CURLOPT_POSTFIELDS => array('token' => 'izX1mlRIMqJQAjjIYondSwTtvBv3JxjA','phone' => $phone_no,'msg' => 'Your QRAnbessa Orderring Verification Code is '.$code.'. Please add this code to verify you. Thank you!'),
			));

			$response = curl_exec($curl);

			curl_close($curl);
			$customer = $this->customer_model->fields('customer_full_name,customer_id')->where('customer_phone',$phone)->get();
			
			$user_data = array(
				'phone_no'   => $phone_no,
				'code' => $code,
				'customer_name' => $customer->customer_full_name,
				'customer_id' => $customer->customer_id
	
			);
	
			$this->session->set_userdata($user_data);
			redirect('pages/verify_page');

        } else {
            $this->session->set_flashdata('message', 'This phone number isn\'t registered ');
            $this->session->set_flashdata('color', 'red');
            echo $this->session->flashdata('message');

			$url = $this->session->userdata('page_url');
            redirect($url);
        }

	}
}
