$(function() {

    // Show div phones.
    if( $.trim($( '#tb-phones tbody' ).html()) != "") {
        $( ".hide-field" ).show();
    }


    // Add Phone on table.
    $( '#icon-plus-phone' ).on( 'click', function() {

        // Get Phone and Oparator informed by user.
        var phone = $( "#inputPhone" ).val();
        var operator = $( "#select-operator option:selected" ).val();

        // Replace the markers, with the entered data informed by user.
        var templateAux = templatePhone;
        templateAux = templateAux.replaceAll( ":phone", phone );
        templateAux = templateAux.replaceAll( ":operator", operator );        

        $( '#tb-phones tbody' ).append( templateAux ); // Add new row in table.
        $( ".hide-field" ).show(); // Show div phones.
        $( "#inputPhone" ).val(""); // Clear phone field.
        $( "#select-operator" ).val(""); // Clear operator field.
    });


    // Delete phone from table.
    $( "#tb-phones" ).on( 'click', '.delete-phone', function() {
        
        $( this ).closest( 'tr' ).remove();

        if( $.trim( $( "#tb-phones tbody" ).html() ) == "" ) {
            $( ".hide-field" ).hide();
        }
    });

});


// Replace all.
String.prototype.replaceAll = function(search, replacement) {
    var target = this;
    return target.split(search).join(replacement);
};