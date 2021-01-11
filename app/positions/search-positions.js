$(document).ready(function(){
 
    // when a 'search products' button was clicked
    $(document).on('submit', '#search-product-form', function(){
 
        // get search keywords
        var keywords = $(this).find(":input[name='keywords']").val();
 
        // get data from the api based on search keywords
        $.getJSON("https://testphp.uniben.edu/api/position/search.php?s=" + keywords, function(data){
 
            // template in products.js
            readProductsTemplate(data, keywords);
 
            // chage page title
            changePageTitle("Search Positions: " + keywords);
 
        });
 
        // prevent whole page reload
        return false;
    });
 
});