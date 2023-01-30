<div class="fixed_layer section" id="reservation">
    <div class="fixed_layer_padd container">
        <div class="row">
            <div class="col-md-offset-3 col-md-6" data-aos="fade-down">
                <div class="reserv_box mt-100">
                    <h1 class="section-title title_sty1">Verify</h1>
                    <p class="short">A text message has been sent to your phone.</strong>. </p>
                        <?php echo form_open('pages/verify') ?>
                        <div id="reserv_form">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group form_pos">
                                        <input autocomplete="off" type="text" name="reservation_name" required="" placeholder="Paste the code here" class="form-control" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Paste the code here'" maxlength="4" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" required=""/>
                                        <span class="form_icon"></span>
                                    </div>
                                </div>
                            </div>

                            <input type="submit" name="send" value="Verify" class="btn btn-block"/>

                        </form>
                        </div>
                        <div class="form-group text-center text-danger">
                            <div align="center" id="registerLink"><br/><br/>
                                <b style="color: #fff;"><span>Didn't get the verification code?</span></b><br>
                                <b style="color: #fff;"><span id="time" style="color: <?php echo $companies[0]->second_color; ?>;"></span></b><br/>
                                <?php $phone = $this->session->userdata('phone_no'); ?>
                                <form action="<?php echo base_url('pages/sms_send/').$phone?>" method="post">
                                    <button type="submit" class="btn btn-block add_to_cart verify_code" style="background-color: <?php echo $companies[0]->main_color; ?> ; color:#fff;">Get New Code</button>                            
                                </form>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="<?php echo base_url() ?>assets/js/jquery-2.1.1.min.js"></script>
<script>
    startTimer();
    function startTimer(duration, display) {
        $('.verify_code').prop('disabled', true);
        var timer = duration, minutes, seconds;
        setInterval(function () {
            minutes = parseInt(timer / 60, 10)
            seconds = parseInt(timer % 60, 10);

            minutes = minutes < 10 ? "0" + minutes : minutes;
            seconds = seconds < 10 ? "0" + seconds : seconds;

            display.text(minutes + ":" + seconds);

            if (--timer < 0) {
                timer = 00;
                $('.verify_code').prop('disabled', false);
            }
        }, 1000);
    }

    jQuery(function ($) {
        var fiveMinutes = 60 * 1,
            display = $('#time');
        startTimer(fiveMinutes, display);
    });
</script>