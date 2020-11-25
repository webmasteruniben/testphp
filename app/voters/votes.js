$(document).ready(function(){
 
    // handle 'read one' button click
    console.log('test')
    $(document).on('click', '.vote-product-button', function(){
        // product ID will be here
        // get product id
        var id = $(this).attr('data-id');
        // read product record based on given ID
        $.getJSON("https://testphp.uniben.edu/api/electionvote/read_vote.php?id=" + id, function(data){


            
                    //<!-- start table -->
                   var read_one_product_html=`
            
                <!-- when clicked, it will show the product's list -->
                <div id='read-products' class='btn btn-primary pull-right m-b-15px read-products-button'>
                    <span class='glyphicon glyphicon-ok'></span> View Votes
                </div>
                <!-- product data will be shown in this table -->
                <table class='table table-bordered table-hover'>`;
            
            
                // loop through returned list of data
                $.each(data.records, function(key, val) {
            
                     read_one_product_html +=`
                                <tr>
                                <td>` + val.id + `</td>
                                <td>` + val.number + `</td>
                                <td>` + val.faculty + `</td>
                                <td>` + val.department + `</td>
                                <td>` + val.gender + `</td>
                                <td>` + val.position + `</td>
                            
                            </tr>`;
               
                });
            
                // end table
                read_one_product_html +=`</table>`;
                
                // inject html to 'page-content' of our app
                $("#page-content").html(read_one_product_html);
                
                // chage page title
                changePageTitle("Votes");

           

        });
    });
 
});