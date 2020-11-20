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


                        <div class="form-group">

                        <img width="300px" src="images/` + profile_pic + `" class="image-responsive" alt="` + name +`">

                        </div>
                        <div class="form-group">
                            <label for="profile_photo">Profile Picture</label>
                            
                            <input type="file" class="form-control" name="profile_photo" id="profile_photo" />
                        </div>
            
                        
            
                        <div class="form-group">
                            
                            <input type="text" class="form-control" name="username" id="username" value="` + name + `" />
                        </div>

                        <div class="form-group">
                            
                            <input type="hidden" class="form-control" name="id" id="id" value="` + id + `" />
                        </div>

                        <div class="form-group">
                            <input type="submit" name="submit" class="btn btn-primary" >
                        </div>
            
                        <!--<button type='submit' class='btn btn-primary'>
                            Save Changes
                        </button>-->
                        
                    </form>`;
                    // inject to 'page-content' of our app
                    $("#page-content").html(update_product_html);
                    
                    // chage page title
                    changePageTitle("Update Candidate Photo");
            });
        });
    });
     
  
});