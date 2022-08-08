<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Order extends MY_Controller {
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
        
        $restaurant_id = $this->session->userdata('restaurant_id');
        $customer = $this->company_model->where('company_id', $restaurant_id)->order_by('company_id', "desc")->get_all();
        $comp_vat = (int) $customer[0]->vat / 100 ;
        $comp_service = (int) $customer[0]->service_charge / 100;
    }

    public function truck_order_for_mobile() {

        $order_id = $this->input->post('id');
        $user_id = $this->session->userdata('customer_id');
        $output = '';
        

        $sql = $this->sql_query($order_id, $user_id);
        
        $orders = $this->order_model->sql($sql);

        $output .= '
            <div align="center" style="width: 100%; margin-left: 5%; background:#f2f2f2!important; border-radius: 10px;"></div>
            <article style="font-size: 1em; color: #212121;">
            <h4 align="center"> Your Order Status</h4>
            <h5 align="center"> Order ID <b>'.$order_id.'</b></h5>
        ';

        foreach ($orders as $order) {

            $branch = $order->branch_name;
            $job_id = property_exists(json_decode($order->order_item), "job_id") ? json_decode($order->order_item)->job_id : "";
            $output.= '
                <input type="hidden" name="" id="job_id" value="' . $job_id . '">';
            if ($order->order_status == 0) {

                $output = $this->new_order($order, $branch, $output);
                
            } else if ($order->order_status == 1) {

                $output = $this->order_accept($order, $branch, $output);

            } else if ($order->order_status == 2) {

                $output = $this->order_wait($order, $branch, $output);    

            } else if ($order->order_status == 3) {

                $output = $this->order_onway($order, $branch, $output);
                
            } else if ($order->order_status == 4) {
                
                $output = $this->order_delivered($order, $branch, $output);                
                
            } else if ($order->order_status == 5) {
                
                $output = $this->order_cancled($order, $branch, $output);
                
            } else {

                $output = $this->order_scheduled($order, $branch, $output);

            }

        }
        $output.= '</article>';

        echo json_encode($output);
                
    }

    private function sql_query($order_id, $user_id)
    {
        
            $sql  = "   SELECT order_item::json, order_id, order_timestamp, order_customer_id, order_status, order_type,branch_name
                        FROM orders INNER JOIN branches ON orders.order_branch_id = branches.branch_id 
                        WHERE orders.order_id  = $order_id AND orders.order_customer_id = $user_id;
                    ";
        

        return $sql;
    }
    
    
    public function new_order($order, $branch, $output){
        $restaurant_id = $this->session->userdata('restaurant_id');
        $customer = $this->company_model->where('company_id', $restaurant_id)->order_by('company_id', "desc")->get_all();
        $comp_vat = (int) $customer[0]->vat / 100 ;
        $comp_service = (int) $customer[0]->service_charge / 100;
        $service = 0;
        $output.= '
            <table class="table table-borderless" style="align-items: center; align-self: center; text-align: center; border: 2px solid transparent; color:#212121; font-size: 0.9em;" id="cart_list_items">
                <thead>
                    <tr>
                        <th style="text-align: center; font-weight: bold;">Item</th>
                        <th style="text-align: center; font-weight: bold;">Qty</th>
                        <th style="text-align: center; font-weight: bold;">Price (ETB)</th>
                    </tr>
                </thead>
                <tbody>
                    ';
                    foreach (json_decode($order->order_item)->items as $item) {
                        $size = '';
                        $choose = '';
                        if($item->item_size != ''){
                            $size = 'Size: ('.$item->item_size.')';
                        }
                        if($item->choose != ''){
                            $choose = 'Choose: ('.$item->choose.')';
                        }
                    if (!empty($item->extra)) {
                        $output.= ' 
                            <tr>
                                <td>' . $item->item_name. ' <br/>Extra: ('.$item->extra.')<br/>'.$size.'<br/>'.$choose.'</td>
                                <td>' . $item->item_quantity . '</td>
                                <td>' . number_format((int)$item->item_price, 2, '.', '') . '</td>
                            </tr>
                        ';
                        }else{
                        $output.= ' 
                            <tr>
                                <td>' . $item->item_name .'<br/>'.$size.'<br/>'.$choose.'</td>
                                <td>' . $item->item_quantity . '</td>
                                <td>' . number_format((int)$item->item_price, 2, '.', '') . '</td>
                            </tr>
                            ';
                        }
                    }
                    $output.= '  
                    <tr>
                        <td></td>
                        <td>VAT</td>
                        <td>'.$customer[0]->vat.' %</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>Service Charge</td>
                        <td>'.$customer[0]->service_charge.' %</td>
                    </tr>
                    <tr style="background: rgba(201, 201, 201, 0.3);">
                        <td></td>
                        <td>Total Price</td>
                        <td>';
                        $sum = 0;
                        $price_list = 0;
                        $vat = 0;
                        foreach (json_decode($order->order_item)->items as $item) {
                            $price_list = (int)$item->item_price / (int)$item->item_quantity;
                            $sum+= (int)$price_list * (int)$item->item_quantity;
                            $total=$sum;
                        }
                        
                        if($comp_vat != ''){
                            $vat = $sum * $comp_vat;
                        }
                        if($comp_service != ''){

                            $service = $sum * $comp_service;
                        }
                        $sum += $vat + $service; 
                        $output.= '' . number_format((float)$sum, '2', '.', '').' ETB';
                        $output.= '
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td> Ordered From</td>
                        <td>'.$branch.'</td>
                    </tr>
                </tbody>
            </table>
            ';
        $output.= '
            <h5 style="color: rgba(216, 148, 0, 0.9); font-size: 1.2em!important; font-weight: bold;" align="center"> Your order has been sent </h5>
        ';
        if ($order->order_type == 1) {
            $output.= '
                <h5 style="font-size: 1em!important;" align="center"> Please give the restaurant a few minutes to accept your order.</h5>
            ';
        } else {
            $output.= '
                <h5 style="font-size: 1.2em!important;" align="center">We will update your order status here.</h5>
            ';
        }

        return $output;
    }

    public function order_accept($order, $branch, $output)
    {
        $restaurant_id = $this->session->userdata('restaurant_id');
        $customer = $this->company_model->where('company_id', $restaurant_id)->order_by('company_id', "desc")->get_all();
        $comp_vat = (int) $customer[0]->vat / 100 ;
        $comp_service = (int) $customer[0]->service_charge / 100;
        $service = 0;
        $output.= '
            <table class="table table-borderless" style="align-items: center; align-self: center; text-align: center; border: 2px solid transparent; color:#212121; font-size: 0.9em;" id="cart_list_items">
                <thead>
                    <tr>    
                        <th style="text-align: center; font-weight: bold;">Item</th>
                        <th style="text-align: center; font-weight: bold;">Qty</th>
                        <th style="text-align: center; font-weight: bold;">Price (ETB)</th>
                    </tr>
                </thead>
                <tbody>
                    ';
                    foreach (json_decode($order->order_item)->items as $item) {
                        $size = '';
                        $choose = '';
                        if($item->item_size != ''){
                            $size = 'Size: ('.$item->item_size.')';
                        }
                        if($item->choose != ''){
                            $choose = 'Choose: ('.$item->choose.')';
                        }
                    if (!empty($item->extra)) {
                    $output.= ' 
                    <tr>
                        <td>' . $item->item_name. ' <br/>Extra: ('.$item->extra.')<br/>'.$size.'<br/>'.$choose.'</td>
                        <td>' . $item->item_quantity . '</td>
                        <td>' . number_format((int)$item->item_price, 2, '.', '') . '</td>
                    </tr>
                    ';
                    }else{
                    $output.= ' 
                    <tr>
                        <td>' . $item->item_name .'<br/>'.$size.'<br/>'.$choose.'</td>
                        <td>' . $item->item_quantity . '</td>
                        <td>' . number_format((int)$item->item_price, 2, '.', '') . '</td>
                    </tr>
                    ';
                    }
                    }
                    $output.= '  
                    <tr>
                        <td></td>
                        <td>VAT</td>
                        <td>'.$customer[0]->vat.' %</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>Service Charge</td>
                        <td>'.$customer[0]->service_charge.' %</td>
                    </tr>
                    <tr style="background: rgba(201, 201, 201, 0.3);">
                        <td></td>
                        <td>Total Price</td>
                        <td>';
                        $sum = 0;
                        $price_list = 0;
                        $vat = 0;
                        foreach (json_decode($order->order_item)->items as $item) {
                            $price_list = (int)$item->item_price / (int)$item->item_quantity;
                            $sum+= (int)$price_list * (int)$item->item_quantity;
                            $total=$sum;
                        }
                        
                        if($comp_vat != ''){
                            $vat = $sum * $comp_vat;
                        }
                        if($comp_service != ''){

                            $service = $sum * $comp_service;
                        }
                        $sum += $vat + $service; 
                        $output.= '' . number_format((float)$sum, '2', '.', '').' ETB';
                        $output.= '
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td> Ordered From</td>
                        <td>'.$branch.'</td>
                    </tr>
                </tbody>
            </table>
        ';
        $output.= '
            <h5 align="center" style="color: rgba(216, 148, 0, 0.9); font-size: 1.2em!important; font-weight: bold;"> Your order is began proccessed.</h5>
        ';
        return $output;
    }

    public function order_wait($order, $branch, $output)
    {
        $restaurant_id = $this->session->userdata('restaurant_id');
        $customer = $this->company_model->where('company_id', $restaurant_id)->order_by('company_id', "desc")->get_all();
        $comp_vat = (int) $customer[0]->vat / 100 ;
        $comp_service = (int) $customer[0]->service_charge / 100;
        $service = 0;
        $output.= '
            <table class="table table-borderless" style="align-items: center; align-self: center; text-align: center; border: 2px solid transparent; color:#212121; font-size: 0.9em;" id="cart_list_items">
                <thead>
                    <tr>
                        <th style="text-align: center; font-weight: bold;">Item</th>
                        <th style="text-align: center; font-weight: bold;">Qty</th>
                        <th style="text-align: center; font-weight: bold;">Price (ETB)</th>
                    </tr>
                </thead>
                <tbody>
                    ';
                    foreach (json_decode($order->order_item)->items as $item) {
                        $size = '';
                        $choose = '';
                        
                        if($item->item_size != ''){
                            $size = 'Size: ('.$item->item_size.')';
                        }
                        
                        if( !empty($item->choose) && $item->choose != '' ){
                            $choose = 'Choose: ('.$item->choose.')';
                        }

                    if (!empty($item->extra)) {
                    $output.= ' 
                    <tr>
                        <td>' . $item->item_name. ' <br/>Extra: ('.$item->extra.')<br/>'.$size.'<br/>'.$choose.'</td>
                        <td>' . $item->item_quantity . '</td>
                        <td>' . number_format((int)$item->item_price, 2, '.', '') . '</td>
                    </tr>
                    ';
                    }else{
                    $output.= ' 
                    <tr>
                        <td>' . $item->item_name .'<br/>'.$size.'<br/>'.$choose.'</td>
                        <td>' . $item->item_quantity . '</td>
                        <td>' . number_format((int)$item->item_price, 2, '.', '') . '</td>
                    </tr>
                    ';
                    }
                    }
                    $output.= '  
                    <tr>
                        <td></td>
                        <td>VAT</td>
                        <td>'.$customer[0]->vat.' %</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>Service Charge</td>
                        <td>'.$customer[0]->service_charge.' %</td>
                    </tr>
                    <tr style="background: rgba(201, 201, 201, 0.3);">
                        <td></td>
                        <td>Total Price</td>
                        <td>';
                        $sum = 0;
                        $price_list = 0;
                        $vat = 0;
                        foreach (json_decode($order->order_item)->items as $item) {
                            $price_list = (int)$item->item_price / (int)$item->item_quantity;
                            $sum+= (int)$price_list * (int)$item->item_quantity;
                            $total=$sum;
                        }
                        
                        if($comp_vat != ''){
                            $vat = $sum * $comp_vat;
                        }
                        if($comp_service != ''){

                            $service = $sum * $comp_service;
                        }
                        $sum += $vat + $service; 
                        $output.= '' . number_format((float)$sum, '2', '.', '').' ETB';
                        $output.= '
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td> Ordered From</td>
                        <td>'.$branch.'</td>
                    </tr>
                </tbody>
            </table>
        ';
        if ($order->order_type == 1) {
            $output.= '
                <h5 style="color: rgba(216, 148, 0, 0.9); font-size: 1.2em!important; font-weight: bold;" align="center"> Your order is began processed, give us a moment.</h5>
            ';
        } else {
            $output.= '
                <h5 style="color: #087c02; font-size: 1.2em!important; font-weight: bold;" align="center">
                Order completed ! When You arrive at
                <h5 style="color: #087c02; font-size: 1em!important; font-weight: bold;" align="center">' . json_decode($order->order_item)->item_destination . ' branch, Ask for order N<sup><u>o</u></sup> " <i></i> "</h5>
            ';
        }
        return $output;
    }

    public function order_onway($order, $branch, $output)
    {
        $restaurant_id = $this->session->userdata('restaurant_id');
        $customer = $this->company_model->where('company_id', $restaurant_id)->order_by('company_id', "desc")->get_all();
        $comp_vat = (int) $customer[0]->vat / 100 ;
        $comp_service = (int) $customer[0]->service_charge / 100;
        $service = 0;
        $output.= '
            <table class="table table-borderless" style="align-items: center; align-self: center; text-align: center; border: 2px solid transparent; color:#212121; font-size: 0.9em;" id="cart_list_items">
                <thead>
                    <tr>
                        <th style="text-align: center; font-weight: bold;">Item</th>
                        <th style="text-align: center; font-weight: bold;">Qty</th>
                        <th style="text-align: center; font-weight: bold;">Price (ETB)</th>
                    </tr>
                </thead>
                <tbody>
                    ';
                    foreach (json_decode($order->order_item)->items as $item) {
                        $size = '';
                        $choose = '';
                        if($item->item_size != ''){
                            $size = 'Size: ('.$item->item_size.')';
                        }
                        if($item->choose != ''){
                            $choose = 'Choose: ('.$item->choose.')';
                        }
                    if (!empty($item->extra)) {
                    $output.= ' 
                    <tr>
                        <td>' . $item->item_name. ' <br/>Extra: ('.$item->extra.')<br/>'.$size.'<br/>'.$choose.'</td>
                        <td>' . $item->item_quantity . '</td>
                        <td>' . number_format((int)$item->item_price, 2, '.', '') . '</td>
                    </tr>
                    ';
                    }else{
                    $output.= ' 
                    <tr>
                        <td>' . $item->item_name .'<br/>'.$size.'<br/>'.$choose.'</td>
                        <td>' . $item->item_quantity . '</td>
                        <td>' . number_format((int)$item->item_price, 2, '.', '') . '</td>
                    </tr>
                    ';
                    }
                    }
                    $output.= '  
                    <tr>
                        <td></td>
                        <td>VAT</td>
                        <td>'.$customer[0]->vat.' %</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>Service Charge</td>
                        <td>'.$customer[0]->service_charge.' %</td>
                    </tr>
                    <tr style="background: rgba(201, 201, 201, 0.3);">
                        <td></td>
                        <td>Total Price</td>
                        <td>';
                        $sum = 0;
                        $price_list = 0;
                        $vat = 0;
                        foreach (json_decode($order->order_item)->items as $item) {
                            $price_list = (int)$item->item_price / (int)$item->item_quantity;
                            $sum+= (int)$price_list * (int)$item->item_quantity;
                            $total=$sum;
                        }
                        
                        if($comp_vat != ''){
                            $vat = $sum * $comp_vat;
                        }
                        if($comp_service != ''){

                            $service = $sum * $comp_service;
                        }
                        $sum += $vat + $service; 
                        $output.= '' . number_format((float)$sum, '2', '.', '').' ETB';
                        $output.= '
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td> Ordered From</td>
                        <td>'.$branch.'</td>
                    </tr>
                </tbody>
            </table>
            ';
            $tracking_no = property_exists(json_decode($order->order_item), 'tracking_no');
            if ($tracking_no) {
            $output.= '
                <h5 align="center" style="color: green; font-size: 1.1em!important; font-weight: bold;">Order Accepted now you can track your order</h5>
            ';
            $output.= '
                <a href="' . site_url("cart/mobile_truck/" . json_decode($order->order_item)->tracking_no) . '" id="create_btn" class="btn btn-success btn-block" style="width: 100%; font-size: 1em; padding-top: 10px;">
                Track Your Order
                </a>
            ';
        } else {
            $output.= '
                <h5 align="center" style="color: green; font-size: 1.3em!important; font-weight: bold;"> Your order is on the way , </h5>
                <h6 align="center"><span style="color:green">Please give the restaurant a few minutes to accept your order.</span></h6>
            ';
        }
        return $output;
    }

    public function order_cancled($order, $branch, $output)
    {
        $restaurant_id = $this->session->userdata('restaurant_id');
        $customer = $this->company_model->where('company_id', $restaurant_id)->order_by('company_id', "desc")->get_all();
        $comp_vat = (int) $customer[0]->vat / 100 ;
        $comp_service = (int) $customer[0]->service_charge / 100;
        $service = 0;
        $output.= '
            <table class="table table-borderless" style="align-items: center; align-self: center; text-align: center; border: 2px solid transparent; color:#212121; font-size: 0.9em;" id="cart_list_items">
                <thead>
                    <tr>
                        <th style="text-align: center; font-weight: bold;">Item</th>
                        <th style="text-align: center; font-weight: bold;">Qty</th>
                        <th style="text-align: center; font-weight: bold;">Price (ETB)</th>
                    </tr>
                </thead>
                <tbody>
                    ';
                    foreach (json_decode($order->order_item)->items as $item) {
                        $size = '';
                        $choose = '';
                        if($item->item_size != ''){
                            $size = 'Size: ('.$item->item_size.')';
                        }
                        if($item->choose != ''){
                            $choose = 'Choose: ('.$item->choose.')';
                        }
                    if (!empty($item->extra)) {
                    $output.= ' 
                    <tr>
                        <td>' . $item->item_name. ' <br/>Extra: ('.$item->extra.')<br/>'.$size.'<br/>'.$choose.'</td>
                        <td>' . $item->item_quantity . '</td>
                        <td>' . number_format((int)$item->item_price, 2, '.', '') . '</td>
                    </tr>
                    ';
                    }else{
                    $output.= ' 
                    <tr>
                        <td>' . $item->item_name .'<br/>'.$size.'<br/>'.$choose.'</td>
                        <td>' . $item->item_quantity . '</td>
                        <td>' . number_format((int)$item->item_price, 2, '.', '') . '</td>
                    </tr>
                    ';
                    }
                    }
                    $output.= '  
                    <tr>
                        <td></td>
                        <td>VAT</td>
                        <td>'.$customer[0]->vat.' %</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>Service Charge</td>
                        <td>'.$customer[0]->service_charge.' %</td>
                    </tr>
                    <tr style="background: rgba(201, 201, 201, 0.3);">
                        <td></td>
                        <td>Total Price</td>
                        <td>';
                        $sum = 0;
                        $price_list = 0;
                        $vat = 0;
                        foreach (json_decode($order->order_item)->items as $item) {
                            $price_list = (int)$item->item_price / (int)$item->item_quantity;
                            $sum+= (int)$price_list * (int)$item->item_quantity;
                            $total=$sum;
                        }
                        
                        if($comp_vat != ''){
                            $vat = $sum * $comp_vat;
                        }
                        if($comp_service != ''){

                            $service = $sum * $comp_service;
                        }
                        $sum += $vat + $service; 
                        $output.= '' . number_format((float)$sum, '2', '.', '').' ETB';
                        $output.= '
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td> Ordered From</td>
                        <td>'.$branch.'</td>
                    </tr>
                </tbody>
            </table>
        ';
        $output.='       
            <h5 align="center" style="color: #b70000; font-size: 1em!important; font-weight: bold;">Sorry!<br/> Your order has been cancled.</h5>
        ';
        return $output;
    }

    public function order_delivered($order, $branch, $output)
    {
        $restaurant_id = $this->session->userdata('restaurant_id');
        $customer = $this->company_model->where('company_id', $restaurant_id)->order_by('company_id', "desc")->get_all();
        $comp_vat = (int) $customer[0]->vat / 100 ;
        $comp_service = (int) $customer[0]->service_charge / 100;
        $service = 0;
        $output.= '
            <table class="table table-borderless" style="align-items: center; align-self: center; text-align: center; border: 2px solid transparent; color:#212121; font-size: 0.9em;" id="cart_list_items">
                <thead>
                    <tr>
                        <th style="text-align: center; font-weight: bold;">Item</th>
                        <th style="text-align: center; font-weight: bold;">Qty</th>
                        <th style="text-align: center; font-weight: bold;">Price (ETB)</th>
                    </tr>
                </thead>
                <tbody>
                    ';
                    foreach (json_decode($order->order_item)->items as $item) {
                        $size = '';
                        $choose = '';
                        if($item->item_size != ''){
                            $size = 'Size: ('.$item->item_size.')';
                        }
                        if($item->choose != ''){
                            $choose = 'Choose: ('.$item->choose.')';
                        }
                    if (!empty($item->extra)) {
                    $output.= ' 
                    <tr>
                        <td>' . $item->item_name. ' <br/>Extra: ('.$item->extra.')<br/>'.$size.'<br/>'.$choose.'</td>
                        <td>' . $item->item_quantity . '</td>
                        <td>' . number_format((int)$item->item_price, 2, '.', '') . '</td>
                    </tr>
                    ';
                    }else{
                    $output.= ' 
                    <tr>
                        <td>' . $item->item_name .'<br/>'.$size.'<br/>'.$choose.'</td>
                        <td>' . $item->item_quantity . '</td>
                        <td>' . number_format((int)$item->item_price, 2, '.', '') . '</td>
                    </tr>
                    ';
                    }
                    }
                    $output.= '  
                    <tr>
                        <td></td>
                        <td>VAT</td>
                        <td>'.$customer[0]->vat.' %</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>Service Charge</td>
                        <td>'.$customer[0]->service_charge.' %</td>
                    </tr>
                    <tr style="background: rgba(201, 201, 201, 0.3);">
                        <td></td>
                        <td>Total Price</td>
                        <td>';
                        $sum = 0;
                        $price_list = 0;
                        $vat = 0;
                        foreach (json_decode($order->order_item)->items as $item) {
                            $price_list = (int)$item->item_price / (int)$item->item_quantity;
                            $sum+= (int)$price_list * (int)$item->item_quantity;
                            $total=$sum;
                        }
                        
                        if($comp_vat != ''){
                            $vat = $sum * $comp_vat;
                        }
                        if($comp_service != ''){

                            $service = $sum * $comp_service;
                        }

                        $sum += $vat + $service; 
                        $output.= '' . number_format((float)$sum, '2', '.', '').' ETB';
                        $output.= '
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td> Ordered From</td>
                        <td>'.$branch.'</td>
                    </tr>
                </tbody>
            </table>
        ';
        if ($order->order_type == 1) {
            $output.= '
                <h5 align="center" style="color: #087c02; font-size: 1.3em!important; font-weight: bold;">Your order is about to serve.</h5>
                <h5 align="center" style="font-size: 1em!important;">Thank you, for using our service.</h5>
            ';
        } else {
            $output.= '
                <h5 align="center" style="color: #087c02; font-size: 1.1em!important; font-weight: bold;">Thank You for using our service</h5>
            ';
        }
        return $output;
    }

    public function order_scheduled($order, $branch, $output)
    {
        $restaurant_id = $this->session->userdata('restaurant_id');
        $customer = $this->company_model->where('company_id', $restaurant_id)->order_by('company_id', "desc")->get_all();
        $comp_vat = (int) $customer[0]->vat / 100 ;
        $comp_service = (int) $customer[0]->service_charge / 100;
        $service = 0;
        $output.= '    
            <table class="table table-borderless" style="align-items: center; align-self: center; text-align: center; border: 2px solid transparent; color:#212121; font-size: 0.9em;" id="cart_list_items">
                <thead>
                    <tr>
                        <th style="text-align: center; font-weight: bold;">Item</th>
                        <th style="text-align: center; font-weight: bold;">Qty</th>
                        <th style="text-align: center; font-weight: bold;">Price (ETB)</th>
                    </tr>
                </thead>
                <tbody>
                    ';
                    foreach (json_decode($order->order_item)->items as $item) {
                        $size = '';
                        $choose = '';
                        if($item->item_size != ''){
                            $size = 'Size: ('.$item->item_size.')';
                        }
                        if($item->choose != ''){
                            $choose = 'Choose: ('.$item->choose.')';
                        }
                    if (!empty($item->extra)) {
                    $output.= ' 
                    <tr>
                        <td>' . $item->item_name. ' <br/>Extra: ('.$item->extra.')<br/>'.$size.'<br/>'.$choose.'</td>
                        <td>' . $item->item_quantity . '</td>
                        <td>' . number_format((int)$item->item_price, 2, '.', '') . '</td>
                    </tr>
                    ';
                    }else{
                    $output.= ' 
                    <tr>
                        <td>' . $item->item_name .'<br/>'.$size.'<br/>'.$choose.'</td>
                        <td>' . $item->item_quantity . '</td>
                        <td>' . number_format((int)$item->item_price, 2, '.', '') . '</td>
                    </tr>
                    ';
                    }
                    }
                    $output.= '  
                    <tr>
                        <td></td>
                        <td>VAT</td>
                        <td>'.$customer[0]->vat.' %</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>Service Charge</td>
                        <td>'.$customer[0]->service_charge.' %</td>
                    </tr>
                    <tr style="background: rgba(201, 201, 201, 0.3);">
                        <td></td>
                        <td>Total Price</td>
                        <td>';
                        $sum = 0;
                        $price_list = 0;
                        $vat = 0;
                        foreach (json_decode($order->order_item)->items as $item) {
                            $price_list = (int)$item->item_price / (int)$item->item_quantity;
                            $sum+= (int)$price_list * (int)$item->item_quantity;
                            $total=$sum;
                        }
                        
                        if($comp_vat != ''){
                            $vat = $sum * $comp_vat;
                        }
                        if($comp_service != ''){

                            $service = $sum * $comp_service;
                        }
                        $sum += $vat + $service; 
                        $output.= '' . number_format((float)$sum, '2', '.', '').' ETB';
                        $output.= '
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td> Ordered From</td>
                        <td>'.$branch.'</td>
                    </tr>
            </table>
            <h5 align="center" style="color: #225e02; font-size: 1em!important;">Your Order is scheduled.</h5>
            <h6 align="center" >Thank you, for using our service.</h6>
        ';
                
        return $output;
    }

}