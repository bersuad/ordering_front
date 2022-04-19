    <section class="final-order section-padding bg-light-theme" style="margin-top: 180px;">
        <div class="container">
            <div class="row">
                <?php $code = $this->session->userdata('code'); 
                    if ($code) {
                ?>
                    <div class="col-lg-2"></div>
                    <div class="col-lg-8">
                        <div align="center" class="main-box padding-20">
                            <h4><strong> ** Notice **</strong></h4>
                            <p>
                                You can visit history page where you can find each order with time line.
                            </p>
                        </div>
                        <div class="main-box padding-20">
                            <div align="center">
                                <img src="<?php echo base_url() ?>assets/img/logo.png" class="img-fluid" alt="Logo" style="height: 40px; width: auto;">
                            </div>
                            <br/>
                                                        
                            <input type="hidden" name="" id="request_id" value="<?php echo $request_id ?>">
                            <input type="hidden" name="" id="job_id" value="<?php echo $job_id ?>">
                            <div id="status">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2"></div>
                <?php  } else {?>
                    <div class="col-lg-2">
                    </div>
                    <div class="col-lg-8">
                        <div class="main-box padding-20">
                                <div align="center">
                                    <img src="<?php echo order_admin_URL ?><?php echo $companies[0]->company_logo; ?>" alt="logo"  style="height: 120px; width:auto;"/>
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
                <?php    }
                    
                ?>
            </div>
        </div>
    </section>

    <script src="<?php echo base_url() ?>assets/js/jquery-2.1.1.min.js"></script>
    
    <script>
        $(document).ready(function() {
        truck_order_for_mobile();
        function truck_order_for_mobile() {
            var id = $('#request_id').val();
            var job_id = $('#job_id').val();
            console.log(id);
                
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>order/truck_order_for_mobile",
                    timeout: 5000,
                    data: {
                        id:id,
                    },
                    success: function(output) {
                        // console.log(output);
                        try{
                            result = JSON.parse(output);
                            $('#status').empty();
                            $('#status').html(result);
                            request();
                        } catch(error) {
                            request();
                        }
                    }
                });
            }

            setInterval(function(){
                if(!$.active){
                    truck_order_for_mobile()
                }
            }, 5000);
        });
    </script>

    <script type="text/javascript">
        // request();
        function request() {

            var job_id = $("#request_id").val();
            if (job_id == null) return;
            else if(job_id == "") return;
            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>cart/dispatch",
                data: {
                    job_id: job_id,
                },
                success: function(output) {
                    
                    try{
                        result = JSON.parse(output);
                        name = result.driver_name;
                        phone_no = result.driver_phone;
                        driver_id = result.driver_id;
                        job_status = result.job_status;
                        tracking_number = result.traking_number;

                        request_status(name, phone_no, driver_id, job_status, tracking_number);
                    } catch(error){
                        
                    }
                }
            });

        }

        function request_status(name, phone_no, driver_id, job_status, tracking_number) {
            var name = name;
            var phone_no = phone_no;
            var driver_id = driver_id
            var job_status = job_status;
            var tracking_no = tracking_number;
            var job_id = document.getElementById("job_id").value;
            var order_id = <?php echo $request_id ?>;
            
            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>cart/order_info",
                data: {
                    name: name,
                    phone_no: phone_no,
                    driver_id: driver_id,
                    job_status: job_status,
                    tracking_no: tracking_number,
                    job_id: job_id,
                    order_id: order_id,
                },
                success: function(output) {
                    
                }
            });
        }
    </script>
