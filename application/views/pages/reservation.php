<div class="fixed_layer section" id="reservation">
    <div class="fixed_layer_padd container">
        <div class="row">
            <div class="col-md-offset-3 col-md-6" data-aos="fade-down">
                <div class="reserv_box mt-100">
                    <h1 class="section-title title_sty1">Table reservation</h1>
                    <p class="short">Make table reservation at <strong><?php echo $companies[0]->company_name; ?></strong>. </p>
                    <?php echo form_open('pages/addReservation') ?>
                        <div id="reserv_form">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group form_pos">
                                        <input type="text" name="reservation_name" required="" placeholder="Your name" class="form-control" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Your name'" />
                                        <span class="form_icon"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group form_pos">
                                        <input type="text" name="reservation_phone" required="" placeholder="Phone" class="form-control" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Phone'"   oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" />
                                        <span class="form_icon"></span>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group form_pos">
                                        <input type="text" name="reservation_date" required="" placeholder="Date" class="form-control" id="reserv_date" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Date'" />
                                        <span class="form_icon"></span>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group form_pos">
                                        <input type="text" name="reservation_time" required="" placeholder="Time" class="form-control" id="reserv_time" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Time'" />
                                        <span class="form_icon"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group form_pos">
                                        <select name="reservation_num_people" class="form-control" style="color:black;">
                                            <option value="">Number of Gustes</option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                        </select>
                                        <span class="form_icon"></span>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group form_pos">
                                        <select name="reservation_branch" class="form-control" style="color:black;" require>
                                            <option value="">Branch</option>;
                                            <?php foreach ($branches as $branch) {
                                                echo '<option value="' . $branch->branch_id . '">' . $branch->branch_name . '</option>';
                                            }
                                            ?>    
                                        </select>
                                        <span class="form_icon"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <textarea rows="3" name="reservation_message" placeholder="Message" class="form-control" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Message'"></textarea>
                            </div>
                            <input type="submit" name="send" value="book now" class="btn btn-block" />

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>