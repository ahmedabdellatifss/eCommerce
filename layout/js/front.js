
$(function () {

    'use strict' ;

    // Switch Bettween Login & Signup

    $('.login-page h1 span').click(function () {

        $(this).addClass('selected').siblings() .removeClass('selected');

        $('.login-page form').hide();

        $( '.' + $(this).data('class')).fadeIn(100);
    });


    // Trigger the Selectbox # 62
    $("select").selectBoxIt({

		autoWidth: false

	});


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


    // confirmation Message on Button delete in Member page

    $('.confirm').click(function (){

        return confirm('Are you sure?');
    });

    $('.live-name').keyup(function () {

        $('.live-preview .caption h3').text($(this).val());

    });
    $('.live-desc').keyup(function () {

        $('.live-preview .caption p').text($(this).val());
        
    });
    $('.live-price').keyup(function () {

        $('.live-preview .price-tag').text('$' + $(this).val());
        
    });

}); 