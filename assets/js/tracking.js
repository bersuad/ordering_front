
$(document).ready(function() {
    truck_order_for_mobile();
    function truck_order_for_mobile() {
        var id = $('#request_id').val();
        var job_id = $('#job_id').val();
            
            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>order/truck_order_for_mobile",
                timeout: 5000,
                data: {
                    id:id,
                },
                success: function(output) {
                    try{
                        result = JSON.parse(output);
                        $('#status').empty();
                        $('#status').html(result);
                        request();
                    } catch(error) {
                        request();
                    }
                }
            });
        }

        setInterval(function(){
            if(!$.active){
                truck_order_for_mobile()
            }
        }, 5000);
    });
function request() {

    var job_id = $("#request_id").val();
    if (job_id == null) return;
    else if(job_id == "") return;
}

function request_status(name, phone_no, driver_id, job_status, tracking_number) {
    var name = name;
    var phone_no = phone_no;
    var driver_id = driver_id
    var job_status = job_status;
    var tracking_no = tracking_number;
    var job_id = document.getElementById("job_id").value;
    // var order_id = document.getElementById("myScript").getAttribute( "data-url" );
    // console.log(job_id);
    
    $.ajax({
        type: "POST",
        url: "<?php echo base_url(); ?>cart/order_info",
        data: {
            name: name,
            phone_no: phone_no,
            driver_id: driver_id,
            job_status: job_status,
            tracking_no: tracking_number,
            job_id: job_id,
            order_id: order_id,
        },
        success: function(output) {
            
        }
    });
}