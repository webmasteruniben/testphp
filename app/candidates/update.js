$(document).ready(function(){
 
    // show html form when 'update product' button was clicked
    $(document).on('click', '.update-product-button', function(){
        // product ID will be here
        // get product id
        var id = $(this).attr('data-id');
        console.log(id)
        // read one record based on given product id
        $.getJSON("https://testphp.uniben.edu/api/product/read_one.php?id=" + id, function(data){
        
            // values will be used to fill out our form
            var name = data.name;
            var price = data.price;
            var description = data.description;
            var category_id = data.category_id;
            var category_name = data.category_name;
            var username = data.username;
            
            // load list of categories will be here
            // load list of categories
            $.getJSON("https://testphp.uniben.edu/api/election/read.php", function(data){
            
                // build 'categories option' html
                // loop through returned list of data
                    var categories_options_html=`<select name='category_id' class='form-control' style='height:40px'>`;
            
                    $.each(data.records, function(key, val){
                        // pre-select option is category id is the same
                        if(val.id==category_id){ categories_options_html+=`<option value='` + val.id + `' selected>` + val.name + `</option>`; }
            
                        else{ categories_options_html+=`<option value='` + val.id + `'>` + val.name + `</option>`; }
                    });
                    categories_options_html+=`</select>`;


                     $.getJSON("https://testphp.uniben.edu/api/position/read.php", function(data){
            
                        // build 'categories option' html
                        // loop through returned list of data
                            var positions_options_html=`<select name='price' class='form-control' style='height:40px'>`;
                    
                            $.each(data.records, function(key, val){
                                // pre-select option is category id is the same
                                if(val.position==price){ positions_options_html+=`<option value='` + val.position + `' selected>` + val.position + `</option>`; }
                    
                                else{ positions_options_html+=`<option value='` + val.position + `'>` + val.position + `</option>`; }
                            });
                            positions_options_html+=`</select>`;

                    
                
                // update product html will be here
                // store 'update product' html to this variable
                var update_product_html=`
                    <div id='read-products' class='btn btn-primary pull-right m-b-15px read-products-button'>
                        <span class='glyphicon glyphicon-list'></span> View Candidates Info
                    </div>
                    <!-- build 'update product' html form -->
                    <!-- we used the 'required' html5 property to prevent empty fields -->
                    <form id='update-product-form' action='#' method='post' border='0'>
                        <table class='table table-hover table-responsive table-bordered'>
                    
                            <!-- name field -->
                            <tr>
                                <td>Name</td>
                                <td><input value=\"` + name + `\" type='text' name='name' class='form-control' required /></td>
                            </tr>
                    
                            <!-- price field -->
                            <tr>
                                <td>Position</td>
                                <td>` + positions_options_html + `</td>
                            </tr>
                    
                            <!-- description field -->
                            <tr>
                                <td>Description</td>
                                <td><textarea name='description' class='form-control' required>` + description + `</textarea></td>
                            </tr>
                    
                            <!-- categories 'select' field -->
                            <tr>
                                <td>Category</td>
                                <td>` + categories_options_html + `</td>
                            </tr>

                            <!-- username field -->
                            <tr>
                                <td>Username</td>
                                <td><input  value=\"` + username + `\" type='text' name='username' class='form-control' required /></td>
                            </tr>

                            <!-- password field -->
                            <tr>
                                <td>Password</td>
                                <td><input type='password' name='password' class='form-control' /></td>
                            </tr>
                    
                            <tr>
                    
                                <!-- hidden 'product id' to identify which record to delete -->
                                <td><input value=\"` + id + `\" name='id' type='hidden' /></td>
                    
                                <!-- button to submit form -->
                                <td>
                                    <button type='submit' class='btn btn-info'>
                                        <span class='glyphicon glyphicon-edit'></span> Update Candidate
                                    </button>
                                </td>
                    
                            </tr>
                    
                        </table>
                    </form>`;
                    // inject to 'page-content' of our app
                    $("#page-content").html(update_product_html);
                    
                    // chage page title
                    changePageTitle("Update Candidate");
            });
            });
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
            url: "https://testphp.uniben.edu/api/product/update.php",
            type : "POST",
            contentType : 'application/json',
            data : form_data,
            success : function(result) {
                // product was created, go back to products list
                location.reload(true);
                //showProductsFirstPage();
            },
            error: function(xhr, resp, text) {
                // show error to console
                console.log(xhr, resp, text);
            }
        });
        
        return false;
    });
});