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
    }

    public function truck_order_for_mobile() {

        $order_id = $this->input->post('id');
        $user_id = 1;
        $output = '';
        $code = $this->session->userdata('code');

        $sql = $this->sql_query($code, $order_id, $user_id);
        
        $orders = $this->order_model->sql($sql);

        $output .= '
            <div align="center" style="width: 100%; margin-left: 5%; background:#f2f2f2!important; border-radius: 10px;"></div>
            <article style="font-size: 1em; color: #212121;">
            <h4 align="center"> Your Order Status</h4>
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

    private function sql_query($code, $order_id, $user_id)
    {
        if ($code) {
            $sql  = "   SELECT order_item::json, order_id, order_timestamp, order_customer_id, order_status, order_type,branch_name
                        FROM orders INNER JOIN branches ON orders.order_branch_id = branches.branch_id 
                        WHERE orders.order_item ->> 'code' = '$code' AND orders.order_customer_id = $user_id;
                    ";
        } else {
            $sql  = "   SELECT order_item::json, order_id, order_timestamp, order_customer_id, order_status, order_type,branch_name
                        FROM orders INNER JOIN branches ON orders.order_branch_id = branches.branch_id 
                        WHERE orders.order_id  = $order_id AND orders.order_customer_id = $user_id;
                    ";
        }

        return $sql;
    }
    
    
    public function new_order($order, $branch, $output){
        $output.= '
            <table class="table table-borderless" style="align-items: center; align-self: center; text-align: center; border: 2px solid transparent; color:#212121; font-size: 0.9em;" id="cart_list_items">
                <thead>
                    <tr>
                        <th>Item</th>
                        <th>Qty</th>
                        <th>Price (ETB)</th>
                    </tr>
                </thead>
                <tbody>
                    ';
                    foreach (json_decode($order->order_item)->items as $item) {
                    if (!empty($item->extra)) {
                    $output.= ' 
                    <tr>
                        <td>' . $item->item_name. ' ('.$item->extra.')' .'</td>
                        <td>' . $item->item_quantity . '</td>
                        <td>' . number_format((int)$item->item_price, 2, '.', '') . '</td>
                    </tr>
                    ';
                    }else{
                    $output.= ' 
                    <tr>
                        <td>' . $item->item_name .'</td>
                        <td>' . $item->item_quantity . '</td>
                        <td>' . number_format((int)$item->item_price, 2, '.', '') . '</td>
                    </tr>
                    ';
                    }
                    }
                    $output.= '  
                    <tr style="background: rgba(201, 201, 201, 0.3);">
                        <td></td>
                        <td>Total Price</td>
                        <td>';
                        $sum = 0;
                        $price_list = 0;
                        foreach (json_decode($order->order_item)->items as $item) {
                            $price_list = (int)$item->item_price / (int)$item->item_quantity;
                            $sum+= (int)$price_list * (int)$item->item_quantity;
                        }
                        $output.= '' . number_format((float)$sum, '2', '.', '');
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
        $output.= '
            <table class="table table-borderless" style="align-items: center; align-self: center; text-align: center; border: 2px solid transparent; color:#212121; font-size: 0.9em;" id="cart_list_items">
                <thead>
                    <tr>
                        
                        <th style="text-align="center"">Item</th>
                        <th>Qty</th>
                        <th>Price (ETB)</th>
                    </tr>
                </thead>
                <tbody>
                    ';
                    foreach (json_decode($order->order_item)->items as $item) {
                    $output.= '
                    <tr>
                        <td>' . $item->item_name . '</td>
                        <td>' . $item->item_quantity . '</td>
                        <td>' . number_format((int)$item->item_price, 2, '.', '') . '</td>
                    </tr>
                    ';
                    }
                    $output.= '  
                    <tr style="background: rgba(201, 201, 201, 0.3);">
                        <td></td>
                        <td>Total Price</td>
                        <td>';
                        $sum = 0;
                        $price_list = 0;
                        foreach (json_decode($order->order_item)->items as $item) {
                        $price_list = (int)$item->item_price / (int)$item->item_quantity;
                        $sum+= (int)$price_list * (int)$item->item_quantity;
                        }
                        $output.= '' . number_format((float)$sum, '2', '.', '');
                        $output.= '
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>';
                        if ($order->order_type == 1) {
                        $output.= 'Your Location
                        </td>
                        ';
                        } else {
                        $output.= 'Branch Location </td>';
                        }
                        $output.= '
                        <td>' . json_decode($order->order_item)->item_destination . '</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td> Ordered From</td>
                        <td>'. $branch .'</td>
                    </tr>
                </tbody>
            </table>
        ';
        $output.= '
            <h5 align="center" style="color: rgba(216, 148, 0, 0.9); font-size: 1.2em!important; font-weight: bold;"> Your order is being proccessed.</h5>
        ';
        return $output;
    }

    public function order_wait($order, $branch, $output)
    {
        $output.= '
            <table class="table table-borderless" style="align-items: center; align-self: center; text-align: center; border: 2px solid transparent; color:#212121; font-size: 0.9em;" id="cart_list_items">
                <thead>
                    <tr>
                        <th>Item</th>
                        <th>Qty</th>
                        <th>Price (ETB)</th>
                    </tr>
                </thead>
                <tbody>
                    ';
                    foreach (json_decode($order->order_item)->items as $item) {
                    if (!empty($item->extra)) {
                    $output.= ' 
                    <tr>
                        <td>' . $item->item_name. ' ('.$item->extra.')' .'</td>
                        <td>' . $item->item_quantity . '</td>
                        <td>' . number_format((int)$item->item_price, 2, '.', '') . '</td>
                    </tr>
                    ';
                    }else{
                    $output.= ' 
                    <tr>
                        <td>' . $item->item_name .'</td>
                        <td>' . $item->item_quantity . '</td>
                        <td>' . number_format((int)$item->item_price, 2, '.', '') . '</td>
                    </tr>
                    ';
                    }
                    }
                    $output.= '  
                    <tr style="background: rgba(201, 201, 201, 0.3);">
                        <td></td>
                        <td>Total Price</td>
                        <td>';
                        $sum = 0;
                        $price_list = 0;
                        foreach (json_decode($order->order_item)->items as $item) {
                            $price_list = (int)$item->item_price / (int)$item->item_quantity;
                            $sum+= (int)$price_list * (int)$item->item_quantity;
                        }
                        $output.= '' . number_format((float)$sum, '2', '.', '');
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
                <h5 style="color: rgba(216, 148, 0, 0.9); font-size: 1.2em!important; font-weight: bold;" align="center"> Your order is ready to be picked up, waiting for a picked up.</h5>
            ';
        } else {
            $output.= '
                <h5 style="color: #087c02; font-size: 1.2em!important; font-weight: bold;" align="center">
                Order completed ! When You arrive at
                <h5 style="color: #087c02; font-size: 1em!important; font-weight: bold;" align="center">' . json_decode($order->order_item)->item_destination . ' branch, Ask for order N<sup><u>o</u></sup> " <i>' . $order_id . '</i> "</h5>
            ';
        }
        return $output;
    }

    public function order_onway($order, $branch, $output)
    {
        $output.= '
            <table class="table table-borderless" style="align-items: center; align-self: center; text-align: center; border: 2px solid transparent; color:#212121; font-size: 0.9em;" id="cart_list_items">
                <thead>
                    <tr>
                        <th>Item</th>
                        <th>Qty</th>
                        <th>Price (ETB)</th>
                    </tr>
                </thead>
                <tbody>
                    ';
                    foreach (json_decode($order->order_item)->items as $item) {
                    $output.= '
                    <tr>
                        <td>' . $item->item_name . '</td>
                        <td>' . $item->item_quantity . '</td>
                        <td>' . number_format((int)$item->item_price, 2, '.', '') . '</td>
                    </tr>
                    ';
                    }
                    $output.= '  
                    <tr style="background: rgba(201, 201, 201, 0.3);">
                        <td></td>
                        <td>Total Price</td>
                        <td>';
                        $sum = 0;
                        $price_list = 0;
                        foreach (json_decode($order->order_item)->items as $item) {
                        $price_list = (int)$item->item_price / (int)$item->item_quantity;
                        $sum+= (int)$price_list * (int)$item->item_quantity;
                        }
                        $output.= '' . number_format((float)$sum, '2', '.', '');
                        $output.= '
                        </td>
                    </tr>
                    
                    <tr>
                        <td></td>
                        <td> Ordered From</td>
                        <td>'. $branch .'</td>
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
        $output.= '
            <table class="table table-borderless" style="align-items: center; align-self: center; text-align: center; border: 2px solid transparent; color:#212121; font-size: 0.9em;" id="cart_list_items">
                <thead>
                    <tr>
                        <th>Item</th>
                        <th>Qty</th>
                        <th>Price (ETB)</th>
                    </tr>
                </thead>
                <tbody>
                    ';
                    foreach (json_decode($order->order_item)->items as $item) {
                    $output.= '
                    <tr>
                        <td>' . $item->item_name . '</td>
                        <td>' . $item->item_quantity . '</td>
                        <td>' . number_format((int)$item->item_price, 2, '.', '') . '</td>
                    </tr>
                    ';
                    }
                    $output.= '  
                    <tr style="background: rgba(201, 201, 201, 0.3);">
                        <td></td>
                        <td>Total Price</td>
                        <td>';
                        $sum = 0;
                        $price_list = 0;
                        foreach (json_decode($order->order_item)->items as $item) {
                        $price_list = (int)$item->item_price / (int)$item->item_quantity;
                        $sum+= (int)$price_list * (int)$item->item_quantity;
                        }
                        $output.= '' . number_format((float)$sum, '2', '.', '');
                        $output.= '
                        </td>
                    </tr>
                    
                    <tr>
                        <td></td>
                        <td> Ordered From</td>
                        <td>'. $branch .'</td>
                    </tr>
                </tbody>
            </table>
        ';
        $output.='       
            <h5 align="center" style="color: #b70000; font-size: 1em!important; font-weight: bold;">Your order has been cancled, call 6583 for more information.</h5>
        ';
        return $output;
    }

    public function order_delivered($order, $branch, $output)
    {
        $output.= '
            <table class="table table-borderless" style="align-items: center; align-self: center; text-align: center; border: 2px solid transparent; color:#212121; font-size: 0.9em;" id="cart_list_items">
                <thead>
                    <tr>
                        <th>Item</th>
                        <th>Qty</th>
                        <th>Price (ETB)</th>
                    </tr>
                </thead>
                <tbody>
                    ';
                    foreach (json_decode($order->order_item)->items as $item) {
                    $output.= '
                    <tr>
                        <td>' . $item->item_name . '</td>
                        <td>' . $item->item_quantity . '</td>
                        <td>' . number_format((int)$item->item_price, 2, '.', '') . '</td>
                    </tr>
                    ';
                    }
                    $output.= '  
                    <tr style="background: rgba(201, 201, 201, 0.3);">
                        <td></td>
                        <td>Total Price</td>
                        <td>';
                        $sum = 0;
                        $price_list = 0;
                        foreach (json_decode($order->order_item)->items as $item) {
                        // $sum += (int)$item->item_price * (int)$item->item_quantity;
                        $price_list = (int)$item->item_price / (int)$item->item_quantity;
                        $sum+= (int)$price_list * (int)$item->item_quantity;
                        }
                        $output.= '' . number_format((float)$sum, '2', '.', '');
                        $output.= '
                        </td>
                    </tr>
                    
                    <tr>
                        <td></td>
                        <td> Ordered From</td>
                        <td>'. $branch .'</td>
                    </tr>
                </tbody>
            </table>
        ';
        if ($order->order_type == 1) {
            $output.= '
                <h5 align="center" style="color: #087c02; font-size: 1.3em!important; font-weight: bold;">Order Delivered</h5>
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
        $output.= '    
            <table class="table table-borderless" style="align-items: center; align-self: center; text-align: center; border: 2px solid transparent; color:#212121; font-size: 0.9em;" id="cart_list_items">
                <thead>
                    <tr>
                        <th>Item</th>
                        <th>Qty</th>
                        <th>Price (ETB)</th>
                    </tr>
                </thead>
                <tbody>
                    ';
                    foreach (json_decode($order->order_item)->items as $item) {
                    if (!empty($item->extra)) {
                    $output.= ' 
                    <tr>
                        <td>' . $item->item_name. ' ('.$item->extra.')' .'</td>
                        <td>' . $item->item_quantity . '</td>
                        <td>' . number_format((int)$item->item_price, 2, '.', '') . '</td>
                    </tr>
                    ';
                    }else{
                    $output.= ' 
                    <tr>
                        <td>' . $item->item_name .'</td>
                        <td>' . $item->item_quantity . '</td>
                        <td>' . number_format((int)$item->item_price, 2, '.', '') . '</td>
                    </tr>
                    ';
                    }
                    }
                    $output.= '  
                    <tr style="background: rgba(201, 201, 201, 0.3);">
                        <td></td>
                        <td>Total Price</td>
                        <td>';
                        $sum = 0;
                        $price_list = 0;
                        foreach (json_decode($order->order_item)->items as $item) {
                            $price_list = (int)$item->item_price / (int)$item->item_quantity;
                            $sum+= (int)$price_list * (int)$item->item_quantity;
                        }
                        $output.= '' . number_format((float)$sum, '2', '.', '');
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
            <h5 align="center" style="color: #225e02; font-size: 1em!important;">Your Order is scheduled.</h5>
            <h6 align="center" >Thank you, for using our service.</h6>
        ';
                
        return $output;
    }

}