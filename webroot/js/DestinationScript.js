//destination auto complete search function 
var prev = [];
$(document).ready(function(){
   // alert("document loaded");
     $.getJSON("index",function(destination){
            $.each(destination,function(index,value){
                    prev.push(value);
            });
        });
        
        var status = $('.error-div').text();
        if(status){
           //$('.autocomplete').hide(); 
           $('#pagination').hide(); 
        }
        var flag = $('#status').val();
        if(flag){
           $('.page-counter').hide(); 
           $('#pagination').hide(); 
        }
        
});

 $('#autocomplete').autocomplete({
            source: prev
        });




//adding new configuration record ajax function

    $('.add-conf-btn').click(function(){
        $('.add-conf-btn').text('Please wait');
        var key = $('#key').val();
        var value = $('#value').val();
        
        if(key){
        var data = {
            "key" : key,
            "value" : value
        };
        $.ajax({url:"add",
                type:"post",
                data:data,
                async:false,
                success:function(data ,status){
           if(data == 11){
            alert(" record successfully added.\n Please click cancel button to see list of configuration");}
        }});
        }else{
           $('.add-conf-btn').text('SAVE CONFIGURATION');
        }
    });
    
//hide pagination links in case of search destination
$('#searchbtn').click(function(){
   var value = $('#autocomplete').val();
   if(value){
       $('#pagination').hide();
   }
    
});
    



//pagination link acivation and deactivation functions
$('#next-btn').hover(
          
        function(){
            var value = 0;
         var value = $('#next-page').val();
         if(!value){
             $('#next-btn').addClass('dis-button');
             $('.nextDisabled').addClass('dis-button');
           }
        });
$('#prev-btn').hover(
          
        function(){
            var value = 0;
             var value = $('#prev-page').val();
           if(!value){
             $('#prev-btn').addClass('dis-button'); 
              $('.prevDisabled').addClass('dis-button');
           }
        });
//redirect to Add New Destination page
$('.hide-text').hide();
$('.add-dest-btn').on("click", function () {
   window.location = 'add'; 
});
//resirct to edit destination page
$('.edit-dest-btn').on("click", function () {
   window.location = 'edit'; 
});
$('.add-cancel-btn').on("click", function () {
   window.location = 'index'; 
});
/*
$('.edit-save-btn').on("click", function () {
  $('.show-edit-section').hide();
});
*/
$('.sign-out-link').on("click", function(){
    
});







  
   

		


