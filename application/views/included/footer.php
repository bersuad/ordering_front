    </div>

    <nav class="cd-nav-container right_menu" id="cd-nav" style="background-color: <?php echo $companies[0]->main_color; ?> ;">
        <div class="header__open_menu">
            <a href="<?php echo base_url('menu/'.$this->session->userdata('restaurant_id')) ?>" class="rmenu_logo" title="">
                <img src="<?php echo order_admin_URL ?><?php echo $companies[0]->company_logo; ?>" alt="logo" style="max-width: 80px; height:auto;"/>
            </a>
        </div>
        <div class="right_menu_search">
            <form method="post">
                <input type="text" name="q" class="form-control search_input" value="" placeholder="Search anything">
                <button type="submit" class="search_icon"><i class="fa fa-search"></i></button>
            </form>
        </div>
        <ul class="rmenu_list">
            <li class="<?=(current_url() == base_url('menu/'.$this->session->userdata('restaurant_id'))) ? 'active':''?>"><a class="page-scroll" href="<?php echo base_url('menu/'.$this->session->userdata('restaurant_id')) ?>">Menu</a></li>
            <li class="<?=(current_url() == base_url('/reservation')) ? 'active':''?>"><a class="page-scroll" href="<?php echo base_url('/reservation') ?>">Reservation</a></li>
            <li class="<?=(current_url() == base_url('/order_history')) ? 'active':''?>"><a class="page-scroll" href="<?php echo base_url('/order_history') ?>">Order History</a></li>
            <!-- <li><a class="page-scroll" href="#about_us">Logout</a></li> -->
            <li>
                <a href="<?php echo base_url('/checkout') ?>"><i class="fa fa-shopping-cart"></i> My cart &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<sup><span class="badge badge-pill badge-default" style="width:30px; height:auto;"><small id="mobile_cart_item_count"></small></span></sup></a>
            </li>
        </ul>
        <div class="right_menu_addr top_addr">
            <span><i class="fa fa-map-marker" aria-hidden="true"></i> Addis Ababa, Bole around Edna Mall</span>
            <span><i class="fa fa-clock-o" aria-hidden="true"></i> <?php echo $companies[0]->company_opening_hour; ?> - <?php echo $companies[0]->company_closing_hour; ?></span>
        </div>
    </nav>

    <div class="cd-overlay"></div>
    
    <script type="text/javascript" src="<?php echo base_url() ?>assets/js/jquery-2.1.1.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url() ?>assets/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url() ?>assets/js/jquery.mousewheel.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url() ?>assets/js/jquery.easing.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url() ?>assets/js/scrolling-nav.js"></script>
    <script type="text/javascript" src="<?php echo base_url() ?>assets/js/aos.js"></script>
    <script type="text/javascript" src="<?php echo base_url() ?>assets/js/slick.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url() ?>assets/js/jquery.touchSwipe.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url() ?>assets/js/moment.js"></script>
    <script type="text/javascript" src="<?php echo base_url() ?>assets/js/bootstrap-datepicker.js"></script>
    <script type="text/javascript" src="<?php echo base_url() ?>assets/js/bootstrap-datetimepicker.js"></script>
    <script type="text/javascript" src="<?php echo base_url() ?>assets/js/jquery.fancybox.js"></script>
    <script type="text/javascript" src="<?php echo base_url() ?>assets/js/loadMoreResults.js"></script>
    <script type="text/javascript" src="<?php echo base_url() ?>assets/js/main.js"></script>
    <script type="text/javascript" src="<?php echo base_url() ?>assets/simplepicker.js"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/js/bootstrap-notify.js'); ?>" ></script>
    
    <script>
      var notify = {
        showNotification: function(from, align, color, message){

          $.notify({
            icon: "ti-bell",
            message: message

          },{
            type: color,
            timer: 4000,
            placement: {
              from: from,
              align: align
            },
	          offset: {
              x: 5,
              y: 50,
            },
          });
        }
      };
      <?php if ($this->session->flashdata('reservation_added')) {?>
        notify.showNotification('top', 'right', 'success', "<h5 style='color: white'><?php echo "You have successfully made a reservation, Thank  you!" ?></h5>");
      <?php }?>
    </script>
    <script>
        $(document).ready(function() {
            cartAction('', '');
        })
    </script>
    <script>
        function cartAction(action, product_code) {
            
            var extra = document.getElementById("daynamic_field_"+product_code);
            
            if (extra != null) {
                str = extra.innerText;
            }
            else {
                str = '';
            }

            var queryString = "";
            if (action != "") {
                switch (action) {
                    case "add":
                        $("#add_" + product_code).attr('disabled', true);
                        queryString = 'action=' + action + '&code=' + product_code + '&quantity=' + $("#qty_" + product_code).html() + '&price_point=' + $('#price_point' + product_code).html() + '&branch=' + $('#branch_' + product_code).html() + '&comment=' + $('#comment_' + product_code).val() + '&extra=' + str;
                        break;
                    case "remove":
                        $("#add_" + product_code).removeAttr('disabled');
                        queryString = 'action=' + action + '&code=' + product_code;
                        break;
                    case "empty":
                        $("#add_" + product_code).removeAttr('disabled');
                        queryString = 'action=' + action;
                        break;
                }
            }

            jQuery.ajax({
                url: "<?php echo base_url() ?>cart/product_cart",
                data: queryString,
                type: "POST",
                success: function(data) {
                    // jQuery.noConflict();

                    $("#cart-item").empty();
                    $("#check_list_cart").empty();
                    $("#mobile_list_cart").empty();

                    $("#cart-item").append(render(data));
                    $("#check_list_cart").append(render(data));
                    $("#mobile_list_cart").append(render(data));
                    var cart_length = $('#cart-item .cart_item_item').length;
                    $('#cout_cart').text(cart_length);
                    $('#cart_item_count').text($('#cart-item .cart_item_item').length);
                    $('#mobile_cart_item_count').text(cart_length);
                    console.log(cart_length);
                    
                    // window.close();
                    // $('#modalQuickView'+product_code).modal('hide');
                    
                    $('#modalQuickView'+product_code).modal('hide');
                    // event.preventDefault();
                    
                    if (action != "") {

                        switch (action) {
                            case "add":
                                $("#add_" + product_code).hide();
                                $("#added_" + product_code).show();
                                break;
                            case "remove":
                                $("#add_" + product_code).show();
                                $("#added_" + product_code).hide();
                                $("#add_" + product_code).removeAttr('disabled');
                                break;
                            case "empty":
                                $(".btnAddAction").show();
                                $(".btnAdded").hide();
                                $("#add_" + product_code).removeAttr('disabled');
                                break;
                        }
                    }
                },
                error: function() {}
            });
        }
        function render(content) {
            return content;
        }
    </script>
    <script>
        let simplepicker = new SimplePicker({
            zIndex: 10
        });
        const $button = document.getElementById("btn_clander");
        const $eventLog = document.querySelector('#order_time');

        if ($button !== null) {
            $button.addEventListener('click', (e) => {
                simplepicker.open();
            });
        }

        simplepicker.on('submit', (date, readableDate) => {
            document.getElementById("order_time").innerHTML = readableDate;
        });

        simplepicker.on('close', (date) => {
            $eventLog.innerHTML += '' + '\n';
        });
        var $main_window=$(window);
        $main_window.on("scroll", function() {
            if($(this).scrollTop()>250) {
                $(".back-to-top").fadeIn(200);
            }
            else {
                $(".back-to-top").fadeOut(200);
            }
        });
        $(".back-to-top").on("click", function() {
            $("html, body").animate( {
                scrollTop: 0
            }
            , "slow");
            return false;
        });
    </script>

</body>

</html> 