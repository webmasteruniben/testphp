$(document).ready(function(){
 
    // show list of product on first load
    showProducts();
    // when a 'read products' button was clicked
    $(document).on('click', '.read-products-button', function(){
        showProducts();
    });
 
});
 
// showProducts() method will be here
// function to show list of products
// function to show list of products
function showProducts(){
 
    // get list of products from the API
    $.getJSON("http://testphp.uniben.edu/api/product/read.php", function(data){
 
        // html for listing products
        readProductsTemplate(data, "");
 
        // chage page title
        changePageTitle("Read Products");
 
    });
}