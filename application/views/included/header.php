<!DOCTYPE html>
<html lang="zxx" dir="ltr">




<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<head>

    
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="description" content="">
    <meta name="author" content="">
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

    
    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo base_url() ?>assets/img/qr.png" />
    <link rel="icon" type="image/png" sizes="256x256"  href="<?php echo base_url() ?>assets/img/qr.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="<?php echo base_url() ?>assets/img/qr.png">    
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo base_url() ?>assets/img/qr.png" />
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo base_url() ?>assets/img/qr.png" />
    <link rel="icon" type="image/png" href="<?php echo base_url() ?>assets/img/qr.png"/>
    <link rel="mask-icon" href="<?php echo base_url() ?>assets/img/qr.png" color="#5bbad5" />
    <meta name="msapplication-TileColor" content="#990100" />
    <meta name="theme-color" content="#ffffff" />    

</head>


<body data-spy="scroll" data-target=".navbar" data-offset="50">

<div class="body-wrapper">
    <header id="header">
        <div class="navigation">
        
            <div class="navbar-container" data-spy="affix" data-offset-top="400" style="background-color: <?php echo $companies[0]->main_color; ?> ;">
                <div class="container">

                    <div class="navbar_top hidden-xs">
                        <div class="top_addr">
                            <span><i class="fa fa-map-marker" aria-hidden="true"></i> Addis Ababa, Bole around Edna Mall</span>
                            <span><i class="fa fa-clock-o" aria-hidden="true"></i> <?php echo $companies[0]->company_opening_hour; ?> - <?php echo $companies[0]->company_closing_hour; ?></span>
                            <div class="pull-right search-block">
                                <i class="fa fa-search" id="search" aria-hidden="true"></i>
                            </div>
                        </div>
                        <div id="navbar_search">
                            <form method="post">
                                <input type="text" name="q" class="form-control pull-left" value="" placeholder="Search your favorites food here">
                                <button type="submit" class="pull-right close" id="search_close"><i class="fa fa-close"></i></button>
                            </form>
                        </div>
                    </div>

                    <nav class="navbar">
                        <div id="navbar_content">

                            <div class="navbar-header">
                                <a class="navbar-brand" href="<?php echo base_url('menu/'.$this->session->userdata('menu_url')) ?>">
                                    <img src="<?php echo order_admin_URL ?><?php echo $companies[0]->company_logo; ?>" alt="logo" />
                                </a>
                                <a href="#cd-nav" class="cd-nav-trigger right_menu_icon">
                                    <span><i class="fa fa-bars" aria-hidden="true"></i></span>
                                </a>
                            </div>


                            <div class="collapse navbar-collapse" id="navbar">
                                <div class="navbar-right">
                                    <ul class="nav navbar-nav">
                                        <li class="<?=(current_url() == base_url('menu/'.$this->session->userdata('menu_url'))) ? 'active':''?>"><a class="page-scroll" href="<?php echo base_url('menu/'.$this->session->userdata('menu_url')) ?>">Menu</a></li>
                                        <li class="<?=(current_url() == base_url('/reservation')) ? 'active':''?>"><a class="page-scroll" href="<?php echo base_url('/reservation') ?>">Reservation</a></li>
                                        <li class="<?=(current_url() == base_url('/order-history')) ? 'active':''?>"><a class="page-scroll" href="<?php echo base_url('/order-history') ?>">Order History</a></li>
                                        <!-- <li><a class="page-scroll" href="#">Logout</a></li> -->
                                        <li>
                                            <a href="<?php echo base_url('/checkout') ?>"><i class="fa fa-shopping-cart"></i> My cart <sup><span class="badge badge-pill badge-default" id="cart_item_count"></span></sup></a>                                        
                                            <div class="cart-btn cart-dropdown" style="display: none;">
                                                
                                                <div class="cart-detail-box">
                                                    <div class="card">
                                                        <div class="card-header padding-15">Your Order</div>
                                                        <div class="card-body no-padding" id="cart-item">
                                                            
                                                        </div>
                                                        <div  id="trip_estimation" style="color: #444!important;font-weight:700;float:left"></div>
                                                        <div class="card-footer padding-15" id="go_cart_btn"> 
                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                        </div>
                    </nav>
                </div>

            </div>
        

        </div>

    </header>