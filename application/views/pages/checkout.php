<div id="cover-spin">
</div>
<!-- Navigation -->
<div class="container section" id="menu" data-aos="fade-up" style="margin-top: 180px;">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-3 col-sm-2"></div>
            <div class="col-lg-6 col-md-6 col-sm-8 col-xs-12">
                <div class="main-box padding-20">
                    <div align="center">
                        <img src="<?php echo order_admin_URL ?><?php echo $companies[0]->company_logo; ?>" alt="logo"  style="height: 120px; width:auto;"/>
                    </div>
                    <div class="section-header mt-3">
                        <h5 class=" " style="font-weight: bold;">Review and place Your order</h5>
                        <!-- <h5>From <strong id="comp_name"><?php echo $companies[0]->company_name; ?></strong> </h5> -->
                        <div class="row d-flex align-content-center" style="background: #f7f7f7!important; padding-top: 10px; border-radius: 10px; border-top: 5px solid #f2f2f2; border-right: 3.5px solid #f1f1f1; ">
                            <div class="col-md-6 col-sm-12" style="padding-bottom: 10px;">
                                <div>
                                    <label for="name">Name</label>
                                    <input type="text" class="default form-control" name="user_name" placeholder="Your Name" id="user_name" require onchange="inputCheck()"/>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12" style="padding-bottom: 10px;">
                                <div>
                                    <label for="phone">Phone No</label>
                                    <input autocomplete="off" maxlength="10" onkeyup="inputCheck()" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" type="text" name="phone_no" class="form-control input-default " placeholder="Your Phone Number" required autocomplete="off" id="user_phone">
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div>
                                    <label for="Address">Branch</label>
                                    <p class="" id="to_here_list"></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div align="center" id="address_info"></div>
                        </div>                 
                    </div>
                
                    <div class="row">
                        <div class="col-12">
                            <div class="payment-sec">
                                <div class="section-header">
                                    <h5 class="text-light-black" align="center" style="font-weight: bold;">Your Cart</h5>
                                </div>
                                <div class="form-group">
                                    <div id="check_list_cart">
                                    </div>
                                    <div id="trip_estimation_spinner" style="color: #555!important;font-weight:700;float:right; margin-left: 30%;"></div>
                                    <div id="trip_estimation_append" style="color: #555!important;font-weight:700;float:right; margin-left: 30%;"></div>
                                </div>
                                <h6 id="grand_price" align="right"></h6>
                                <hr>
                                <div class="section-header-left">
                                    <div class="custom-control custom-radio">
                                        <div class="form-group mb-3" id="location" style="display: none;">
                                            <h5 class="text-light-black " align="center" style="font-weight: bold;">Please Select Branch</h5>
                                            <div class="form-group">
                                                <label for="exampleFormControlInput1">From <?php echo $companies[0]->company_name; ?> branch <b style="color:red;">*</b></label>
                                                <?php
                                                    if(count($branches)==1){?>
                                                        <select class="default form-control" name="item" id="vendor_id_select" required>
                                                        <?php foreach ($branches as $branch) {
                                                            echo '<option value="' . $branch->branch_id . '" selected> ' . $branch->branch_name . '</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                <?php }else{ ?>
                                                    <select class="default form-control" name="item" id="vendor_id_select" required>
                                                        <?php foreach ($branches as $branch) {
                                                            echo '<option value="' . $branch->branch_id . '"> ' . $branch->branch_name . '</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                <?php }?>
                                            </div>
                                        </div>
                                        <br>
                                        
                                    </div>
                                    <div class="section-header-left" id="table_order_destination">
                                        <h5 class="text-light-black " align="center" style="font-weight: bold;">Add your table number</h5>
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label> </label>
                                                <div class='input-group' style="height: 25px!important; width: 100%; background-color: #fff; border-color: #111; border-radius: 9px;">
                                                    <input type="text" class="default form-control" name="item_destination1" placeholder="Add table number" id="order_destination_place_table" required/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="section-header-left" id="room_order_destination" style="display: none;">
                                        <h5 class="text-light-black " align="center" style="font-weight: bold;">Add your room number</h5>
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label> </label>
                                                <div class='input-group' style="height: 25px!important; width: 100%; background-color: #fff; border-color: #111; border-radius: 9px;">
                                                    <input type="text" class="default form-control" name="item_destination2" placeholder="Add room number" id="order_destination_place_room" required/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="section-header-left" id="car_order_destination" style="display: none;">
                                        <h5 class="text-light-black " align="center" style="font-weight: bold;">Add your plate number</h5>
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label> </label>
                                                <div class='input-group' style="height: 25px!important; width: 100%; background-color: #fff; border-color: #111; border-radius: 9px;">
                                                    <input type="text" class="default form-control" name="item_destination3" placeholder="Add plate number" id="order_destination_place_plate" required/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="section-header-left" id="when" >
                                        <h5 class="text-light-black " align="center" style="font-weight: bold;">Available Time Choice</h5>
                                        <?php  if(!empty($companies)){
                                            foreach($companies as $key => $service){?>
                                        <div class="custom-control custom-radio row">
                                        <?php if($service->id == 3){?>
                                            <div class="col-md-4">
                                                <input type="radio" id="now" name="time" value="" required checked> <label for="delivery">
                                                    <h6>Order From Table</h6>
                                                </label>
                                            </div>
                                            <?php } ?>
                                            <?php if($service->id == 2){?>
                                            <div class="col-md-4">
                                                <input type="radio" id="drive" name="time" value=""> <label for="drive">
                                                    <h6>Drive Up (From Your Car)</h6>
                                                </label>
                                            </div>
                                            <?php } ?>
                                            <?php if($service->id == 1){?>
                                            <div class="col-md-4">
                                                <input type="radio" id="room" name="time" value=""> <label for="room">
                                                    <h6>Order From Room (Hotel)</h6>
                                                </label>
                                            </div>
                                            <?php } ?>
                                            <?php if($service->id == 4){?>
                                            <div class="col-md-4">
                                                <input type="radio" id="schedule" name="time" value=""> <label for="pickup">
                                                    <h6>Pick up</h6>
                                                </label>
                                            </div>
                                            <?php } ?>
                                            <?php if($service->id == 5){?>
                                            <div class="col-md-4">
                                                <input type="radio" id="delivary" name="time" value=""> <label for="pickup">
                                                    <h6>Delivary</h6>
                                                </label>
                                            </div>
                                            <?php } ?>
                                            <?php }
                                        }?>
                                        </div>
                                        <div class="col-lg-8" style="display: none;" id="date_picker">
                                            <div class="form-group">
                                                <label>When will you show up?</label>
                                                <div class='input-group date simplepicker-btn' style="height: 45px!important; width: 100%; background-color: #fff; border-color: #111; border-radius: 9px;">
                                                    <div align="center" style="margin-top: 2%; margin-left: 0%;width:100%!important; ">
                                                        <span id="btn_clander" style="margin-left: 2%;"><i style="color: #444;" class="fa fa-calendar"></i> <span style="color:black;margin-left:2%;margin-left:2%;" onMouseOver="this.style.color='#000'" id="order_time" required>&nbsp; Set your Date / Time</span></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                   
                                    <div class="section-header-left">
                                        <hr>
                                        <br/>
                                        <h5 class="text-light-black " align="center" style="font-weight: bold;">Please Select Payment</h5>
                                        <?php
                                            if(!empty($companies[0]->tele_birr)){?>
                                                <select class="default form-control" name="item" id="payment_option" required>
                                                    <option value="cash" id="cash">Cash</option>
                                                    <option value="telebirr" id="telebirr">Tele Birr</option>
                                                </select>
                                        <?php
                                            }else{
                                        ?>
                                            <select class="default form-control" name="item" id="payment_option" required>
                                                <option value="cash" id="cash" selected>Cash</option>
                                            </select>
                                            <?php }?>
                                        <div class="form-group" id="telebirr_input" style="display: none;">
                                            <h5 class="text-light-black " align="center" style="font-weight: bold;">Make the payment on telebirr on this Number 1234567 and copy Ref number here</h5>
                                            <label> </label>
                                            <div class='input-group' style="height: 25px!important; width: 100%; background-color: #fff; border-color: #111; border-radius: 9px;">
                                                <input type="text" class="default form-control" name="tele_birr" placeholder="Copy the Telebirr transaction number and paste here!" id="order_payment"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <div id="accordion">
                                                <div class="payment-option-tab">
                                                    <div class="tab-content">
                                                        <div class="form-group">
                                                            <h5 align="center" id="verification"></h5>
                                                            <button class="btn btn-first btn-block btn-success create_btn filter-button" disabled>Place Order</button>
                                                        </div>
                                                        <p class="text-center text-light-black no-margin">
                                                            By placing your order, you agree to QRAnbessa's 
                                                            <a href="#">terms of use</a> and <a href="#">privacy agreement</a>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-2"></div>
        </div>
    </div>
    
</section>

<script src="<?php echo base_url() ?>assets/js/jquery-2.1.1.min.js"></script>

<script>
    inputCheck();
    function inputCheck() {
        
        if ($('#user_name').val() == '') {
            $('#user_name').focus();
            $("#address_info").html('** <i style="color:red;">Please add your info</i> **');
            $('.create_btn').prop('disabled', true);

            return false;
        }else if($('#user_phone').val() == ''){
            $('#user_phone').focus();
            $("#address_info").html('** <i style="color:red;">Please add your info</i> **');
            $('.create_btn').prop('disabled', true);

            return false;
        }else{
            $('.create_btn').prop('disabled', false);
            return true;
        }
    };
    $('.create_btn').click(function() {
        $('#cover-spin').show(1);
        inputCheck();
        location_list();
        var order_destination ='';
        var order_destination1 = document.getElementById("order_destination_place_table").value;
        var order_destination2 = document.getElementById("order_destination_place_room").value;
        var order_destination3 = document.getElementById("order_destination_place_plate").value;
        
        if (order_destination1 == '') {
            $('#order_destination_place_table').focus();
            $('.create_btn').prop('disabled', true);
            $('#cover-spin').show(0);
            return false;
        }else{
            order_destination = 'Table Number '+order_destination1;
        }
        if (order_destination2 == '') {
            $('#order_destination_place_room').focus();
            $('.create_btn').prop('disabled', true);
            $('#cover-spin').show(0);
            return false;
        }else{
            order_destination = 'Room Number '+order_destination2;

        }
        if(order_destination3 == '') {
            $('#order_destination_place_plate').focus();
            $('.create_btn').prop('disabled', true);
            $('#cover-spin').show(0);
            return false;
        }else{
            order_destination = 'Plate Number '+order_destination3;
        }

        $(".create_btn").attr('disabled', true);
        console.log(order_destination);
        return;

        var coordinate = sessionStorage.getItem('to_hidden');
        var order_payment = document.getElementById("order_payment").value;
        var date = document.getElementById("order_time").innerHTML ;
        var branch = document.getElementById("vendor_id_select").value ;
        var customer_name = document.getElementById("user_name").value ;
        var customer_phone = document.getElementById("user_phone").value ;
        
        var order_type = 1;
        var vendor_id = 2;
        
        var data = {
            item_destination: order_destination,
            item_destination_coordinate: coordinate,
            item_destination_date: date,
            vendor_id: vendor_id,
            order_type: order_type,
            order_payment: order_payment,
            branch: branch,
            user_name: customer_name,
            user_phone: customer_phone
        }
                
        jQuery.noConflict();
        
        
        $.ajax({
            type: "POST",
            url: '<?php echo base_url() ?>cart/order_cart',
            data: data,
            success: function(response) {
                console.log(response);
                $('#error_message').html();
                sessionStorage.removeItem('to');
                sessionStorage.removeItem('to_hidden');
                sessionStorage.removeItem('from_hidden');
                
                window.location.href = "<?php echo base_url() ?>pages/order_view/" + JSON.parse(response).order_id;
            },
            error: function(error) {
                console.log(error);
                var error_message = JSON.parse(error.responseText);
                var first_error = Object.keys(error_message)[0];
                $('#error_message').html(error_message[first_error]);
            }
        });
    });

    $(document).ready(function() {
        // document.getElementById('comp_name').innerHTML = sessionStorage.getItem('from_company');
        $('#now').click(function() {
            if (this.checked) {
                $('.location').show();
                $('#when').show();
                $('#date_picker').hide();
                $('#table_order_destination').show();
                $('#room_order_destination').hide();
                $('#car_order_destination').hide();
            }
        });

        $('#drive').click(function() {
            if (this.checked) {
                $('.location').show();
                // $('#when').hide();
                $('#date_picker').hide();
                $('#car_order_destination').show();
                $('#table_order_destination').hide();
                $('#room_order_destination').hide();
            }
        });

        $('#room').click(function() {
            if (this.checked) {
                $('.table').show();
                $('.location').hide();
                // $('#when').hide();
                $('#date_picker').hide();
                $('#car_order_destination').hide();
                $('#table_order_destination').hide();
                $('#room_order_destination').show();
            }
        });

        <?php
            if(count($branches)==1){?>
            var branch_name = document.getElementById("vendor_id_select").innerHTML;
            $("#to_here_list").html(branch_name);
            $('.create_btn').removeAttr('disabled');
            $('#table_order_destination').hide();
            this.inputCheck();
        <?php }?>

        $('#vendor_id_select').click(function() {
            var branch_name = $('#vendor_id_select').find(":selected").text();
            $("#to_here_list").html(branch_name);
            $('.create_btn').removeAttr('disabled');
            inputCheck();
        });

        $('#telebirr').click(function() {
            $('#telebirr_input').show();
        });
        

        $('#payment_option').click(function() {
            $('#cash').click(function() {
                $('#telebirr_input').hide();
            });
        });

        $('#schedule').click(function() {
            if (this.checked) {
                $('#date_picker').show();
                $('#table_order_destination').hide();
                $('#room_order_destination').hide();
                $('#car_order_destination').hide();
            }
        });
    });
    location_list();
    function location_list(){
        if ($('#to_here_list').html() == '') {
            $('#location').show();
        }else{
            inputCheck();
            $('.create_btn').removeAttr('disabled');
        }
    }
    
</script>