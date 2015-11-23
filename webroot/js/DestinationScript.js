$('.next-span').hover(
          
        function(){
            var value = 0;
         var value = $('#next-page').val();
         if(!value){
             $('.next-span').addClass('dis-button');
             $('.nextDisabled').addClass('dis-button');
           }
        });
$('.prev-span').hover(
          
        function(){
            var value = 0;
             var value = $('#prev-page').val();
           if(!value){
             $('.prev-span').addClass('dis-button'); 
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

$('.edit-save-btn').on("click", function () {
  $('.show-edit-section').hide();
});

$('.sign-out-link').on("click", function(){
    
});






$(document).ready(function(){

    var counter = 2;//$("#add-option").val();
  
   

		
$("#add-option").click(function () {
				
	if(counter>10){
            alert("Only 10 textboxes allow");
            return false;
	}   
		
	var newTextBoxDiv = $(document.createElement('div'))
	     .attr("class", 'form-group').attr('id','newOption'+counter);
                
	newTextBoxDiv.after().html('<label for="Options" class="col-sm-2 control-label">Option '+ counter + ' </label>' +
	      ' <div class="col-sm-8"><input type="text" name="option' + counter + 
	      '" class="form-control" placeholder ="Option' + counter + '"></div>');
            
	newTextBoxDiv.appendTo("#options");

				
	counter++;
     });

$("#remove-option").click(function () {

        if(counter===1){
              alert("No more textbox to remove");
              return false;
        }   
        
	counter--;
			
        $("#newOption" + counter).remove();
			
     });
		
     $("#getButtonValue").click(function () {
		
	var msg = '';
	for(i=1; i<counter; i++){
   	  msg += "\n Textbox #" + i + " : " + $('#textbox' + i).val();
	}
    	  alert(msg);
     });
  });
