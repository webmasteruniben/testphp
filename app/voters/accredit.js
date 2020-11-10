$(document).ready(function(){
 
    // will run if the delete button was clicked
    $(document).on('click', '.accredit-product-button', function(){
        // product id will be here
        // get the product id
        var product_id = $(this).attr('data-id');
        console.log(product_id);
        // bootbox for good looking 'confirm pop up'
        bootbox.confirm({
        
            message: "<h4>Are you sure you want to accredit this Voter?</h4>",
            buttons: {
                confirm: {
                    label: '<span class="glyphicon glyphicon-ok"></span> Yes',
                    className: 'btn-danger'
                },
                cancel: {
                    label: '<span class="glyphicon glyphicon-remove"></span> No',
                    className: 'btn-primary'
                }
            },
            callback: function (result) {
                // delete request will be here
                if(result==true){
 
                    // send delete request to api / remote server
                    $.ajax({
                        url: "https://testphp.uniben.edu/api/voter/accredit.php",
                        type : "POST",
                        dataType : 'json',
                        data : JSON.stringify({ id: product_id, status: "ACCREDITTED" }),
                        success : function(result) {
                
                            // re-load list of products
                            //location.reload(true);
                            showProductsFirstPage();
                        },
                        error: function(xhr, resp, text) {
                            console.log(xhr, resp, text);
                        }
                    });
                
                }
            }
        });

    });
});