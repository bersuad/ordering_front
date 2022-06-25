
<section class="final-order section-padding bg-light-theme" style="margin-top: 180px;">
        <div class="container">
            <div class="row">
                    <div class="col-lg-2">
                    </div>
                    <div class="col-lg-8">
                        <div class="main-box padding-20">
                                <div align="center">
                                    <img src="<?php echo order_admin_URL ?><?php echo $companies[0]->company_logo; ?>" alt="logo"  style="height: 100px; width:auto; border-radius: 10px;"/>
                                </div>
                                <br/>                        
                                <input type="hidden" name="" id="request_id" value="<?php echo $request_id ?>">
                                <input type="hidden" name="" id="job_id" value="<?php echo $job_id ?>">
                                <div id="status">
                                </div>
                            <!-- </div> -->
                        </div>
                    </div>
                    <div class="col-lg-2"></div>                        
                
            </div>
        </div>
    </section>

    <script src="<?php echo base_url() ?>assets/js/jquery-2.1.1.min.js"></script>
    
    <script>
        $(document).ready(function(){function a(){var a=$("#request_id").val();$("#job_id").val(),$.ajax({type:"POST",url:"/order_qr/order/truck_order_for_mobile",timeout:5e3,data:{id:a},success:function(a){try{result=JSON.parse(a),$("#status").empty(),$("#status").html(result),request()}catch(b){request()}}})}a(),setInterval(function(){$.active||a()},5e3)})
    </script>
    <script type="text/javascript">
        function request(){var a=$("#request_id").val();if(null!=a&&""==a)return}function request_status(a,b,c,d,e){var a=a,b=b,c=c,d=d,f=document.getElementById("job_id").value;$.ajax({type:"POST",url:"/order_qr/cart/order_info",data:{name:a,phone_no:b,driver_id:c,job_status:d,tracking_no:e,job_id:f,order_id:138},success:function(a){}})}
    </script>