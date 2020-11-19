$(document).ready(function(){
 
    // handle 'read one' button click
    console.log('test')
    $(document).on('click', '.read-one-product-button', function(){
        // product ID will be here
        // get product id
        var id = $(this).attr('data-id');
        // read product record based on given ID
        $.getJSON("https://testphp.uniben.edu/api/product/read_one.php?id=" + id, function(data){
            // read products button will be here
            // start html
            var read_one_product_html=`
            
                <!-- when clicked, it will show the product's list -->
                <div id='read-products' class='btn btn-primary pull-right m-b-15px read-products-button'>
                    <span class='glyphicon glyphicon-list'></span> View Candidates
                </div>
                <!-- product data will be shown in this table -->
                <table class='table table-bordered table-hover'>
                
                    <!-- product photo -->
                    <tr>
                        <td class='w-30-pct'>Photo</td>
                        <td class='w-70-pct'><img src='images/` + data.profile_pic + `' style='height:50%;width:50%;'></td>
                    </tr>

                    <!-- product name -->
                    <tr>
                        <td class='w-30-pct'>Name</td>
                        <td class='w-70-pct'>` + data.name + `</td>
                    </tr>
                
                    <!-- product price -->
                    <tr>
                        <td>Position</td>
                        <td>` + data.price + `</td>
                    </tr>
                
                    <!-- product description -->
                    <tr>
                        <td>Description</td>
                        <td>` + data.description + `</td>
                    </tr>
                
                    <!-- product category name -->
                    <tr>
                        <td>Category</td>
                        <td>` + data.category_name + `</td>
                    </tr>
                
                </table>`;

                // inject html to 'page-content' of our app
                $("#page-content").html(read_one_product_html);
                
                // chage page title
                changePageTitle("Update Candidate");
        });
    });
 
});