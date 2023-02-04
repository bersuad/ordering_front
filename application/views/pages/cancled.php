<div class="container section" id="menu" data-aos="fade-up">
    <div aria-label="breadcrumb" class="breadcrumb-nav mt-10">
        <div class="container">
            <h3 align="center">Canceling Order?</h3>
        </div>
    </div>
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-4"></div>
            <div class="col-md-4">
                <img src="<?php echo base_url() ?>assets/img/cancle.gif" style="height: 200px; width:auto; display: block; margin-left: auto; margin-right: auto;"/>
                <h3 align="center">Do you want to cancel the order?</h3>
                <p style="text-align: center;">If there is any thing that you are not comfortable with the order.</p>
                <div align="center">
                    <p style="text-align: center; max-width:300px; height: 50px;"><a href="<?php echo base_url('checkout') ?>" class="btn btn-first btn-block filter-button add_to_cart">No</a></p>
                    <p style="text-align: center; max-width:300px; color:<?php echo $companies[0]->second_color; ?>;"><a href="<?php echo base_url('menu/'.$this->session->userdata('menu_url')) ?>" class="btn btn-secondary btn-block" style="color:<?php echo $companies[0]->main_color; ?>; border: 1px solid <?php echo $companies[0]->main_color; ?>;">Yes</a></p>
                </div>
            </div>
            <div class="col-md-4"></div>
        </div>
    </div>
</div>