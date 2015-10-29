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
