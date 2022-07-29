<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Cart extends MY_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('admin_model');
        $this->load->model('action_model');
        $this->load->model('customer_model');
        $this->load->model('company_model');
        $this->load->model('header_model');
        $this->load->model('item_model');
        $this->load->model('order_model');
        $this->load->model('permission_model');
        $this->load->model('stock_model');
        $this->load->model('transaction_model');
        $this->load->model('branch_model');
        $this->load->model('role_model');
        $this->load->model('Payment_model');
    }    
    
    public function product_cart() 
    {
        if (!empty($_POST["action"])) {
            switch ($_POST["action"]) {
            case "add":
                $item_id = $_POST["code"];
                $productByCode = $this->item_model->get_product_detail($item_id);
                $itemArray = array($productByCode[0]["item_id"] => array('name' => $productByCode[0]["item_name"], 'code' => $productByCode[0]["item_id"], 'quantity' => $_POST["quantity"], 'price' => $_POST['price_point'], 'branch' => $_POST['branch'], 'comment' => $_POST['comment'], 'extra'=> $_POST['extra'] , 'size'=> $_POST['size'], 'ori_price'=> $_POST['ori_price']));
                
                $this->cart_check($productByCode[0], $itemArray);
                                
                break;
            case "remove":
                $item_id = $_POST["code"];
                $this->remove_cart_item($item_id);
                break;
            case "empty":
                unset($_SESSION["cart_item"]);
                break;
            }
        }

        $output = $this->cart_table();
        echo ($output);
        
    }
    
    private function cart_check($productByCode, $itemArray)
    {
        
        $productByCode[0]=$productByCode;
        if (!empty($_SESSION["cart_item"])) {
            if (in_array($productByCode[0]["item_id"], $_SESSION["cart_item"])) {
                foreach ($_SESSION["cart_item"] as $kode => $value) {
                    if ($productByCode[0]["code"] == $kode) $_SESSION["cart_item"][$kode]["quantity"] = $_POST["quantity"];
                    $_SESSION["cart_item"][$kode]["price"] = ((int)$_POST["price_point"] / (int)$_POST["quantity"]);
                    // $_SESSION["cart_item"][$kode]["branch"] = $_POST["branch"];
                    $_SESSION["cart_item"][$kode]["comment"] = $_POST["comment"];
                    $_SESSION["cart_item"][$kode]["extra"] = $_POST["extra"];
                    $_SESSION["cart_item"][$kode]["ori_price"] = $_POST["ori_price"];
                    if($_POST["size"] != null || $_POST != ''){
                        $_SESSION["cart_item"][$kode]["size"] = $_POST["size"];
                    }
                }
            } else {
                $_SESSION["cart_item"] = array_merge($_SESSION["cart_item"], $itemArray);
            }
        } else {
            $_SESSION["cart_item"] = $itemArray;
        }


    }

    private function remove_cart_item($item_id){
        if (!empty($_SESSION["cart_item"])) {
            foreach ($_SESSION["cart_item"] as $kode => $value) {
                if ($item_id == $value['code']) unset($_SESSION["cart_item"][$kode]);
                if (empty($_SESSION["cart_item"])) unset($_SESSION["cart_item"]);
            }
        }
    }
    
    private function cart_table(){
        
        $restaurant_id = $this->session->userdata('restaurant_id');
        $customer = $this->company_model->where('company_id', $restaurant_id)->order_by('company_id', "desc")->get_all();
        $comp_vat = (int) $customer[0]->vat / 100 ;
        $comp_service = (int) $customer[0]->service_charge / 100;
        if (isset($_SESSION["cart_item"])) {
            $item_total = 0;
            $price_list = 0;
            $all_item = $_SESSION["cart_item"];
            $output = '<table style="border-top: 1px solid #fff;" id=\'cart_list_items\'  cellpadding=\'10\' cellspacing=\'1\' class="table striped"><tbody style="border-top: 1px solid #fff;"><tr style="border-top: 1px solid #fff;" ><th>Name</th><th>Quantity</th><th>Total Price</th><th> </th></tr>';
            foreach ($all_item as $item) {
                $output.= '<tr class="cart_item_item"><td>' . $item["name"];
                if(!empty($item['extra'])){
                    $output.='<br><small>Extra ('.$item['extra'] .')</small>';
                }
                if(!empty($item['size'] || $item['size'] != null)){
                    $output.='<br><small>Size ('.$item['size'] .')</small>';
                }
                $price_list = ((int)($item["price"]) / (int)($item["quantity"]));
                $item_total+= (int)$price_list * ((int)($item["quantity"]));
                $output.= '<input type="hidden" value="' . $item["branch"] . '" id="branch_id"/>';
                $output.= '<input type="hidden" value="' . $item["comment"] . '" id="comment"/>';
                $output.='</td><td>' . $item["quantity"] . '</td><td> ETB ' . $item["price"] . '</td><td><a onClick=\'cartAction("remove",' . $item["code"] . ')\' class="btnRemoveAction cart-action"><i style="color:rgba(183, 0, 0,0.9); font-size: 0.9em;" class="fa fa-times fa-xs"></i></a></td></tr>';
            }
            $output.= '</tbody></table><br>';
            if($comp_vat != ''){
                $output .= '<div class="" align="right"> <b>VAT: </b><span id="item_total">' . $customer[0]->vat .' %</span> &nbsp; ETB</div><br>';
                $item_total += $item_total * $comp_vat;
            }
            if($comp_service != ''){
                $output .= '<div class="" align="right"> <b>Service Charge: </b><span id="item_total">' . $customer[0]->service_charge .' %</span> &nbsp; ETB</div><br>';
                $item_total += $item_total * $comp_service;
            }
            $output .= '<div class="" align="right"> <b>Total: </b><span id="item_total">' . number_format((float)$item_total, '2', '.', '') .' </span> &nbsp; ETB</div><br>';
            $output.= '<input type="hidden" value="' . $item_total . '" id="item_total_hidden"/>';
            
            return $output;
        }
    }

    public function order_cart() {
        
        
        if (!empty($_SESSION["cart_item"])) {
            $items = [];
            foreach ( $_SESSION["cart_item"] as $value ) {
                $group[$value['branch']][] = $value;
            }

            foreach ($group as $item) {
                $order = $item;
                array_push($items, $order);
            }
            $list = [];
            $set = '123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $code = substr(str_shuffle($set), 0, 4);
            $this->session->set_userdata('code', $code);  
            foreach ($items as $value) {
                
                $items_list=[];
                foreach ($value as $key => $item) {
                    $order = array(
                        "order_item_id" => $item['code'], 
                        "extra"         => $item['extra'],
                        "comment"       => $item['comment'], 
                        "item_name"     => $item['name'], 
                        "item_price"    => $item['price'], 
                        "item_quantity" => $item['quantity'], 
                        "item_size"     => $item['size']
                    );
                    array_push($items_list, $order);
                }
                $payment = $this->input->post('order_payment');
                
                if($payment == ''){
                    $payment = 'Cash';
                }

                $order_item = array(
                                "code"                          => $code,
                                "items"                         => $items_list, 
                                "item_destination"              => $this->input->post('item_destination'), 
                                "item_destination_coordinate"   => $this->input->post('item_destination_coordinate'), 
                                "item_destination_date"         => $this->input->post('item_destination_date'), 
                                "payment_ref"                   => $payment, 
                            ); 
        
                $branch_id = $this->input->post('branch'); 
                $customer_phone = $this->input->post('user_phone');
                $customer_name = $this->input->post('user_name');
                $order_type = $this->input->post('order_type');
                $customer = $this->customer_model->where('customer_phone', $customer_phone)->order_by('customer_id', "desc")->get_all();

                if(!empty($customer))
                {
                    $customer_id = $customer[0]->customer_id;

        
                    $user_data = array(
                        'phone_no'   => $customer_phone,
                        'customer_name' => $customer[0]->customer_full_name,
                        'customer_id' => $customer[0]->customer_id,                     
                        'logged_in' => true
                    );

                    $this->session->set_userdata($user_data);
                }else{
                    $user_data = array(
                        'customer_phone' => $customer_phone,
                        'customer_full_name' => $customer_name,   
                        'customer_password' => '654321'                    
                    );

                    $customer_id = $this->customer_model->insert($user_data);
                    
                    $New_user_data = array(
                        'phone_no'   => $customer_phone,
                        'customer_name' => $customer_name,
                        'customer_id' => $customer_id,
                        'logged_in' => true
                    );
    
                    $this->session->set_userdata($New_user_data);
                }

            
                $this->load->helper('date_helper');
                $date1 = custom_date_format_parser($this->input->input_stream('item_destination_date'));
                $date2 = Date("Y-m-d H:i:s", time());
                
                $time1     = strtotime($date1);
                $time2     = strtotime($date2);
                $diff   = $time1 - $time2;
                $hours  = $diff / (60 * 60);
                
                //check if difference hour is greater than 1
                if ($hours > 1) {
                    $order_status = 6;
                }else{
                    $order_status = 0;
                }

                $result = $this->order_model->new_request($customer_id, $order_item, $order_type, $order_status, $branch_id);
                
                array_push($list, $result);
            }
            
            try {
                if ($list) {
                    unset($_SESSION["cart_item"]);
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
            echo "nothing";
        }
    }

    public function checkout() {
        $restaurant_id = $this->session->userdata('restaurant_id');
        $data['companies'] = $this->company_model->join('comapny_services', 'comapny_services.service_company_id = companies.company_id ')->join('services', 'services.id = comapny_services.service_list_id')->where(['company_id' => $restaurant_id, 'services.service_status' => 1 ])->get_all(); 
        $data['payments'] = $this->Payment_model->where(['company_payment_id'=> $restaurant_id, 'payment_status'=> 1])->order_by('payment_id', 'desc')->get_all();
        $data['branches'] = $this->branch_model->where('branch_company_id', $restaurant_id)->get_all();
        if($data['companies']){
            $this->data = $data;
    
            $this->load->view('included/header', $data);
            $this->load->view('pages/checkout');
            $this->load->view('included/footer');
        }else{
            $this->session->set_flashdata('no_service', TRUE);
            $url = 'menu/'.$this->session->userdata('menu_url');

            redirect($url, 'refresh');
        }
    }

    public function history() {
        if (!$this->session->userdata('logged_in')) {
            redirect('/all-restaurant');
        }
        
        $user_id = $this->session->userdata('customer_id');
        $data['order_list'] = $this->order_model->orders($user_id);
        $data['resturants'] = $this->company_model->order_by('company_id', "asc")->get_all();
        $data['companies'] = $this->company_model->get_all();
        $this->data = $data;
        $this->load->view('templates/header', $data);
        $this->load->view('pages/history');
        $this->load->view('templates/footer');
    }

    private function send_order_curl($data, $url) {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
        $output = curl_exec($curl);
        curl_close($curl);
        return $output;
    }

    public function order_info()
    {
        $job_status = $this->input->post('job_status');
        $order_id = $this->input->post('order_id');

        //if transaction is completed
        if ($job_status == 4) {
            $this->load->model('Transaction_model');
            //check if order exists in transaction
            $result = $this->Transaction_model->check_transaction_by_order_id($order_id);
            if($result){
                echo $order_id;exit;
            }
            //fetch total price of order
            $order = $this->Order_model->fields('order_item::json')->get($order_id);
            $items = json_decode($order->order_item)->items;
            $total_price = 0;
            foreach($items as $item){
                $total_price += $item->item_price;
            }
            $transaction = array(
                "transaction_amount" => $total_price,
                "order_id" => $order_id,
            );
            //save completed transaction
            $this->Transaction_model->insert($transaction);
        }
        echo $order_id;
    }

    public function logout() {

        session_destroy();
        $url = 'menu/'.$this->session->userdata('menu_url');

        redirect($url, 'refresh');
    }


}
        
