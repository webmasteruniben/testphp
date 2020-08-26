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
                <span class='glyphicon glyphicon-list'></span> Read Voters
            </div>
            <!-- 'create product' html form -->
            <form id='create-product-form' action='#' method='post' border='0'>
                <table class='table table-hover table-responsive table-bordered'>
            
                    <!-- name field -->
                    <tr>
                        <td>Last Name</td>
                        <td><input type='text' name='lastname' class='form-control' required /></td>
                    </tr>

                    <tr>
                        <td>First Name</td>
                        <td><input type='text' name='firstname' class='form-control' required /></td>
                    </tr>

                    <tr>
                        <td>Middle Name</td>
                        <td><input type='text' name='middlename' class='form-control' /></td>
                    </tr>

                    <tr>
                        <td>Email</td>
                        <td><input type='text' name='email' class='form-control' required /></td>
                    </tr>

                    <tr>
                        <td>Level</td>
                        <td><input type='text' name='level' class='form-control' required /></td>
                    </tr>

                    <tr>
                        <td>Faculty</td>
                        <td><input type='text' name='faculty' class='form-control' required /></td>
                    </tr>

                    <tr>
                        <td>Department</td>
                        <td><input type='text' name='department' class='form-control' required /></td>
                    </tr>

                    <tr>
                        <td>Student ID/Employee ID</td>
                        <td><input type='text' name='code' class='form-control' required /></td>
                    </tr>

                    <tr>
                        <td>Matriculation Number/Staff Number</td>
                        <td><input type='text' name='number' class='form-control' required /></td>
                    </tr>

                    <tr>
                        <td>Category</td>
                        <td><select name='category' class='form-control' height='100px'>
                            <option value='Staff'>Staff</option>
                            <option value='Student'>Student</option>
                        </select></td>
                    </tr>

                    <tr>
                        <td>Status</td>
                        <td><select name='status' class='form-control' height='100px'>
                            <option value='Not Accredited'>Not Accredited</option>
                            <option value='Accredited'>Accredited</option>
                        </select></td>
                    </tr>
            
                                
                    <tr>
                        <td>Password</td>
                        <td><input type="password" class="form-control" name="password" id="password" required /></td>
                    </tr>
                    
            
                    
            
                    <!-- button to submit form -->
                    <tr>
                        <td></td>
                        <td>
                            <button type='submit' class='btn btn-primary'>
                                <span class='glyphicon glyphicon-plus'></span> Create Voter
                            </button>
                        </td>
                    </tr>
            
                </table>
            </form>`;
            // inject html to 'page-content' of our app
            $("#page-content").html(create_product_html);
            
            // chage page title
            changePageTitle("Create Voter");
        
    });
 
    // 'create product form' handle will be here
    // will run if create product form was submitted
    $(document).on('submit', '#create-product-form', function(){
        // form data will be here
        // get form data
        var form_data=JSON.stringify($(this).serializeObject());
        // submit form data to api
        $.ajax({
            url: "https://testphp.uniben.edu/api/voter/create.php",
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