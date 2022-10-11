<?php
   if (!empty($items)) {
      if(!empty($_SESSION["cart_item"])){
      }
    }
   ?>
<div class="container section" id="menu" data-aos="fade-up">

    
    <?php if (!empty($items)) {?>
        <div class="menu_filter text-center category-list">
            <ul class="list-unstyled list-inline d-inline-block">
                <li class="item active">
                    <a href="#" class="filter-button active" data-filter="all">All</a>
                </li>
                
                <?php  if(!empty($category_list)){
                    foreach($category_list as $key => $category){
                ?>
                    <li class="item">
                        <a href="javascript:;" class="filter-button" data-filter="<?php echo  $category->category_id; ?>"><?php echo $category->category_name; ?></a>
                    </li>       
                <?php 
                    }
                } ?>
            </ul>
        </div>
        <!-- <div class="next-button" style="color:<?php echo $companies[0]->second_color; ?>;"><i class="fa fa-angle-right fa-lg"></i><i class="fa fa-angle-right fa-lg"></i></div> -->
    <?php }?>

    <div id="menu_items">
        <?php $in_session = "0"; ?>
        
        <div class="filtr-item image filter all active">
            <div class="row">

                <div id="result"></div>
                
                <?php  if(!empty($items)){
                    foreach($items as $key => $item){
                ?>
                            <div class="col-sm-6 col-md-4 col-lg-4 col-xs-6 list-of-items">
                                
                                <a href="#" data-toggle="modal" data-target="#modalQuickView<?php echo $item->item_id ?>" id="add_to_cart block fancybox" class="to_cart" data-name="<?php echo  $item->item_name?>" data-price="<?php echo  $item->item_value?>" data-desc="$detail" data-image="$photo" data-id="<?php echo $item->item_id?>">
                                    <div class="content">
                                        <div class="filter_item_img">
                                            <i class="fa fa-search-plus"></i>
                                            <?php 
                                                if($item->image != 'uploads/'){?>
                                                <img src="<?php echo order_admin_URL; ?><?php echo $item->image; ?>" alt="sample" />
                                            <?php }else{ ?>
                                                <img src="<?php echo base_url(); ?>/assets/img/eat.png" alt="sample" />
                                            <?php } ?>
                                        </div>
                                        <div class="info">
                                            <div class="name"><?php echo $item->item_name ?></div>
                                            <span class="filter_item_price">Br. <?php echo $item->item_value ?></span>
                                        </div>
                                    </div>
                                </a>

                            </div>
                            
                            
                        <?php
                    }
                }
                ?> 
            </div>
        </div>
        
        <div class="row">
            <?php  if(!empty($items)){?>
                <div class="image">
                    <?php
                foreach($items as $key => $item){
                    ?>
                    <div class="filtr-item filter <?php echo $item->item_category; ?>">
                        <div class="col-sm-6 col-md-4 col-lg-4 col-xs-6 list-of-items">
                            
                            <a href="#" data-toggle="modal" data-target="#modalQuickView<?php echo $item->item_id ?>" id="add_to_cart block fancybox" class="to_cart" data-name="<?php echo  $item->item_name?>" data-price="<?php echo  $item->item_value?>" data-desc="$detail" data-image="$photo" data-id="<?php echo $item->item_id?>">
                                <div class="content">
                                    <div class="filter_item_img">
                                        <i class="fa fa-search-plus"></i>
                                        <?php 
                                            if($item->image != 'uploads/'){?>
                                            <img src="<?php echo order_admin_URL; ?><?php echo $item->image; ?>" alt="sample" />
                                        <?php }else{ ?>
                                            <img src="<?php echo base_url(); ?>/assets/img/eat.png" alt="sample" />
                                        <?php } ?>
                                    </div>
                                    <div class="info">
                                        <div class="name"><?php echo $item->item_name ?></div>
                                        <span class="filter_item_price">Br. <?php echo $item->item_value ?></span>
                                    </div>
                                </div>
                            </a>

                        </div>                    
                    </div>
            <?php
                }?>
                </div>
                <?php
            }
            ?>
        </div>   
    </div>
</div>

<script src="<?php echo base_url() ?>assets/js/jquery-2.1.1.min.js"></script>

<?php  if(!empty($items)){
    foreach($items as $key => $item){
?>
    <div style="height: 100%;" class="modal fade category_modal" id="modalQuickView<?php echo $item->item_id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><?php echo $item->item_name ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" align="center" style="align-items: center; text-align:center; ">
                    <?php 
                        if($item->image != 'uploads/'){?>
                        <img src="<?php echo order_admin_URL ?><?php echo $item->image; ?>" alt="image" style="min-width:auto; max-height: 450px; min-height: auto; max-width: 100%!important;">
                    <?php }else{ ?>
                        <img src="<?php echo base_url(); ?>/assets/img/eat.png" alt="sample" style="min-width:auto; max-height: 450px; min-height: auto; max-width: 100%!important;"/>
                    <?php } ?>
                    <h3 style="margin-top: 20px; margin-bottom: 20px;"><?php echo $item->item_name ?></h3>
                    <p style="margin-top: 20px; margin-bottom: 20px;" id="real_price<?php echo $item->item_id ?>"><?php echo $item->item_value ?> Br.</p>
                    <input type="hidden" name="original_price" value="<?php echo $item->item_value ?>" id="original_price<?php echo $item->item_id ?>"/>

                    <p align="left" style="margin-top: 2%; align-items:flex-start; align-content:flex-start; align-self: flex-start; text-align: left;"> <?php echo $item->description ?></p>

                    <div align="center" class="row" style="background-color: #f8f8f8; width: 105%; border-radius: 10px; align-content: center;">
                        <i class="fa fa-minus fa-lg" id="minus_btn<?php echo $item->item_id ?>" style="cursor: pointer; background: #eeeeee; height: 50px; width: 50px; border-radius: 50%; padding-top: 18px; margin-rigth: 20px;"></i>
                        <strong><label style="font-size: 1.1em; padding-left: 6px;" id="qty_<?php echo $item->item_id ?>" name="quantity" class="quantity<?php echo $item->item_id ?>"> 1 </label> </strong>
                        <i class="fa fa-plus fa-lg" id="plus_btn<?php echo $item->item_id ?>" style="cursor: pointer; background: #eeeeee; height: 50px; width: 50px; border-radius: 100%; padding-top: 18px; margin-left: 15px;"></i>
                    </div>

                    <p style="margin-top: 10px;" id="price_point<?php echo $item->item_id ?>"><?php echo $item->item_value ?>.00 Br.</p>

                    <?php 
                        if(!empty($item->item_size)){
                            $size_list      = json_decode($item->item_size);
                            if (!empty($size_list)) {?>
                            <div class="accordion md-accordion" id="radioGroupAccordion" role="tablist" aria-multiselectable="true">
                                <div class="card">
                                    <div class="card-header" role="tab" id="radioHeader" style="height: 40px; background: #f0f0f0; padding-top: 5px; margin-top: 10px;">
                                        <?php if(!empty($size_list[0]->title) ){?>
                                            <a class="collapsed" data-toggle="collapse" data-parent="#radioGroupAccordion" href="#radioGroupAccordion<?php echo $item->item_id ?>" aria-expanded="false" aria-controls="collapseThree<?php echo $item->item_id ?>">
                                                <h5 class="mb-0"><?php echo $size_list[0]->title; ?> <i style="margin-left: 60%;" class="fa fa-angle-down rotate-icon"></i> </h5>
                                            </a>
                                        <?php }?>
                                    </div>
                                    <div id="radioGroupAccordion<?php echo $item->item_id ?>" class="collapse" role="tabpanel" aria-labelledby="radioOption" data-parent="#radioGroupAccordion">
                                        <div class="card-body">
                                            <div style="align-items: center; align-content: center; align-self: center; text-align: left;">
                                                <div class="form-check">
                                                    <?php foreach ($size_list as $key => $list) {?>
                                                        <?php
                                                        if($key > 0 && $list->size != ''){?>
                                                            <div class="custom-control custom-radio row">
                                                                <div class="col-md-4 col-sm-12 col-lg-4">
                                                                    <input type="radio" id="size<?php echo $item->item_id ?><?php echo $key ?>" name="time" value="" required> <label for="size">
                                                                        <h6><span id="size_name<?php echo $item->item_id; ?><?php echo $key;?>"><?php echo $list->size ?></span> (<span id="size_price<?php echo $item->item_id; ?><?php echo $key;?>"><?php echo $list->price ?> Br.</span>)</h6>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        <?php }
                                                        $key++;
                                                    }?>
                                                    <span id="daynamic_size_<?php echo $item->item_id ?>" style="display: none;"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php }
                    }?>

                    <?php
                        if(!empty($item->group_list) && $item->group_list != null){
                            $group_list      = json_decode($item->group_list);
                            if (!empty($group_list)) {?>
                                <div class="accordion md-accordion" id="chooseListAccordion" role="tablist" aria-multiselectable="true">
                                    <div class="card">
                                        <div class="card-header" role="tab" id="chooseHeading" style="height: 40px; background: #f1f1f1; padding-top: 5px; margin-top: 10px">
                                            <?php if(!empty($group_list[0]->title) ){?>
                                                <a class="collapsed" data-toggle="collapse" data-parent="#chooseListAccordion" href="#choosecollapse<?php echo $item->item_id ?>" aria-expanded="false" aria-controls="collapseOne<?php echo $item->item_id ?>">
                                                    <h5 class="mb-0"><?php echo $group_list[0]->title; ?> <i style="margin-left: 60%;" class="fa fa-angle-down rotate-icon"></i></h5>
                                                </a>
                                            <?php }?>
                                        </div>
                                        <div id="choosecollapse<?php echo $item->item_id ?>" class="collapse" role="tabpanel" aria-labelledby="chooseHeading" data-parent="#chooseListAccordion">
                                            <div class="card-body">
                                                <div style="align-items: center; align-content: center; align-self: center; text-align: left;">
                                                    <div class="form-check">
                                                        <?php foreach ($group_list as $key => $list) {?>
                                                            <?php
                                                            if($key > 0 && $list->item_name != ''){?>
                                                                <div class="custom-control custom-checkbox">
                                                                    <div class="col-md-12 col-sm-12 col-lg-12">
                                                                        <input type="checkbox" id="choose_<?php echo $item->item_id ?><?php echo $key ?>" onclick="chooseCheckClick<?php echo $item->item_id ?><?php echo $key ?>()"/> 
                                                                        <label for="choose">
                                                                            <h6><span id="choose_name<?php echo $item->item_id; ?><?php echo $key;?>"><?php echo $list->item_name ?></span></h6>
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            <?php }
                                                            $key++;
                                                        }?>
                                                        <span id="choose_field_<?php echo $item->item_id ?>" style="display: none;"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php }
                        }
                    ?>
                    
                    <?php
                        if(!empty($item->extra_list)){
                            $exra_list      = json_decode($item->extra_list);
                            if ($exra_list[0]->extra=='') {
                            } else { ?>
                                <div class="accordion md-accordion" id="accordionEx" role="tablist" aria-multiselectable="true">
                                    <div class="card">
                                        <div class="card-header" role="tab" id="headingTwo2" style="height: 40px; background: #f1f1f1; padding-top: 5px; margin-top: 10px">
                                            <a class="collapsed" data-toggle="collapse" data-parent="#accordionEx" href="#collapseTwo<?php echo $item->item_id ?>" aria-expanded="false" aria-controls="collapseTwo<?php echo $item->item_id ?>">
                                                <h5 class="mb-0">
                                                Add-on Options<i style="margin-left: 60%;" class="fa fa-angle-down rotate-icon"></i>
                                                </h5>
                                            </a>
                                        </div>
                                        <div id="collapseTwo<?php echo $item->item_id ?>" class="collapse" role="tabpanel" aria-labelledby="headingTwo2" data-parent="#accordionEx">
                                            <div class="card-body">
                                                <div class="form-check">
                                                    <ul class="list-group list-group-flush">
                                                        <?php 
                                                        $exra_list      = json_decode($item->extra_list);
                                                        if (!empty($exra_list)) {
                                                        foreach ($exra_list as $key => $extra) {
                                                            if($extra->extra != ''){
                                                        ?>
                                                        <li class="list-group-item">
                                                        <!-- Default checked -->
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" value="<?php echo $extra->price ?>" id="<?php echo $item->item_id ?><?php echo $key ?>"  onclick="checkClick<?php echo $item->item_id ?><?php echo $key ?>()">
                                                            <label class="custom-control-label" for="<?php echo $item->item_id ?><?php echo $key ?>"> 
                                                                <span id="extrList<?php echo $item->item_id ?><?php echo $key ?>"> 
                                                                    <?php echo $extra->extra ?> 
                                                                </span> 
                                                                (<small ><?php echo number_format($extra->price, 2) ?>)</small>
                                                            </label>
                                                        </div>
                                                        </li>
                                                        <?php }
                                                        $key++;
                                                        }
                                                        } ?>
                                                        <span id="daynamic_field_<?php echo $item->item_id ?>" style="display: none;"></span>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php
                            }
                        }
                    ?>
                    <div id="modal_comment">
                        <label for="textarea">Special Instructions</label>
                        <textarea placeholder="Special Instructions" class="form-control" id="comment_<?php echo $item->item_id ?>" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="add_<?php echo $item->item_id ?>" onClick="cartAction('add','<?php echo $item->item_id ?>')" <?php if ($in_session != "0") { ?>style="display:none" <?php
                                    } ?>  class="btn btn-block add_to_cart">Add to Order</button>
                    <button id="added_<?php echo $item->item_id ?>" <?php if ($in_session != "1") { ?>style="display:none" <?php
                    } ?> class="btn btn-block add_to_cart disabled">Added</button>
                    <button type="button" class="btn btn-secondary btn-block" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        <?php $exra_list      = json_decode($item->extra_list);
        if (!empty($exra_list)) {

            foreach ($exra_list as $key => $extra) {?>
            
                function checkClick<?php echo $item->item_id ?><?php echo $key ?>(){
                    var extra = Number(document.getElementById(<?php echo $item->item_id ?><?php echo $key ?>).value);
                    var price = parseInt($('#price_point<?php echo $item->item_id ?>').html());
                    if ($("#<?php echo $item->item_id ?><?php echo $key ?>").prop('checked')==true){
                        var real_price = parseInt($('#real_price<?php echo $item->item_id ?>').html());
                        var extra_list = $('#extrList<?php echo $item->item_id ?><?php echo $key ?>').html();
                        $('#daynamic_field_<?php echo $item->item_id ?>').append(extra_list+', ');
                        
                        var add_real = (real_price) + (extra);
                        $('#real_price<?php echo $item->item_id ?>').html(add_real);
                        var total = (extra) + (price);
                        $('#price_point<?php echo $item->item_id ?>').html(total);                                                                                            
                    }else{
                        var real_price = parseInt($('#real_price<?php echo $item->item_id ?>').html());
                        $('#daynamic_field_<?php echo $item->item_id ?>').remove();
                        var add_real = (real_price) - (extra);
                        $('#real_price<?php echo $item->item_id ?>').html(add_real);
                        var total = (price) - (extra);
                        $('#price_point<?php echo $item->item_id ?>').html(total); 
                    }
                    
                }
            <?php
            $key++;
            }
        }
        ?>
        <?php 
            if(!empty($item->group_list)){?>
            <?php $group_list      = json_decode($item->group_list);
                if (!empty($group_list)) {
                    foreach ($group_list as $key => $group) {?>

                    function chooseCheckClick<?php echo $item->item_id ?><?php echo $key ?>(){
                        var choose = $('#choose_name<?php echo $item->item_id ?><?php echo $key ?>').html();
                        
                        if ($("#choose_<?php echo $item->item_id ?><?php echo $key ?>").prop('checked')==true){
                            $('#choose_field_<?php echo $item->item_id ?>').append(choose+', ');
                        }else{
                            $('#choose_field_<?php echo $item->item_id ?>').remove();
                        }
                        
                    }
                <?php
                    $key++;
                }
            }
            ?>
        <?php }?>
        
        <?php 
            if(!empty($item->item_size)){?>
                <?php $size_list      = json_decode($item->item_size);
                    if (!empty($size_list)) {
                        
                        foreach ($size_list as $key => $list) {?>
                        $('#size<?php echo $item->item_id ?><?php echo $key ?>').click(function() {
                            $('#daynamic_size_<?php echo $item->item_id ?>').html(' ');
                            var ori_price = parseInt($('#original_price<?php echo $item->item_id ?>').val());
                            var real_price = parseInt($('#real_price<?php echo $item->item_id ?>').html());
                            var size = $('#size_name<?php echo $item->item_id ?><?php echo $key ?>').html();
                            var price = parseInt( $('#size_price<?php echo $item->item_id ?><?php echo $key;?>').html());
                            var mainprice = parseInt($('#price_point<?php echo $item->item_id ?>').html());
                            
                            $('#daynamic_size_<?php echo $item->item_id ?>').html(size);
                            
                            var add_real = (ori_price) + (price);
                            $('#real_price<?php echo $item->item_id ?>').html(add_real);
                            var total = (price) + (ori_price);
                            $('#price_point<?php echo $item->item_id ?>').html(total);                                                                                            
                            
                            
                        });
                        <?php
                            $key++;
                        }
                    }
                ?>
        <?php }?>

        
        $("#add_to_cart").click(function(argument) {
            $('#item_name').val($(this).data('name'));
            $('#price_point').val($(this).data('price'));
            $('#qty<?php echo $item->item_id ?>').val($(this).data('quantity'));
            var myImageId = $(this).data('image');
            $('#image').attr("src", myImageId);
            var id = $('[name=item_id]').val($(this).data('id'));                                 
        })
        
        
        $("#plus_btn<?php echo $item->item_id ?>").click(function() {
            var qun = parseInt($('.quantity<?php echo $item->item_id ?>').html());
            var price = parseInt($('#real_price<?php echo $item->item_id ?>').html());
            var add = qun + 1;
            var total = (add) * (price);
        
            $('#price_point<?php echo $item->item_id ?>').html(total);
            $('.quantity<?php echo $item->item_id ?>').html(add);
            <?php if ($in_session != "1") { ?>
                $('.quantity<?php echo $item->item_id ?>').attr('disabled', true)
            <?php
        } ?>
        });
        
        $("#minus_btn<?php echo $item->item_id ?>").click(function() {
            <?php
        if (!empty($extras)) {
            foreach ($extras as $extra) {
        ?>
                $("#<?php echo $item->item_id ?><?php echo $extra->item_id ?>").prop('checked', false);
            <?php
        }
        }
        ?>
            var qun = $('.quantity<?php echo $item->item_id ?>').html();
            if (qun <= 1) {
                var add = 1;
                $('.quantity<?php echo $item->item_id ?>').attr('disabled', true)
            } else {
                var qun = parseInt($('.quantity<?php echo $item->item_id ?>').html());
                var price = parseInt($('#real_price<?php echo $item->item_id ?>').html());
        
                var add = qun - 1;
                var total = (add) * (price);
        
                $('#price_point<?php echo $item->item_id ?>').html(total);
                $('.quantity<?php echo $item->item_id ?>').html(add);
            }
        });
    </script>
<?php }}?>
<script>
    $(document).ready(function (){
        $('#search_food').keyup(function(){
            var txt = $(this).val();
            var admin_url = "<?php echo order_admin_URL;?>";
            var data = {
                search:txt,
                admin_url:admin_url
            };

            var str_len = txt.length;
            
            if(txt != '' && str_len >= 2){
                $.ajax({
                    type: "POST",
                    url: '<?php echo base_url() ?>pages/getFood',
                    data:data,
                    success:function(data)
                    {
                        $('#result').html(data);
                    },
                    error:function(error) {
                        $('#result').html('');
                    }
                });
            }else{
                $('#result').html('Searching ....');
                window.setTimeout(resetForm, 2000);
            }
        });
    });

    function resetForm()
    {
        $('#result').html('');
    }
</script>