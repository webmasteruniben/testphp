$(document).ready(function(){
 
    // show html form when 'update product' button was clicked
    $(document).on('click', '.update-photo-button', function(){
        // product ID will be here
        // get product id
        var id = $(this).attr('data-id');
        console.log(id)
        // read one record based on given product id
        $.getJSON("https://testphp.uniben.edu/api/product/read_one.php?id=" + id, function(data){
        
            // values will be used to fill out our form
            var name = data.name;
            var price = data.price;
            var profile_pic = data.profile_pic;
            var description = data.description;
            var category_id = data.category_id;
            var category_name = data.category_name;
            
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
                
                // update product html will be here
                // store 'update product' html to this variable
                var update_product_html=`
                    <div id='read-products' class='btn btn-primary pull-right m-b-15px read-products-button'>
                        <span class='glyphicon glyphicon-list'></span> View Candidates Info
                    </div>
                    <!-- build 'update product' html form -->
                    <!-- we used the 'required' html5 property to prevent empty fields -->
                    <form method="POST" action="upload.php" enctype="multipart/form-data">
                        <table class='table table-hover table-responsive table-bordered'>
                    
                            <!-- name field -->
                            <tr>
                                <td>Name</td>
                                <td><input value=\"` + name + `\" type='text' name='name' class='form-control' required /></td>
                            </tr>
                    
                           
                    
                            <!-- description field -->
                            <tr>
                                <td>Profile Photo</td>
                                <td><img src='images/` + profile_pic + `' style='height:25%;width:25%;'></td>
                            </tr>
                    

                            <!-- description field -->
                            <tr>
                                <td>Profile Photo</td>
                                <td><input type="file" class="form-control" name="profile_photo" id="profile_photo" /></td>
                            </tr>
                    
                            <tr>
                    
                                <!-- hidden 'product id' to identify which record to delete -->
                                <td><input value=\"` + id + `\" name='id' type='hidden' /></td>
                    
                                <!-- button to submit form -->
                                <td>
                                    <button type='submit' class='btn btn-info'>
                                        <span class='glyphicon glyphicon-edit'></span> Update Candidate Photo
                                    </button>
                                </td>
                    
                            </tr>
                    
                        </table>
                    </form>`;
                    // inject to 'page-content' of our app
                    $("#page-content").html(update_product_html);
                    
                    // chage page title
                    changePageTitle("Update Candidate Photo");
            });
        });
    });
     
  
});