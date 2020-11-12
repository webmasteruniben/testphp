$(document).ready(function(){
 
    // show html form when 'update product' button was clicked
    $(document).on('click', '.update-product-button', function(){
        // product ID will be here
        // get product id
        var id = $(this).attr('data-id');
        console.log(id)
         $.getJSON("https://testphp.uniben.edu/api/election/read.php", function(data){
            // build categories option html
        // loop through returned list of data
        var categories_options_html=`<select name='election' class='form-control' style='height:60px'>`;
        $.each(data.records, function(key, val){
            categories_options_html+=`<option value='` + val.name + `'>` + val.name + `</option>`;
        });
        categories_options_html+=`</select>`;
        // read one record based on given product id
        $.getJSON("https://testphp.uniben.edu/api/voter/read_one.php?id=" + id, function(data){
        
            // values will be used to fill out our form
            var lastname = data.lastname;
            var id = data.id;
            var firstname = data.firstname;
            var middlename = data.middlename;
            var email = data.email;
            var level = data.level;
            var faculty = data.faculty;
            var department = data.department;
            var code = data.code;
            var number = data.number;
            var status = data.status;
            var category = data.category;
            var election = data.election;
            var jwt = getCookie('jwt');

            
            
            
                // update product html will be here
                // store 'update product' html to this variable
                var update_product_html=`
                    <div id='read-products' class='btn btn-primary pull-right m-b-15px read-products-button'>
                        <span class='glyphicon glyphicon-list'></span> View Voter Info
                    </div>
                    <!-- build 'update product' html form -->
                    <!-- we used the 'required' html5 property to prevent empty fields -->
                    <form id='update-product-form' action='#' method='post' border='0'>
                        <table class='table table-hover table-responsive table-bordered'>
                    
                            <!-- name field -->
                            <tr>
                                <td>Last Name</td>
                                <td><input value=\"` + lastname + `\" type='text' name='lastname' class='form-control' required /></td>
                            </tr>

                            <tr>
                                <td>First Name</td>
                                <td><input value=\"` + firstname + `\" type='text' name='firstname' class='form-control' required /></td>
                            </tr>

                            <tr>
                                <td>Middle Name</td>
                                <td><input value=\"` + middlename + `\" type='text' name='middlename' class='form-control' /></td>
                            </tr>

                            <tr>
                                <td>Email</td>
                                <td><input value=\"` + email + `\" type='text' name='email' class='form-control' required /></td>
                            </tr>

                            <tr>
                                <td>Level</td>
                                <td><input value=\"` + level + `\" type='text' name='level' class='form-control' /></td>
                            </tr>

                            <tr>
                                <td>Faculty</td>
                                <td><input value=\"` + faculty + `\" type='text' name='faculty' class='form-control' required /></td>
                            </tr>

                            <tr>
                                <td>Department</td>
                                <td><input value=\"` + department + `\" type='text' name='department' class='form-control' required /></td>
                            </tr>

                            <tr>
                                <td>Student ID/Employee ID</td>
                                <td><input value=\"` + code + `\" type='text' name='code' class='form-control' required /></td>
                            </tr>

                            <tr>
                                <td>Matriculation Number/Staff Number</td>
                                <td><input value=\"` + number + `\" type='text' name='number' class='form-control' required /></td>
                            </tr>

                            <tr>
                                <td>Category</td>
                                <td><select name='category' class='form-control' style='height:60px'>
                                    <option value='Staff'>Staff</option>
                                    <option value='Student'>Student</option>
                                </select></td>
                            </tr>

                            <!-- categories 'select' field -->
                            <tr>
                                <td>Election</td>
                                <td>` + categories_options_html + `</td>
                            </tr>

                            <tr>
                                <td>Status</td>
                                <td><select name='status' class='form-control' style='height:60px'>
                                    <option value='Not Accredited'>NOT ACCREDITTED</option>
                                    <option value='Accredited'>ACCREDITTED</option>
                                </select></td>
                            </tr>
                    
                           
                    
                            
                    
                    
                            <tr>
                    
                                <!-- hidden 'product id' to identify which record to delete -->
                                <td><input value=\"` + id + `\" name='id' type='hidden' /><br>
                                   <input value=\"` + jwt + `\" name='jwt' type='hidden' />
                                </td>

                    
                                <!-- button to submit form -->
                                <td>
                                    <button type='submit' class='btn btn-info'>
                                        <span class='glyphicon glyphicon-edit'></span> Update Voter
                                    </button>
                                </td>
                    
                            </tr>
                    
                        </table>
                    </form>`;
                    // inject to 'page-content' of our app
                    $("#page-content").html(update_product_html);
                    
                    // chage page title
                    changePageTitle("Update Voter");
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
            url: "https://testphp.uniben.edu/api/voter/update.php",
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