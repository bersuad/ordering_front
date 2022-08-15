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
                                        <input type="text" name="reservation_name" required="" placeholder="Paste the code here" class="form-control" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Paste the code here'" />
                                        <span class="form_icon"></span>
                                    </div>
                                </div>
                            </div>

                            <input type="submit" name="send" value="Verify" class="btn btn-block" onclick="$('#cover-spin').show(0)"/>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>