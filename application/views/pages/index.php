<?php
   if (!empty($items)) {
      if(!empty($_SESSION["cart_item"])){
         // print_r( $items[0] );
         // die();
      }
    }
   ?>
<div class="container section" id="menu" data-aos="fade-up" style="margin-top: 180px;">
    <div class="title-block">
        <h1 class="section-title" style="color: <?php echo $companies[0]->main_color; ?>;">Our Menus</h1>
    </div>
    <?php if (!empty($items)) {
        // print_r($items); die();
        ?>
        <div class="menu_filter text-center" style="border-radius: 60px;">
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
                <?php }
                } ?>
            </ul>
        </div>
    <?php }?>

    <div id="menu_items">
        
        <div class="filtr-item image filter all active">
            <div class="row">
            <?php $in_session = "0"; ?>
        <?php  if(!empty($items)){
            foreach($items as $key => $item){
        ?>
                    <div class="col-sm-6 col-md-4 col-lg-4 col-xs-6 list-of-items">
                        
                        <a href="#" data-toggle="modal" data-target="#modalQuickView<?php echo $item->item_id ?>" id="add_to_cart block fancybox" class="to_cart" data-name="<?php echo  $item->item_name?>" data-price="<?php echo  $item->item_value?>" data-desc="$detail" data-image="$photo" data-id="<?php echo $item->item_id?>">
                            <div class="content">
                                <div class="filter_item_img">
                                    <i class="fa fa-search-plus"></i>
                                    <img src="<?php echo order_admin_URL ?><?php echo $item->image; ?>" alt="sample" />
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
            <?php  if(!empty($items)){
                foreach($items as $key => $item){
                    ?>
                    <div class="filtr-item image filter <?php echo $item->item_category; ?>">
                    <div class="col-sm-6 col-md-4 col-lg-4 col-xs-6 list-of-items">
                    <a href="#" data-toggle="modal" data-target="#modalQuickView<?php echo $item->item_id ?>" id="add_to_cart block fancybox" class="to_cart" data-name="<?php echo  $item->item_name?>" data-price="<?php echo  $item->item_value?>" data-desc="$detail" data-image="$photo" data-id="<?php echo $item->item_id?>">
                            <div class="content">
                                <div class="filter_item_img">
                                    <i class="fa fa-search-plus"></i>
                                    <img src="<?php echo order_admin_URL ?><?php echo $item->image; ?>" alt="sample" />
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
            }
        }
        ?>
    </div>
        
        
    </div>
</div>
<!-- item modal -->
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
                    <img src="<?php echo order_admin_URL ?><?php echo $item->image; ?>" alt="image" style="min-width:auto; max-height: 450px; min-height: auto; max-width: 100%!important;">
                    <h3 style="margin-top: 20px; margin-bottom: 20px;"><?php echo $item->item_name ?></h3>
                    <p style="margin-top: 20px; margin-bottom: 20px;" id="real_price<?php echo $item->item_id ?>"><?php echo $item->item_value ?> Br.</p>
                    <p align="center" style="margin-top: 2%;"> <?php echo $item->description ?></p>
                    <div align="center" class="row" style="background-color: #f8f8f8; width: 100%; border-radius: 10px; align-content: center;">
                        <i class="fa fa-minus fa-lg" id="minus_btn<?php echo $item->item_id ?>" style="cursor: pointer; background: #eeeeee; height: 50px; width: 50px; border-radius: 50%; padding-top: 15px; margin-rigth: 20px;"></i>
                        <strong><label style="font-size: 1.1em; padding-left: 6px;" id="qty_<?php echo $item->item_id ?>" name="quantity" class="quantity<?php echo $item->item_id ?>"> 1 </label> </strong>
                        <i class="fa fa-plus fa-lg" id="plus_btn<?php echo $item->item_id ?>" style="cursor: pointer; background: #eeeeee; height: 50px; width: 50px; border-radius: 100%; padding-top: 15px; margin-left: 15px;"></i>
                    </div>
                    <p style="margin-top: 10px;" id="price_point<?php echo $item->item_id ?>"><?php echo $item->item_value ?>.00 Br.</p>
                    
                    <?php
                        if (empty($extras)) {
                        } else { ?>
                        <div class="accordion md-accordion" id="accordionEx" role="tablist" aria-multiselectable="true">
                            <div class="card">
                                <!-- Card header -->
                                <div class="card-header" role="tab" id="headingTwo2">
                                <a class="collapsed" data-toggle="collapse" data-parent="#accordionEx" href="#collapseTwo<?php echo $item->item_id ?>" aria-expanded="false" aria-controls="collapseTwo<?php echo $item->item_id ?>">
                                    <h5 class="mb-0">
                                        Extra<i style="margin-left: 80%;" class="fas fa-angle-down rotate-icon"></i>
                                    </h5>
                                </a>
                                </div>
                                <div id="collapseTwo<?php echo $item->item_id ?>" class="collapse" role="tabpanel" aria-labelledby="headingTwo2" data-parent="#accordionEx">
                                <div class="card-body">
                                    <div class="form-check">
                                        <ul class="list-group list-group-flush">
                                            <?php if (!empty($extras)) {
                                            foreach ($extras as $extra) {
                                            ?>
                                            <li class="list-group-item">
                                            <!-- Default checked -->
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" value="<?php echo $extra->item_value ?>" id="<?php echo $item->item_id ?><?php echo $extra->item_id ?>"  onclick="checkClick<?php echo $item->item_id ?><?php echo $extra->item_id ?>()">
                                                <label class="custom-control-label" for="<?php echo $item->item_id ?><?php echo $extra->item_id ?>"> <span id="extrList<?php echo $item->item_id ?><?php echo $extra->item_id ?>"> <?php echo $extra->item_name ?> </span> (<small ><?php echo number_format($extra->item_value, 2) ?>)</small></label>
                                            </div>
                                            </li>
                                            <?php
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
                        ?>
                    <div id="modal_comment">
                        <label for="textarea">Special Instructions</label>
                        <textarea placeholder="Special Instructions" class="form-control" id="comment_<?php echo $item->item_id ?>" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button style="background-color: <?php echo $companies[0]->main_color; ?> ; color:#fff;" type="button" id="add_<?php echo $item->item_id ?>" onClick="cartAction('add','<?php echo $item->item_id ?>')" <?php if ($in_session != "0") { ?>style="display:none" <?php
                                    } ?>  class="btn btn-block add_to_cart">Add to Cart</button>
                    <button id="added_<?php echo $item->item_id ?>" <?php if ($in_session != "1") { ?>style="display:none" <?php
                    } ?> class="btn btn-block add_to_cart disabled">Added</button>
                    <button type="button" class="btn btn-secondary btn-block" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        <?php
        if (!empty($extras)) {
            foreach ($extras as $extra) {
        ?>
            
            function checkClick<?php echo $item->item_id ?><?php echo $extra->item_id ?>(){
                var extra = Number(document.getElementById(<?php echo $item->item_id ?><?php echo $extra->item_id ?>).value);
                var price = parseInt($('#price_point<?php echo $item->item_id ?>').html());
                if ($("#<?php echo $item->item_id ?><?php echo $extra->item_id ?>").prop('checked')==true){
                    var real_price = parseInt($('#real_price<?php echo $item->item_id ?>').html());
                    var extra_list = $('#extrList<?php echo $item->item_id ?><?php echo $extra->item_id ?>').html();
                    $('#daynamic_field_<?php echo $item->item_id ?>').append(extra_list);
                    
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
        }
        }
        ?>
        
        $("#add_to_cart").click(function(argument) {
        // $('#comment_').val();
            $('#item_name').val($(this).data('name'));
            $('#price_point').val($(this).data('price'));
            $('#qty<?php echo $item->item_id ?>').val($(this).data('quantity'));
            var myImageId = $(this).data('image');
            $('#image').attr("src", myImageId);
            var id = $('[name=item_id]').val($(this).data('id'));                                 
        })
        
        
        $("#plus_btn<?php echo $item->item_id ?>").click(function() {
            // console.log(extra);
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
                // $('.quantity<?php echo $item->item_id ?>').html(add);
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
