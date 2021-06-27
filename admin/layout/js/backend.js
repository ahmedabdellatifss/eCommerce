
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

});