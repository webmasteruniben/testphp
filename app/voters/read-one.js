$(document).ready(function(){
 
    // handle 'read one' button click
    console.log('test')
    $(document).on('click', '.read-one-product-button', function(){
        // product ID will be here
        // get product id
        var id = $(this).attr('data-id');
        // read product record based on given ID
        $.getJSON("https://testphp.uniben.edu/api/voter/read_one.php?id=" + id, function(data){
            // read products button will be here
            // start html
            var read_one_product_html=`
            
                <!-- when clicked, it will show the product's list -->
                <div id='read-products' class='btn btn-primary pull-right m-b-15px read-products-button'>
                    <span class='glyphicon glyphicon-list'></span> Read Voters
                </div>
                <!-- product data will be shown in this table -->
                <table class='table table-bordered table-hover'>
                
                    <!-- product name -->
                    <tr>
                        <td class='w-30-pct'>First Name</td>
                        <td class='w-70-pct'>` + data.firstname + `</td>
                    </tr>

                    <tr>
                        <td class='w-30-pct'>Middle Name</td>
                        <td class='w-70-pct'>` + data.middlename + `</td>
                    </tr>

                    <tr>
                        <td class='w-30-pct'>Last Name</td>
                        <td class='w-70-pct'>` + data.lastname + `</td>
                    </tr>
                
                    <tr>
                        <td class='w-30-pct'>Email</td>
                        <td class='w-70-pct'>` + data.email + `</td>
                    </tr>

                    <tr>
                        <td class='w-30-pct'>Level</td>
                        <td class='w-70-pct'>` + data.level + `</td>
                    </tr>

                    <tr>
                        <td class='w-30-pct'>Faculty</td>
                        <td class='w-70-pct'>` + data.faculty + `</td>
                    </tr>

                    <tr>
                        <td class='w-30-pct'>Department</td>
                        <td class='w-70-pct'>` + data.department + `</td>
                    </tr>

                    <tr>
                        <td class='w-30-pct'>Student ID/Employee ID</td>
                        <td class='w-70-pct'>` + data.code + `</td>
                    </tr>

                    <tr>
                        <td class='w-30-pct'>Matriculation Number/Staff Number</td>
                        <td class='w-70-pct'>` + data.number + `</td>
                    </tr>

                    <tr>
                        <td class='w-30-pct'>Category</td>
                        <td class='w-70-pct'>` + data.category + `</td>
                    </tr>
                
                    <!-- product description -->
                    <tr>
                        <td>Status</td>
                        <td><h2>` + data.status + `</h2></td>
                    </tr>
                
                
                </table>`;

                // inject html to 'page-content' of our app
                $("#page-content").html(read_one_product_html);
                
                // chage page title
                changePageTitle("Create Voter");
        });
    });
 
});