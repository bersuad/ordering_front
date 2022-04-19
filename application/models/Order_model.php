<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Order_model extends MY_Model
{

    function __construct()
    {
        parent::__construct();
        $this->table       = 'orders';
        $this->load->database();
        $this->primary_key = 'order_id';
        $this->has_one['customer'] = array('foreign_model' => 'Customer_model', 'foreign_table' => 'customer', 'foreign_key' => 'customer_id', 'local_key' => 'order_customer_id');
        $this->has_one['vendor'] = array('foreign_model' => 'Vendor_model', 'foreign_table' => 'vendor', 'foreign_key' => 'vendor_id', 'local_key' => 'order_vendor_id');
        $this->has_one['branch'] = array('foreign_model' => 'Branch_model', 'foreign_table' => 'branches', 'foreign_key' => 'branch_id', 'local_key' => 'order_branch_id');
    }

    // returns an array of new requested orders
    public function get_new_requested_orders($vendor_id)
    {
        $query = "SELECT customer.customer_full_name, customer.customer_phone, orders.order_item, orders.order_id
                from customer
                inner join orders
                on customer.customer_id = orders.order_customer_id
                where " . ($vendor_id != 'all' ? "orders.order_item ->> 'order_vendor_id' = '" . $vendor_id . "' and " : "") . " orders.order_status = '0'
                AND to_timestamp(date_part('DAY', now()))  = to_timestamp( date_part('DAY', orders.order_timestamp) ) AND orders.order_type = '1'
                ORDER BY orders.order_id DESC";

        $result = $this->db->query($query);

        return $result->result_array();
    }

    // returns an array of all pending requests
    public function get_product_pending_request($vendor_id)
    {
        $query = "SELECT customer.customer_full_name, customer.customer_phone, orders.order_item, orders.order_id, orders.order_type, orders.order_status
                        from customer
                        inner join orders
                        on customer.customer_id = orders.order_customer_id
                        where " . ($vendor_id != 'all' ? "orders.order_item ->> 'order_vendor_id' = '" . $vendor_id . "' and " : "") . " (orders.order_status = '2' or orders.order_status = '3') 
                        AND to_timestamp(date_part('DAY', now()))  = to_timestamp( date_part('DAY', orders.order_timestamp) )
                        ORDER BY orders.order_id DESC";

        $result = $this->db->query($query);

        return $result->result_array();
    }

    // returns an array of all cancelled orders
    public function get_product_cancled_request($vendor_id)
    {
        $query = "SELECT customer.customer_full_name, customer.customer_phone, orders.order_item, orders.order_id
                        from customer
                        inner join orders
                        on customer.customer_id = orders.order_customer_id
                        where " . ($vendor_id != 'all' ? "orders.order_item ->> 'order_vendor_id' = '" . $vendor_id . "' and " : "") . " orders.order_status = '5' 
                        AND to_timestamp(date_part('DAY', now()))  = to_timestamp( date_part('DAY', orders.order_timestamp) )
                        ORDER BY orders.order_id DESC";

        $result = $this->db->query($query);

        return $result->result_array();
    }
    
    // returns an array of all completed orders
    public function get_product_completed_request($vendor_id)
    {
        $query = "SELECT customer.customer_full_name, customer.customer_phone, orders.order_item, orders.order_id
                        from customer
                        inner join orders
                        on customer.customer_id = orders.order_customer_id
                        where " . ($vendor_id != 'all' ? "orders.order_item ->> 'order_vendor_id' = '" . $vendor_id . "' and " : "") . " orders.order_status = '4' 
                        AND to_timestamp(date_part('DAY', now()))  = to_timestamp( date_part('DAY', orders.order_timestamp) )
                        ORDER BY orders.order_id DESC";


        $result = $this->db->query($query);

        return $result->result_array();
    }

    // returns an array of all scheduled orders
    public function get_scheduled_requests($vendor_id)
    {

        $query = "SELECT customer.customer_full_name, customer.customer_phone, orders.order_item, orders.order_id, orders.order_type
        from customer
        inner join orders
        on customer.customer_id = orders.order_customer_id
        where " . ($vendor_id != 'all' ? "orders.order_item ->> 'order_vendor_id' = '" . $vendor_id . "' and " : "") . " orders.order_status = '6'
        ORDER BY orders.order_id DESC";


        $result = $this->db->query($query);

        return $result->result_array();
    }

    // returns an array of all orders in process
    public function get_product_in_kitchen_request($vendor_id)
    {
        $query = "SELECT customer.customer_full_name, customer.customer_phone, orders.order_item, orders.order_id, orders.order_type
        from customer
        inner join orders
        on customer.customer_id = orders.order_customer_id
        where " . ($vendor_id != 'all' ? "orders.order_item ->> 'order_vendor_id' = '" . $vendor_id . "' and " : "") . "orders.order_status = '1' 
        AND to_timestamp(date_part('DAY', now()))  = to_timestamp( date_part('DAY', orders.order_timestamp) )
        ORDER BY orders.order_id DESC";

        $result = $this->db->query($query);

        return $result->result_array();
    }

    // returns an array of all orders in a specific branch
    public function get_branch_orders($vendor_id, $from, $to)
    {
        $date_filter =
            $from == $to
            ? "  to_timestamp(date_part('DAY', now()))  = to_timestamp( date_part('DAY', orders.order_timestamp) )"
            :
            "order_timestamp >= '" . $from . "' and order_timestamp <= '" . $to . "'";
        $query = "SELECT * FROM orders WHERE " . ($vendor_id != 'all' ? "orders.order_item ->> 'order_vendor_id' = '" . $vendor_id . "' and " : "") . $date_filter;
        // echo $query; die;
        $result = $this->db->query($query);
        return $result->result_array();
    }

    public function get_total_orders($from, $to)
    {
        $date_filter =
            $from == $to
            ? "  to_timestamp(date_part('DAY', now()))  = to_timestamp( date_part('DAY', orders.order_timestamp) )"
            :
            "order_timestamp >= '" . $from . "' and order_timestamp <= '" . $to . "'";

        $query = "SELECT * FROM orders WHERE " . $date_filter;
        $result = $this->db->query($query);
        return $result->result_array();
    }

    // returns an array of all self pick up type orders
    public function get_self_pickup_orders($vendor_id)
    {
        $query = "SELECT customer.customer_full_name, customer.customer_phone, orders.order_item, orders.order_id, orders.order_type
        from customer
        inner join orders
        on customer.customer_id = orders.order_customer_id
        where " . ($vendor_id != 'all' ? "orders.order_item ->> 'order_vendor_id' = '" . $vendor_id . "' and " : "") . " to_timestamp(date_part('DAY', now()))  = to_timestamp( date_part('DAY', orders.order_timestamp) ) and orders.order_type = '2' and orders.order_status = '0'
        ORDER BY orders.order_id DESC";

        $result = $this->db->query($query);

        return $result->result_array();
    }

    public function get_delivered_count($vendor_id, $from, $to)
    {
        $date_filter =
            $from == $to
            ? "  to_timestamp(date_part('DAY', now()))  = to_timestamp( date_part('DAY', orders.order_timestamp) )"
            :
            "order_timestamp >= '" . $from . "' and order_timestamp <= '" . $to . "'";

        $query = "SELECT * from orders 
        where " . ($vendor_id != 'all' ? "orders.order_item ->> 'order_vendor_id' = '" . $vendor_id . "' and " : "") . $date_filter . "
        and orders.order_status = '4' 
        ";
        // echo $query; die;
        return $this->db->query($query)->num_rows();
    }

    public function get_total_delivered_count($from, $to)
    {
        $date_filter =
            $from == $to
            ? "  to_timestamp(date_part('DAY', now()))  = to_timestamp( date_part('DAY', orders.order_timestamp) )"
            :
            "order_timestamp >= '" . $from . "' and order_timestamp <= '" . $to . "'";

        $query = "SELECT * from orders 
        where " . $date_filter . "
        and orders.order_status = '4'
        ";
        return $this->db->query($query)->num_rows();
    }

    public function get_waiting_delivery_count($vendor_id, $from, $to)
    {
        $date_filter =
            $from == $to
            ? "  to_timestamp(date_part('DAY', now()))  = to_timestamp( date_part('DAY', orders.order_timestamp) )"
            :
            "order_timestamp >= '" . $from . "' and order_timestamp <= '" . $to . "'";

        $query = "SELECT * from orders 
        where " . ($vendor_id != 'all' ? "orders.order_item ->> 'order_vendor_id' = '" . $vendor_id . "' and " : "") . $date_filter . "
        and orders.order_status != '4' and orders.order_status != '5'
        ";
        // echo $query; die;
        return $this->db->query($query)->num_rows();
    }

    public function orders($id)
    {
        $query = "SELECT * from orders inner join branches on orders.order_branch_id = branches.branch_id  where order_customer_id = $id ORDER BY  order_timestamp DESC";
        // print_r($query);die;
        $b = $this->db->query($query);
        return $b->result_array();
    }


    public function get_total_waiting_delivery_count($from, $to)
    {
        $date_filter =
            $from == $to
            ? "  to_timestamp(date_part('DAY', now()))  = to_timestamp( date_part('DAY', orders.order_timestamp) )"
            :
            "order_timestamp >= '" . $from . "' and order_timestamp <= '" . $to . "'";


        $query = "SELECT * from orders 
        where " . $date_filter . "
        and orders.order_status != '4' and orders.order_status != '5'
        ";
        return $this->db->query($query)->num_rows();
    }

    public function get_report($query)
    {
        $result = $this->db->query($query);
        echo count($result->result_array());
        // print_r($result->result_array());

    }

    public function new_request_mobile($customer_id, $order_item, $order_type, $order_status, $branch_id)
    {
        $data = array(
            "order_customer_id" => $customer_id,//order_customer_id
            "order_item" => json_encode($order_item),
            'order_type' => $order_type,
            'order_status' => $order_status,
            'order_branch_id' => $branch_id
        );

        $result = $this->db->insert($this->table, $data);
        
        if($result)
        {   
            $data['order_id'] = $this->db->insert_id();
            $data['order_item'] = json_decode($data['order_item']);
            return $data;
        }

        return;
    }

    public function new_request($customer_id, $order_item, $order_type, $order_status, $branch_id)
    {
        $data = array(
            "order_customer_id" => $customer_id,//order_customer_id
            "order_item" => json_encode($order_item),
            'order_type' => $order_type,
            'order_status' => $order_status,
            'order_branch_id' => $branch_id, //$branch_id
        );
        
        $result = $this->db->insert($this->table, $data);
        
        if($result)
        {   
            $data['order_id'] = $this->db->insert_id();
            $data['order_item'] = json_decode($data['order_item']);
            return $data;
        }
        return null;
    }


    public function num_orders($vendor_id)
    {
        $data = array();
        $data['new_order'] = count($this->get_new_requested_orders($vendor_id));
        $data['in_kitchen'] = count(($this->get_product_in_kitchen_request($vendor_id)));
        $data['pending'] = count($this->get_product_pending_request($vendor_id));
        $data['completed'] = count($this->get_product_completed_request($vendor_id));
        $data['scheduled'] = count($this->get_scheduled_requests($vendor_id));
        $data['self_pickup'] = count($this->get_self_pickup_orders($vendor_id));
        $data['cancled'] = count($this->get_product_cancled_request($vendor_id));
        $data['sum'] = $data['new_order'] + $data['in_kitchen'] + $data['pending'] + $data['completed'] + $data['scheduled'] + $data['self_pickup'] + $data['cancled'];
        if ($data['sum'] == 0) {
            $data['sum'] = 1;
        }
        return $data;
    }

    public function get_product_number()
    {
        $query = "SELECT
            *
        FROM
            orders 
        order by order_id desc limit 6";

        $result = $this->db->query($query);

        return $result->result_array();
    }

    public function get_delivery_time_from_transaction($vendor_id, $from, $to)
    {
        $date_filter =
            $from == $to
            ? "where  to_timestamp(date_part('DAY', now()))  = to_timestamp( date_part('DAY', o.order_timestamp) )"
            :
            "where o.order_timestamp >= '" . $from . "' and o.order_timestamp <= '" . $to . "'";

        $vendor_filter = $vendor_id == 'all' ? '' : " and vendor_id = '" . $vendor_id . "'";

    $query = "
    with _orders as (select order_id, order_timestamp, order_item->>'order_vendor_id' as vendor_id, order_item->>'items' as items from orders),
    _trans as (select o.order_id, o.items, o.vendor_id,  transaction.transaction_timestamp - o.order_timestamp as time_taken  from _orders o inner join transaction on o.order_id = transaction.transaction_order_id
    " . $date_filter . ' ' . $vendor_filter.") select avg(time_taken) from _trans";
    $result = $this->db->query($query)->result_array();
        return $result;
    }

    public function fetch_order_count_grouped_by_item_destination()
    {
        // $this->db->select("order_item->'item_destination' as destination, COUNT(order_item->'item_destination') as count");
        // $this->db->where("to_timestamp(date_part('DAY', now()))", "to_timestamp( date_part('DAY', orders.order_timestamp) )");
        // $this->db->group_by("order_item->'item_destination'");
        // print_r($this->db->get($this->table));
        $query = "SELECT 
                order_item->'item_destination' as destination_name, COUNT(order_item->'item_destination') as count
                FROM 
                    orders
                WHERE to_timestamp(date_part('DAY', now()))  = to_timestamp( date_part('DAY', orders.order_timestamp))
                GROUP BY order_item->'item_destination'";
        $result = $this->db->query($query);

        return $result->result_array();
    }
}
