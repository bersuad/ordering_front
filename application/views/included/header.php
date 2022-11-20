<!DOCTYPE html>
<html lang="zxx" dir="ltr">




<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<head>

    
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1, maximum-scale=1" />
    <meta url="<?php echo base_url('menu/'.$this->session->userdata('menu_url')) ?>">
    <title><?php echo $companies[0]->company_name; ?> | Powered By QRAnbessa</title>

    
    <link href="<?php echo base_url() ?>assets/css/bootstrap.min.css" type="text/css" rel="stylesheet" media="all" />
    <link href="<?php echo base_url() ?>assets/css/bootstrap-theme.min.css" type="text/css" rel="stylesheet" media="all" />
    <link href="<?php echo base_url() ?>assets/css/fonts.css" type="text/css" rel="stylesheet" />
    <link href="<?php echo base_url() ?>assets/css/font-awesome.min.css" type="text/css" rel="stylesheet" />
    <link href="<?php echo base_url() ?>assets/css/slick.css" type="text/css" rel="stylesheet" />
    <link href="<?php echo base_url() ?>assets/css/slick-theme.css" type="text/css" rel="stylesheet" />
    <link href="<?php echo base_url() ?>assets/css/aos.css" type="text/css" rel="stylesheet" />
    <link href="<?php echo base_url() ?>assets/css/scrolling-nav.css" type="text/css" rel="stylesheet" />
    <link href="<?php echo base_url() ?>assets/css/bootstrap-datepicker.css" type="text/css" rel="stylesheet" />
    <link href="<?php echo base_url() ?>assets/css/bootstrap-datetimepicker.css" type="text/css" rel="stylesheet" />
    <link href="<?php echo base_url() ?>assets/css/touch-sideswipe.css" type="text/css" rel="stylesheet" />
    <link href="<?php echo base_url() ?>assets/css/jquery.fancybox.css" type="text/css" rel="stylesheet" />
    <link href="<?php echo base_url() ?>assets/css/main.css" type="text/css" rel="stylesheet" />
    <link href="<?php echo base_url() ?>assets/css/responsive.css" type="text/css" rel="stylesheet" />
    <link href="<?php echo base_url() ?>assets/simplepicker.css" rel="stylesheet" media="screen">
    
    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo order_admin_URL ?><?php echo $companies[0]->company_logo; ?>" />
    <link rel="icon" type="image/png" sizes="256x256"  href="<?php echo order_admin_URL ?><?php echo $companies[0]->company_logo; ?>">
    <link rel="icon" type="image/png" sizes="192x192"  href="<?php echo order_admin_URL ?><?php echo $companies[0]->company_logo; ?>">    
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo order_admin_URL ?><?php echo $companies[0]->company_logo; ?>" />
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo order_admin_URL ?><?php echo $companies[0]->company_logo; ?>" />
    <link rel="icon" type="image/png" href="<?php echo order_admin_URL ?><?php echo $companies[0]->company_logo; ?>"/>
    <link rel="mask-icon" href="<?php echo order_admin_URL ?><?php echo $companies[0]->company_logo; ?>" color="#5bbad5" />
    <style>
        .top_addr i.fa {
            color:<?php echo $companies[0]->second_color; ?>;
        }

        .navbar-nav>li.active>a {
            color:<?php echo $companies[0]->second_color; ?>;
            border-bottom: 1px solid <?php echo $companies[0]->second_color; ?>;
        }

        .top_addr span{
            color:<?php echo $companies[0]->second_color; ?>;
        }

        .nav > li > a:focus, .nav > li > a:hover{
            color: <?php echo $companies[0]->second_color; ?>;
            border-bottom: 1px solid <?php echo $companies[0]->second_color; ?>;
        }
        .create_btn{
            color:<?php echo $companies[0]->second_color; ?>;
            background-color: <?php echo $companies[0]->main_color; ?>;
        }

        .create_btn:hover { 
            color:<?php echo $companies[0]->main_color; ?>;
            background-color: <?php echo $companies[0]->second_color; ?>;
        }

        .nav > li > a{
            color:<?php echo $companies[0]->second_color; ?>;
        }

        .menu_filter .item a:focus,
        .menu_filter .item a:hover {
            color:<?php echo $companies[0]->main_color; ?>;
            border-color: <?php echo $companies[0]->second_color; ?>;
            background-color: <?php echo $companies[0]->second_color; ?>;
        }
        .menu_filter .item a {
            color: #000;
            border-color: rgba(0,0,0,0.2);
        }
        .menu_filter .item.active a {
            color:<?php echo $companies[0]->main_color; ?>;
            border-color: <?php echo $companies[0]->second_color; ?>;
            background-color: <?php echo $companies[0]->second_color; ?>;
            filter: drop-shadow(1px 1px 2px <?php echo $companies[0]->main_color; ?>);
            font-weight: bold;
        }


        .form_pos .form-control{
            color:<?php echo $companies[0]->second_color; ?>!important;
        }

        .form_pos .form-control::placeholder{ 
            color:<?php echo $companies[0]->second_color; ?>!important;
            opacity: 1;
        }

        .reserv_box h1{
            color:<?php echo $companies[0]->second_color; ?>;
        }

        .reserv_box p{
            color:<?php echo $companies[0]->second_color; ?>;
        }

        .add_to_cart{
            background-color: <?php echo $companies[0]->main_color; ?>!important; 
            color:<?php echo $companies[0]->second_color; ?>!important; 
            border: 1px solid <?php echo $companies[0]->second_color; ?>!important;
        }

        .add_to_cart:hover{
            background-color: <?php echo $companies[0]->second_color; ?>!important; 
            color:<?php echo $companies[0]->main_color; ?>!important; 
            border: 1px solid <?php echo $companies[0]->main_color; ?>!important;
        }

        #reserv_form .btn[type="submit"] {
            color:<?php echo $companies[0]->main_color; ?>;
            border-color: <?php echo $companies[0]->second_color; ?>;
            background-color: <?php echo $companies[0]->second_color; ?>;
        }

        #reserv_form .btn[type="submit"] :hover{
            color:<?php echo $companies[0]->second_color; ?>!important;
            border-color: <?php echo $companies[0]->main_color; ?>!important;
            background-color: <?php echo $companies[0]->main_color; ?>!important;
        }

        #reserv_form textarea.form-control {
            color:<?php echo $companies[0]->second_color; ?>;
            border-color: <?php echo $companies[0]->second_color; ?>;
        }

        #reserv_form textarea::placeholder{ 
            color:<?php echo $companies[0]->second_color; ?>!important;
        }

        .reserv_box{
            background-color: <?php echo $companies[0]->main_color; ?>!important;
        }
        .top_addr span i{
            color:<?php echo $companies[0]->second_color; ?>;
        }
        .right_menu_icon span i{
            color:<?php echo $companies[0]->second_color; ?>;
        }
        .rmenu_list li a{
            color:<?php echo $companies[0]->second_color; ?>;
        }
    </style>
</head>


<body data-spy="scroll" data-target=".navbar" data-offset="50">

<div class="body-wrapper">
<div id="cover-spin"></div>
    <header id="header">
        <div class="navigation">
        
            <div class="navbar-container" data-spy="affix" data-offset-top="400" style="background-color: <?php echo $companies[0]->main_color; ?> ;">
                <div class="container">

                    <div class="navbar_top hidden-xs">
                        <div class="top_addr">
                            <span><i class="fa fa-map-marker" aria-hidden="true"></i> <?php echo $companies[0]->location; ?> </span>
                            <span><i class="fa fa-clock-o" aria-hidden="true"></i> <?php echo $companies[0]->company_opening_hour; ?> - <?php echo $companies[0]->company_closing_hour; ?></span>
                            <div class="pull-right search-block">
                                <i class="fa fa-search" id="search" aria-hidden="true"></i>
                            </div>
                        </div>
                        <div id="navbar_search">
                            <form>
                                    
                                <input style="color: <?php echo $companies[0]->second_color; ?>;" type="text" name="name" class="form-control pull-left" value="" placeholder="Search your favorites food here" id="search_food" autocomplete="off"/>

                                <button type='reset' value='Reset' name='reset' class="pull-right close" id="search_close" onclick="return resetForm(this.form);"><i class="fa fa-close"></i></button>
                            </form>
                        </div>
                    </div>

                    <nav class="navbar">
                        <div id="navbar_content">

                            <div class="navbar-header">
                                <a class="navbar-brand" href="<?php echo base_url('menu/'.$this->session->userdata('menu_url')) ?>">
                                    <img src="<?php echo order_admin_URL ?><?php echo $companies[0]->company_logo; ?>" alt="logo" />
                                </a>
                                <a href="<?php echo base_url('/checkout') ?>" id="mobile-count-view">
                                    <span><i class="fa fa-shopping-cart fa-lg" style="font-size: 1.em; color:<?php echo $companies[0]->second_color; ?>;"></i> <sup><span class="badge badge-pill badge-default" id="mobile_cart_item_count"></span></sup></span>
                                </a>
                                <a href="#cd-nav" class="cd-nav-trigger right_menu_icon">
                                    <span><i class="fa fa-bars" aria-hidden="true"></i></span>
                                </a>
                            </div>


                            <div class="collapse navbar-collapse" id="navbar">
                                <div class="navbar-right">
                                    <ul class="nav navbar-nav">
                                        <li class="<?=(current_url() == base_url('menu/'.$this->session->userdata('menu_url'))) ? 'active':''?>"><a onclick="$('#cover-spin').show(0)" class="page-scroll" href="<?php echo base_url('menu/'.$this->session->userdata('menu_url')) ?>">Menu</a></li>
                                        <li class="<?=(current_url() == base_url('/reservation')) ? 'active':''?>"><a onclick="$('#cover-spin').show(0)" class="page-scroll" href="<?php echo base_url('/reservation') ?>">Reservation</a></li>
                                        <?php if($this->session->userdata('logged_in') == true){?>
                                            <li class="<?=(current_url() == base_url('/order-history')) ? 'active':''?>"><a class="page-scroll" href="<?php echo base_url('/order-history') ?>">Order History</a></li>    
                                        <?php }?>
                                        <!-- <li><a class="page-scroll" href="#">Logout</a></li> -->
                                        <li>
                                            <a onclick="$('#cover-spin').show(0)" href="<?php echo base_url('/checkout') ?>"><i class="fa fa-shopping-cart"></i> cart <sup><span class="badge badge-pill badge-default" id="cart_item_count"></span></sup></a>                                        
                                            <div class="cart-btn cart-dropdown" style="display: none;">
                                                
                                                <div class="cart-detail-box">
                                                    <div class="card">
                                                        <div class="card-header padding-15">Your Order</div>
                                                        <div class="card-body no-padding" id="cart-item">
                                                            
                                                        </div>
                                                        <div  id="trip_estimation" style="color: <?php echo $companies[0]->second_color; ?>!important;font-weight:700;float:left"></div>
                                                        <div class="card-footer padding-15" id="go_cart_btn"> 
                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <?php if($this->session->userdata('logged_in') == true){?>
                                        <li><a class="page-scroll" href="<?php echo base_url('cart/logout')?>" id="login" > <i class="fa fa-log-out"></i>
                                                <span>LOG OUT</span>
                                            </a>
                                        </li>
                                        <?php }else{?>
                                            <li>
                                                <a class="page-scroll" href="#" data-toggle="modal" data-target="#loginModal"> <i class="fa fa-log-in"></i>
                                                    <span>Login</span>
                                                </a>
                                            </li>
                                        <?php }?>
                                    </ul>
                                </div>
                            </div>

                        </div>
                    </nav>
                </div>

            </div>
        

        </div>

    </header>