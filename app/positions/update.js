$(document).ready(function(){
 
    // show html form when 'update product' button was clicked
    $(document).on('click', '.update-product-button', function(){
        // product ID will be here
        // get product id
        var id = $(this).attr('data-id');
        console.log(id)
        // read one record based on given product id
        $.getJSON("https://testphp.uniben.edu/api/position/read_one.php?id=" + id, function(data){
        
            // values will be used to fill out our form
            var position = data.position;
           
            var description = data.description;

           
            
            
            
                // update product html will be here
                // store 'update product' html to this variable
                var update_product_html=`
                    <div id='read-products' class='btn btn-primary pull-right m-b-15px read-products-button'>
                        <span class='glyphicon glyphicon-list'></span> View Position Info
                    </div>
                    <!-- build 'update product' html form -->
                    <!-- we used the 'required' html5 property to prevent empty fields -->
                    <form id='update-product-form' action='#' method='post' border='0'>
                        <table class='table table-hover table-responsive table-bordered'>
                    
                            <!-- name field -->
                            <tr>
                                <td>Position</td>
                                <td><input value=\"` + position + `\" type='text' name='position' class='form-control' required /></td>
                            </tr>
                    
                           
                    
                            <!-- description field -->
                            <tr>
                                <td>Description</td>
                                <td><textarea name='description' class='form-control' required>` + description + `</textarea></td>
                            </tr>

                           
                    
                            <tr>
                    
                                <!-- hidden 'product id' to identify which record to delete -->
                                <td><input value=\"` + id + `\" name='id' type='hidden' /></td>
                    
                                <!-- button to submit form -->
                                <td>
                                    <button type='submit' class='btn btn-info'>
                                        <span class='glyphicon glyphicon-edit'></span> Update Election
                                    </button>
                                </td>
                    
                            </tr>
                    
                        </table>
                    </form>`;
                    // inject to 'page-content' of our app
                    $("#page-content").html(update_product_html);
                    
                    // chage page title
                    changePageTitle("Update Position");
            
        });
    });
     
    // 'update product form' submit handle will be here
    // will run if 'create product' form was submitted
    $(document).on('submit', '#update-product-form', function(){
        
        // get form data will be here 
        // get form data
        var form_data=JSON.stringify($(this).serializeObject());
        // submit form data to api
        $.ajax({
            url: "https://testphp.uniben.edu/api/position/update.php",
            type : "POST",
            contentType : 'application/json',
            data : form_data,
            success : function(result) {
                // product was created, go back to products list
                //location.reload(true);
                showProductsFirstPage();
            },
            error: function(xhr, resp, text) {
                // show error to console
                console.log(xhr, resp, text);
            }
        });
        
        return false;
    });
});