
<div class="fixed_layer section" id="reservation">
    <div class="fixed_layer_padd container">
        <div class="row">
            <div class="col-md-offset-3 col-md-6" data-aos="fade-down">
                <div class="reserv_box mt-100">
                    <h1 class="section-title title_sty1">Table reservation</h1>
                    <p class="short">Lorem Ipsum is simply dummy text of the printing and typesetting industry. </p>
                    <form id="reserv_form" method="post">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group form_pos">
                                    <input type="text" name="name" required="" placeholder="Your name" class="form-control" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Your name'" />
                                    <span class="form_icon"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group form_pos">
                                    <input type="text" name="phone" required="" placeholder="Phone" class="form-control" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Phone'" />
                                    <span class="form_icon"></span>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group form_pos">
                                    <input type="text" name="date" required="" placeholder="Date" class="form-control" id="reserv_date" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Date'" />
                                    <span class="form_icon"></span>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group form_pos">
                                    <input type="text" name="time" required="" placeholder="Time" class="form-control" id="reserv_time" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Time'" />
                                    <span class="form_icon"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group form_pos">
                                    <select class="form-control" style="color:black;">
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
                                    <select class="form-control" style="color:black;">
                                        <option value="">Select Branch</option>
                                        <option value="Bole">Bole</option>
                                        <option value="Mexico">Mexico</option>
                                    </select>
                                    <span class="form_icon"></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <textarea rows="3" name="message" placeholder="Message" class="form-control" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Message'"></textarea>
                        </div>
                        <input type="submit" name="send" value="book now" class="btn btn-block" />
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>