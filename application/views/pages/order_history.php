<div class="fixed_layer section" id="reservation">
    <div class="fixed_layer_padd container">
        <div class="row">
            <div class="col-md-offset-3 col-md-6" data-aos="fade-down">
                <div class="reserv_box mt-100">
                    <h1 class="section-title title_sty1">Your Order History</h1>
                    <p class="short">You previous orders</p>
                    <div class="row">
                    <?php  if(!empty($order_list)){
                        foreach($order_list as $key => $order){
                    ?>
                    <a href="<?php echo site_url()?>pages/order_view/<?php echo $order['order_id'] ?>">
                        <div class="row well" style="margin-top: 1%; padding-top: 10px; padding-bottom: 10px; border-bottom: 6px solid #f9f9f9; border-top: 2.5px solid #f9f9f9; border-radius: 10px;" align="center">
                            <div class="col-md-4 col-sm-4 col-xs-12" style="padding-top: 10px">
                                <img src="<?php echo base_url('assets/') ?>img/takeaway.jpg" style="width: 120px!important; height: auto; margin-top:-5%;">
                            </div>
                            <div class="col-md-5 col-sm-5 col-xs-12" style="padding-top: 27px; color:#111;">
                                <p>From " <b><?php echo $order['branch_name']; ?> "</b></p>
                                <p><?php echo  date('d M, Y h:i a', strtotime($order['order_timestamp']) );?> </p>    <br>
                            </div>
                            <div class="col-md-3 col-sm-3 col-xs-12" style="padding-top: 27px;">
                                <i class="btn fa fa-chevron-right btn-warning btn-block" style="background: #f6a525;"></i>
                            </div>
                            <hr/>     
                        </div>
                    </a>
                    <?php }} ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
