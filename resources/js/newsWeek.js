$(function() {

    // Configuration DataTable.
    $('#tb-list-authors').DataTable({
       dom: 'Bfrtip',
       buttons: [
           'copyHtml5',
           'excelHtml5',
           'csvHtml5',
           'pdfHtml5'
       ]
   } );

   // Confirmation message to delete the author.
   var idAuthor = null;
   $(".delete-author").on('click', function() {        
       idAuthor = $(this).data('id');
       $("#exampleModal").modal('show');
   });

   // Redirect to delete controller.
   $("#btn-delete").on('click', function() {
       window.location.href = "AuthorDeleteControl.php?id="+idAuthor;
   });
});
