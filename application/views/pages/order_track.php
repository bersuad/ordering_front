
<section class="final-order section-padding bg-light-theme" style="margin-top: 180px;">
        <div class="container">
            <div class="row">
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
            // console.log(id);
                
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
