<!DOCTYPE html>
<html lang="zxx" dir="ltr">

<!-- BEGIN head -->


<head>

    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="QR Anbessa is a digital QR menu solution provider in Addis Ababa, Ethiopia and with QRAnbessa it will be easy to provide a digital product list to your clients" />
    <meta property="og:locale" content="en_US" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="A digital QR menu solution provider and software solutions to restaurants and hotels in Ethiopia | QR Anbessa" />
    <meta property="og:description" content="QRAnbessa is a digital QR menu solution provider in Ethiopia and with QRAnbessa it will be easy to provide a digital product list to your clients and it is easy to get client feedback on your services." />
    <meta property="og:description" content="#1 Smart QR Menu No App to download, No Hardware to install, and a zero headache setup experience, you can have [&hellip;] in Ethiopia." />
    <meta property="og:url" content="https://qranbessa.com/" />
    <meta property="og:site_name" content="QR Anbessa" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <meta name="keywords" content="QR Anbessa Menu, Ethiopia Online Menu">
    <title>QR Anbessa | The first digital QR menu solution provider in Addis Ababa, Ethiopia.</title>


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


    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo base_url() ?>assets/img/qr.png" />
    <link rel="icon" type="image/png" sizes="256x256"  href="<?php echo base_url() ?>assets/img/qr.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="<?php echo base_url() ?>assets/img/qr.png">    
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo base_url() ?>assets/img/qr.png" />
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo base_url() ?>assets/img/qr.png" />
    <link rel="icon" type="image/png" href="<?php echo base_url() ?>assets/img/qr.png"/>
    <meta name="msapplication-TileColor" content="#990100" />
    <meta name="theme-color" content="#ffffff" />    

</head>


<body data-spy="scroll" data-target=".navbar" data-offset="50">


<section class="final-order section-padding bg-light-theme" style="margin-top: 80px;">
    <div class="container">
        <div class="row">
            <div class="col-lg-2">
            </div>
            <div class="col-lg-8">
                <div class="main-box padding-20">
                        <div align="center">
                            <img src="<?php echo base_url() ?>assets/img/qr.png" alt="logo"  style="height: 100px; width:auto; border-radius: 10px;"/>
                        </div>
                        <br/>
                </div>
            </div>
            <div class="col-lg-2"></div>  
        </div>
        <div class="title-block">
            <h1 class="section-title" style="color: #282828;">Sorry we can't find that!</h1>
        </div>  
    </div>
</section>
<div class="container section" id="menu" data-aos="fade-up" style="margin-top: 100px;">
    <div class="title-block">
        <h3 class="section-title" style="color: #1f1f1f;">Here is what we have</h3>
    </div>

    <div id="menu_items">
        <div class="row">
            <?php
                foreach($companies as $key => $comp){
            ?>
            <div class="col-sm-6 col-md-4 col-lg-4 col-xs-6 list-of-items">
                <a href="<?php echo base_url() .'menu/'. $comp->url_name; ?>">
                    <div class="content">
                        <div class="filter_item_img">
                            <img src="<?php echo order_admin_URL; ?><?php echo $comp->company_logo; ?>" alt="sample" />
                        </div>
                        <div class="info" style="margin-top: 50px;">
                            <div class="name"><?php echo $comp->company_name ?></div>
                        </div>
                    </div>
                </a>
            </div>
            <?php }?>
        </div>
    </div>

</div>
<div>
    <div class="title-block" style="margin-top: 30px; margin-bottom:-10px;">
        <h1 class="section-title" style="color: #1f1f1f;">Our Address</h1>
    </div>
    <footer id="footer">
        <div class="section" id="contact">
            <div id="googleMap"><iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d7881.124604283896!2d38.788873!3d9.01236!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zOcKwMDAnNDQuNSJOIDM4wrA0NycxOS45IkU!5e0!3m2!1sen!2set!4v1627825907075!5m2!1sen!2set" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe></div> 
            <div class="footer_pos">
                <div class="container">
                    <div class="footer_content">
                        <div class="row">
                            <div class="col-sm-6 col-md-6">
                                <h4 class="footer_ttl footer_ttl_padd">about us</h4>
                                <p class="footer_txt">QR Anbessa provides software solutions to restaurants and hotels to help improve operations, increase sales, create a better guest experience, and much much more. </p>
                            </div>
                            <div class="col-sm-6 col-md-6">
                                <h4 class="footer_ttl footer_ttl_padd">contact us</h4>
                                <div class="footer_border">
                                    <div class="footer_cnt">
                                        <i class="fa fa-map-marker"></i>
                                        <span>Ethiopia - ADDIS ABABA,HAYA HULET AREA TSEGA BUSINESS CENTER 10TH FLOOR K-06</span>
                                    </div>
                                    <div class="footer_cnt">
                                        <i class="fa fa-phone"></i>
                                        <span>0942396405</span>
                                    </div>
                                    <div class="footer_cnt">
                                        <i class="fa fa-envelope"></i>
                                        <span>info@anbessaitsolutions.com</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="copyright">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="copy_text">
                                    <a target="_blank" href="https://www.qranbessa.net" style="text-decoration: none; color: #6D6D6D;">Anbessa IT Solutions</a>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="social-links">
                                    <ul class="list-inline">
                                        <li class="list-inline-item">
                                            <a href="https://www.facebook.com/QR-Anbessa-105611898101905" title="">
                                                <i class="fa fa-facebook" aria-hidden="true"></i>
                                            </a>
                                        </li>
                                        <li class="list-inline-item">
                                            <a href="https://www.instagram.com/qranbessa/" title="">
                                                <i class="fa fa-instagram" aria-hidden="true"></i>
                                            </a>
                                        </li>
                                        <li class="list-inline-item">
                                            <a href="https://twitter.com/QRAnbessa" title="">
                                                <i class="fa fa-twitter" aria-hidden="true"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</div>


<script src="<?php echo base_url() ?>assets/js/jquery-2.1.1.min.js"></script>
    <script src="<?php echo base_url() ?>assets/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url() ?>assets/js/jquery.mousewheel.min.js"></script>
    <script src="<?php echo base_url() ?>assets/js/jquery.easing.min.js"></script>
    <script src="<?php echo base_url() ?>assets/js/scrolling-nav.js"></script>
    <script src="<?php echo base_url() ?>assets/js/aos.js"></script>
    <script src="<?php echo base_url() ?>assets/js/slick.min.js"></script>
    <script src="<?php echo base_url() ?>assets/js/jquery.touchSwipe.min.js"></script>
    <script src="<?php echo base_url() ?>assets/js/moment.js"></script>
    <script src="<?php echo base_url() ?>assets/js/bootstrap-datepicker.js"></script>
    <script src="<?php echo base_url() ?>assets/js/bootstrap-datetimepicker.js"></script>
    <script src="<?php echo base_url() ?>assets/js/jquery.fancybox.js"></script>
    <script src="<?php echo base_url() ?>assets/js/loadMoreResults.js"></script>
    <script src="<?php echo base_url() ?>assets/js/main.js"></script>

</body>


</html> 