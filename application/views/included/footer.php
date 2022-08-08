    </div>

    <nav class="cd-nav-container right_menu" id="cd-nav" style="background-color: <?php echo $companies[0]->main_color; ?> ;">
        <div class="header__open_menu">
            <a href="<?php echo base_url('menu/'.$this->session->userdata('menu_url')) ?>" class="rmenu_logo" title="">
                <img src="<?php echo order_admin_URL ?><?php echo $companies[0]->company_logo; ?>" alt="logo" style="max-width: 80px; height:auto;"/>
            </a>
        </div>
        <!-- <div class="right_menu_search">
            <form method="post">
                <input type="text" name="q" class="form-control search_input" value="" placeholder="Search anything">
                <button type="submit" class="search_icon"><i class="fa fa-search"></i></button>
            </form>
        </div> -->
        <ul class="rmenu_list">
            <li onclick="$('#cover-spin').show(0)" class="<?=(current_url() == base_url('menu/'.$this->session->userdata('restaurant_id'))) ? 'active':''?>"><a class="page-scroll" href="<?php echo base_url('menu/'.$this->session->userdata('menu_url')) ?>">Menu</a></li>
            <li onclick="$('#cover-spin').show(0)" class="<?=(current_url() == base_url('/reservation')) ? 'active':''?>"><a class="page-scroll" href="<?php echo base_url('/reservation') ?>">Reservation</a></li>
            
            <?php if($this->session->userdata('logged_in') == true){?>
                <li class="<?=(current_url() == base_url('/order_history')) ? 'active':''?>">
                    <a onclick="$('#cover-spin').show(0)" class="page-scroll" href="<?php echo base_url('/order_history') ?>">Order History</a>
                </li>
                <li>
                    <a onclick="$('#cover-spin').show(0)" href="<?php echo base_url('cart/logout')?>"> 
                        <i class="fas fa-log-in"></i>Log out
                    </a>
                </li>
            <?php }?>
        </ul>
        <div class="right_menu_addr top_addr">
            <span><i class="fa fa-map-marker" aria-hidden="true"></i> Addis Ababa, Bole around Edna Mall</span>
            <span><i class="fa fa-clock-o" aria-hidden="true"></i> <?php echo $companies[0]->company_opening_hour; ?> - <?php echo $companies[0]->company_closing_hour; ?></span>
        </div>
    </nav>

    <?php 
      if(current_url() != base_url('/checkout')){?>
    <a onclick="$('#cover-spin').show(0)" href="<?php echo base_url('/checkout') ?>">
      <div id="cart_hover_btn" style="background-color: <?php echo $companies[0]->main_color; ?> ; color: <?php echo $companies[0]->second_color; ?>; "></div>
    </a>
    <?php }?>

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
            timer: 8000,
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
        notify.showNotification('top', 'center', 'success', "<h5 style='color: white'><?php echo "You have successfully made a reservation, Thank  you!" ?></h5>");
      <?php }?>

      <?php if ($this->session->flashdata('no_service')) {?>
        notify.showNotification('top', 'center', 'warning', "<h5 style='color: black'><?php echo "Our company haven't start any service yet please come back again some other time, Thank  you!" ?></h5>");
      <?php }?>

      $(document).ready(function() {
            cartAction('', '');
        })
    </script>
    <script type="text/javascript">
        function cartAction(b,a){var d=document.getElementById("daynamic_field_"+a),e=document.getElementById("daynamic_size_"+a),f=document.getElementById("original_price"+a), g=document.getElementById("choose_field_"+a);str=null!=d?d.innerText:"",size_str=null!=e?e.innerText:"",choose_str=null!=g?g.innerText:"";var c="";if(""!=b)switch(b){case"add":$('#cover-spin').show(0); $("#add_"+a).attr("disabled",!0),c="action="+b+"&code="+a+"&quantity="+$("#qty_"+a).html()+"&price_point="+$("#price_point"+a).html()+"&branch="+$("#branch_"+a).html()+"&comment="+$("#comment_"+a).val()+"&extra="+str+"&size="+size_str+"&choose_group="+choose_str+"&ori_price="+f.value;break;case"remove":$('#cover-spin').show(0); $("#add_"+a).removeAttr("disabled"),c="action="+b+"&code="+a;break;case"empty":$("#add_"+a).removeAttr("disabled"),c="action="+b}$("#modalQuickView"+a).modal("hide"),jQuery.ajax({url:"<?php echo base_url() ?>cart/product_cart",data:c,type:"POST",success:function(c){$('#cover-spin').hide(0); $("#cart-item").empty(),$("#check_list_cart").empty(),$("#mobile_list_cart").empty(),$("#cart-item").append(render(c)),$("#check_list_cart").append(render(c)),$("#mobile_list_cart").append(render(c));var d=$("#cart-item .cart_item_item").length;
          var cart_length = $('#cart-item .cart_item_item').length;
          if (cart_length <= 0) {
            $('#cart_hover_btn').css({"display":"none"});
          } else {
            $('#cart_hover_btn').html("<h4 style='padding-top: 5px;'><i class='fa fa-shopping-cart'></i> To your cart <span style='background:<?php echo $companies[0]->second_color; ?>; color: <?php echo $companies[0]->main_color; ?>;' class='badge badge-pill'>"+ cart_length)+"</span></h4>";
            $('#cart_hover_btn').css({"display":"block"});
          }
          if($("#cout_cart").text(d),$("#cart_item_count").text($("#cart-item .cart_item_item").length),$("#mobile_cart_item_count").text(d),""!=b)switch(b){case"add":$("#add_"+a).hide(),$("#added_"+a).show();break;case"remove":$("#add_"+a).show(),$("#added_"+a).hide(),$("#add_"+a).removeAttr("disabled");break;case"empty":$(".btnAddAction").show(),$(".btnAdded").hide(),$("#add_"+a).removeAttr("disabled")}},error:function(){}})}function render(a){return a}
    </script>
    <script>
        let simplepicker=new SimplePicker({zIndex:10});const $button=document.getElementById("btn_clander"),$eventLog=document.querySelector("#order_time");null!==$button&&$button.addEventListener("click",a=>{simplepicker.open()}),simplepicker.on("submit",(b,a)=>{document.getElementById("order_time").innerHTML=a}),simplepicker.on("close",a=>{$eventLog.innerHTML+="\n"});var $main_window=$(window);$main_window.on("scroll",function(){$(this).scrollTop()>250?$(".back-to-top").fadeIn(200):$(".back-to-top").fadeOut(200)}),$(".back-to-top").on("click",function(){return $("html, body").animate({scrollTop:0},"slow"),!1})
    </script>

</body>

</html> 