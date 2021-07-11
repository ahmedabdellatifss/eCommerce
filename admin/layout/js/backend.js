
$(function () {

    'use strict' ;

    // Hide Placeholder On Form Focus
    $('[placeholder]').focus(function (){

        $(this).attr('data-text' , $(this).attr('placeholder')); // it is make attribute his name data-text and take the content of palceholder and keep it in varible data-text

        $(this).attr('placeholder' , '') ; // here you say that content for place holder is empty

    }).blur(function () {
        // her when blur in faild it will fill the placeholder by content that we keep in attribute (data-text)
         $(this).attr('placeholder', $(this).attr('data-text'));
    });

    // Add Asterisk on Required Field 

    $('input').each(function () {

        if ($(this).attr('required') === 'required') {

            $(this).after('<span class="asterisk">*</span>');
        }
    }); 

    // Convert Password field to text field on hover

    var passField = $('.password');

    $('.show-pass').hover(function () {

        passField.attr('type', 'text');

    }, function () {
    
        passField.attr('type', 'password');

    });

    // confirmation Message on Button delete in Member page

    $('.confirm').click(function (){

        return confirm('Are you sure?');
    });

}); 