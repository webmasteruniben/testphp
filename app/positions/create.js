$(document).ready(function(){
 
    // show html form when 'create product' button was clicked
    $(document).on('click', '.create-product-button', function(){
        // categories api call will be here
        // load list of categories
        console.log('test')
        

        // we have our html form here where product information will be entered
        // we used the 'required' html5 property to prevent empty fields
        var create_product_html=`
        
            <!-- 'read products' button to show list of products -->
            <div id='read-products' class='btn btn-primary pull-right m-b-15px read-products-button'>
                <span class='glyphicon glyphicon-list'></span> Read Positions
            </div>
            <!-- 'create product' html form -->
            <form id='create-product-form' action='#' method='post' border='0'>
                <table class='table table-hover table-responsive table-bordered'>
            
                    <!-- name field -->
                    <tr>
                        <td>Position</td>
                        <td><input type='text' name='position' class='form-control' required /></td>
                    </tr>
            
                                
                    <!-- description field -->
                    <tr>
                        <td>Description</td>
                        <td><textarea name='description' class='form-control' required></textarea></td>
                    </tr>

                   
            
                    
            
                    <!-- button to submit form -->
                    <tr>
                        <td></td>
                        <td>
                            <button type='submit' class='btn btn-primary'>
                                <span class='glyphicon glyphicon-plus'></span> Create Position
                            </button>
                        </td>
                    </tr>
            
                </table>
            </form>`;
            // inject html to 'page-content' of our app
            $("#page-content").html(create_product_html);
            
            // chage page title
            changePageTitle("Create Position");
        
    });
 
    // 'create product form' handle will be here
    // will run if create product form was submitted
    $(document).on('submit', '#create-product-form', function(){
        // form data will be here
        // get form data
        var form_data=JSON.stringify($(this).serializeObject());
        // submit form data to api
        $.ajax({
            url: "https://testphp.uniben.edu/api/position/create.php",
            type : "POST",
            contentType : 'application/json',
            data : form_data,
            success : function(result) {
                // product was created, go back to products list
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