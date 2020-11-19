$(document).ready(function(){
 
    // show html form when 'update product' button was clicked
    $(document).on('click', '.count-vote-button', function(){
        // product ID will be here
        // get product id
        var id = $(this).attr('data-id');
        setInterval(function(){ 
            
        console.log(id);

        var update_product_html =`<div class="row"><h2>View Vote Count</h2></div><div class="row">`;
        // read one record based on given product id

        
        $.getJSON("https://testphp.uniben.edu/api/electionvote/count_vote.php?id=" + id, function(data){

            // loop through returned list of data
            $.each(data.records, function(key, val) {
                console.log(val.candidate);
                // creating new table row per record
                update_product_html+=`<div class="col-sm-6">
                                <div class="card">
                            <img src="images/` + val.profile_pic + `" class="card-img-top" alt="..." style="height:285px;">
                            <div class="card-body">
                                <h1 class="card-title">` + val.candidate + `</h1>
                                <h3 class="card-text">` + val.price + `</h3>
                            </div>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item"><h2>` + val.election + `</h2></li>
                                <li class="list-group-item"><span style="font-size:500%">` + val.votes + `</span></li>
                                
                            </ul>
                            <div class="card-body">
                               <!-- <button class='card-link btn btn-primary m-r-10px select-product-button' data-id='` + data.id + `'>
                                    <span class='glyphicon glyphicon-ok-circle'></span> Vote Candidate
                                </button>-->
                                
                                
                            </div>
                            </div>
                            </div>`;
            });
        
            update_product_html+=`</div>`;
            // inject to 'page-content' of our app
            $("#page-content").html(update_product_html);
            
            // chage page title
            changePageTitle("Count Votes");
            
        });
         }, 3000);
        
    });
     
    // 'update product form' submit handle will be here
    // will run if 'create product' form was submitted
    $(document).on('submit', '#update-product-form', function(){
        
        // get form data will be here 
        // get form data
        var form_data=JSON.stringify($(this).serializeObject());
        // submit form data to api
        $.ajax({
            url: "https://testphp.uniben.edu/api/election/update.php",
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