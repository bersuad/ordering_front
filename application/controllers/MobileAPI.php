<?php
defined('BASEPATH') or exit('No direct script access allowed');
class MobileAPI extends MY_Controller {
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
    }


    public function mobile_send()
    {
        $data['resturants'] = $this->company_model->order_by('company_id', "asc")->limit(6)->get_all();
        if (!empty($data['resturants'])) {
            echo json_encode($data['resturants']);
        } else {
            $message = "No resturant found";
            echo json_encode($message);
        }

    }

    public function mobile_all_company()
    {
        $data['resturants'] = $this->company_model->order_by('company_id', "asc")->get_all();
        if (!empty($data['resturants'])) {
            echo json_encode($data['resturants']);
        } else {
            $message = "No resturant found";
            echo json_encode($message);
        }
    }

    public function item_from_company($company_id)
    {
        $data['resturants'] = $this->item_model->get_company($company_id);
        if (!empty($data['resturants'])) {
            echo json_encode($data);
        } else {
            $message = "No resturant found";
            echo json_encode($message);
        }
    }

    public function list_company_item($company_id)
    {
        $data['branch_list'] = $this->company_model->get_compnay_list($company_id);
        if (!empty($data['branch_list'])) {
            echo json_encode($data);
        } else {
            $message = "No branch found";
            echo json_encode($message);
        }
    }

    public function branch_item_list($branch_id = NULL)
    {
        $sql  = "SELECT branch_id, branch_name, item_name, item_id,item_value, item_description->'image' AS image,        
            item_description->'description' AS description,item_status,company_cover_image, company_logo,company_name,company_closing_hour, company_opening_hour, item_category                    
            from items                   
            INNER JOIN branches ON items.item_branch_id = branches.branch_id                   
            INNER JOIN companies ON branches.branch_company_id = companies.company_id                   
            WHERE item_branch_id = $branch_id AND item_status = 1::bit AND item_category != 13 AND item_category !=14";
        $data['items'] = $this->item_model->sql($sql);
        $sql_extra  = "SELECT DISTINCT on (item_name) item_name, item_id,item_value, item_description->'image' AS image,
                item_description->'description' AS description,item_category
                from items
                INNER JOIN branches ON items.item_branch_id = branches.branch_id
                INNER JOIN companies ON branches.branch_company_id = companies.company_id
                WHERE branches.branch_id = $branch_id 
                AND items.item_status = 1::bit 
                AND items.item_category = 13";
        $data['extras'] = $this->item_model->sql($sql_extra);
        $sql_drink  = "SELECT DISTINCT on (item_name) item_name, item_id,item_value, item_description->'image' AS image,
                item_description->'description' AS description,item_category
                from items
                INNER JOIN branches ON items.item_branch_id = branches.branch_id
                INNER JOIN companies ON branches.branch_company_id = companies.company_id
                WHERE branches.branch_id = $branch_id 
                AND items.item_status = 1::bit
                AND items.item_category = 14";
        
        $data['drinks'] = $this->item_model->sql($sql_drink);
        $this->data = $data;

        if (!empty($data)) {
            echo json_encode($data);
        } else {
            $message = "No branch found";
            echo json_encode($message);
        }
        
    }

    public function mobile_order_history($order_id)
    {
        $data['order_list'] = $this->order_model->orders($order_id);

        if (!empty($data['order_list'])) {
            echo json_encode($data);
        } else {
            $message = "No History";
            echo json_encode($message);
        }
    }

    public function mobile_login($phone_no){
        if ($phone_no) {

            $where = [ 'customer_phone' => $phone_no,
                        'customer_is_in_blacklist' => (binary) 0
                    ];
            $user = $this->Customer_model->where($where)->get();
            
            if ($user) {
                $this->send_verification($phone_no);
            } else {              
                echo json_encode('No data');
            }
        }else{
            echo json_encode('No data');
        }
    }

    private $_verification_url = "http://192.168.0.131:13002/cgi-bin/sendsms?username=ayersms&password=pegasus&smsc=smsc1";

    public function send_verification($user_phone = NULL)
    {
        
        $user_id = $this->Customer_model->where('customer_phone',$user_phone);

        if ($user_id) {
            $this->send_verification_curl($user_phone);
        } else {
            $this->session->set_flashdata('message', 'This phone number isn\'t registered ');
            $this->session->set_flashdata('color', 'red');
        }
    }

    public function send_verification_curl($user_phone)
    {
        $code = (string) random_int(1111, 9999);
        $phone_no = $user_phone;
        
        $data = array(
            "to"   => $phone_no,
            "text" => "Your Elfegnie Verification code is {$code}",
        );

        $request_url = http_build_query($data);
        $url = $this->_verification_url . "&{$request_url}";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $output = curl_exec($ch);
        curl_close($ch);
        $this->load->model('customer_model');
        $customer = $this->customer_model->fields('customer_full_name,customer_id, customer_is_in_blacklist')->where('customer_phone',$phone_no)->get();
        $user_data = [];
        $user_data = array(
            'phone_no'   => $phone_no,
            'code' => $code,
            'customer_name' => $customer->customer_full_name,
            'customer_id' => $customer->customer_id,
            'status' => $customer->customer_is_in_blacklist,
        );
        
        echo json_encode($user_data);

    }

    public function mobile_signup()
    {
        
        $phone_no = $this->input->post('phone_no');
        $user_name = $this->input->post('name');
        
        if($phone_no){    
            $user = $this->Customer_model->where('customer_phone',$phone_no)->get();
            if ($user) {
                $this->send_verification($phone_no);
            }else{
                $phone_no;
                $user = $this->Customer_model->from_form($this->Customer_model->rules);
                
                if ($user) {
                    
                    $user->insert([
                        
                        'customer_full_name'  => $user_name,
                        'customer_phone'  => $phone_no,
                        
                        ]);                
                        $this->send_verification($phone_no);
                    } else {
                        echo json_encode($phone_no);
                    }
                }
            }
    }

    public function order_cart($order_user_id) {
        $json = file_get_contents("php://input");
        $list =  json_decode($json);
        $item_destination_date = $list->item_destination_date;
        $item_list = $list->cart; 
        // echo json_encode($item_list);
        // return;
        
        
        if (!empty($item_list)) {
            $items = [];
            // $json  = json_decode($item_list);
            foreach ( $item_list as $value ) {
                $group[$value->companyId][] = $value;
            }
            
            
            foreach ($group as $item) {
                $order = $item;
                array_push($items, $order);
            }
            
            
            
            $list = [];
            $set = '123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $code = substr(str_shuffle($set), 0, 4);
            $this->session->set_userdata('code', $code);  
            foreach ($items as $key => $value) {
                $items_list=[];
                foreach ($value as $key => $item) {
                    $order = array(
                        "order_item_id" => $item->id, 
                        "extra"         => $item->extra,
                        "comment"       => '', 
                        "item_name"     => $item->name, 
                        "item_price"    => $item->price, 
                        "item_quantity" => $item->qun,
                    );
                    array_push($items_list, $order);
                }
                $order_item = array(
                    "code"                          => $code,
                    "items"                         => $items_list, 
                    "item_destination"              => "meskel flower", 
                    "item_destination_coordinate"   => "32.0000000, 15.0000", 
                    "item_destination_date"         => $item_destination_date, 
                );                
                $branch_id = $value[$key]->companyId;
                $customer_id = $order_user_id;
                $order_type = '1';
                
                
                $this->load->helper('date_helper');
                $date1 = custom_date_format_parser($item_destination_date);
                $date2 = Date("Y-m-d H:i:s", time());
                
                $time1     = strtotime($date1);
                $time2     = strtotime($date2);
                $diff   = $time1 - $time2;
                $hours  = $diff / (60 * 60);
                
                //check if difference hour is greater than 1
                if ($item_destination_date) {
                    $order_status = 6;
                }else{
                    $order_status = 0;
                }
                
                $result = $this->order_model->new_request_mobile($customer_id, $order_item, $order_type, $order_status, $branch_id);
                
                array_push($list, $result);
            }
            
            try {
                if ($list) {
                    echo json_encode($result);
                    exit;
                } else {
                    $this->output->set_content_type('application/json')->set_status_header(500);
                    echo json_encode(array("message" => "Failed processing order!", "error" => ""));
                    exit;
                }
            }
            catch(Exception $exception) {
                $this->output->set_content_type('application/json')->set_status_header(500);
                echo json_encode(array("message" => "Failed processing order!", "error" => $exception->getMessage(),));
                exit;
            }
        } else {
            echo json_encode("nothing");
        }
    }

    public function most_sold()
    {
        
        $sql="WITH sold_items AS (
            SELECT t.order_id, UNNEST(d.item_ids) as item_ids, 
                UNNEST(d.item_quantities) as item_quantities 
            FROM   orders t, LATERAL (
            SELECT array_agg(cast(coalesce(value->>'order_item_id', '-1') as int)) AS item_ids,
                array_agg(cast(coalesce(value->>'item_quantity', '-1') as int)) AS item_quantities
            FROM   jsonb_array_elements(t.order_item->'items')  
            ) d
            ), this_sum as ( 
            SELECT SUM(item_quantities) AS quan_sum, item_ids 
                FROM sold_items
                GROUP BY item_ids
            ) SELECT items.item_branch_id,items.item_id, items.item_description->'image' as image, items.item_description->'description' as description, items.item_name, this_sum.quan_sum, items.item_value
                FROM this_sum 
            INNER JOIN items 
                ON items.item_id = this_sum.item_ids
            ORDER BY this_sum.quan_sum DESC 
            LIMIT 6";
        
        $data['sold'] = $this->item_model->sql($sql);
        if (!empty($data['sold'])) {
            echo json_encode($data['sold']);
        } else {
            $message = "No resturant found";
            echo json_encode($message);
        }

    }

    public function truck_order_for_mobile() {
        
        $item_list = [];
        $location =[];
        $user_id = $_POST['user_id'];
        $order_id = $_POST['order_id'];
        
        // $code = $this->session->userdata('code');
        
        $sql = $this->sql_query($order_id, $user_id);
        
        $orders = $this->order_model->sql($sql);
        
        foreach ($orders as $order) {
            foreach (json_decode($order->order_item)->items as $item) {
                array_push($item_list, $item);
            }
            $listLocation = json_decode($order->order_item)->item_destination;
            array_push($location, $listLocation);
        }
        $data['order_item'] = $location;
        $data['order'] = $item_list;
        $data['all_order'] = $orders;

        echo json_encode($data);

    }

    private function sql_query($order_id, $user_id)
    {
        $sql  = "   SELECT order_item::json, order_id, order_timestamp, order_customer_id, order_status, order_type,branch_name
                    FROM orders INNER JOIN branches ON orders.order_branch_id = branches.branch_id 
                    WHERE orders.order_id  = $order_id AND orders.order_customer_id = $user_id;
                ";

        return $sql;
    }

}