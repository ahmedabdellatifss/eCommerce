
$(function () {

    'use strict' ;

    // Dashboard #74
    $('.toggle-info').click(function () {

        $(this).toggleClass('selected').parent().next('.panel-body').fadeToggle(100);

        if($(this).hasClass('.selected')){

            $(this).html('<i class="fa fa-minus fa-lg"></i>');

        }else{

            $(this).html('<i class="fa fa-plus fa-lg"></i>');

        }

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

    // Category view Option

    $('.cat h3').click(function () {

        $(this).next('.full-view').fadeToggle(200);

    });

    $('.option span').click(function () {

        $(this).addClass('active').siblings('span').removeClass('active');

        if ($(this).data('view') === 'full') {

            $('.cat .full-view').fadeIn(200);

        }else {

            $('.cat .full-view').fadeOut(200);

        }

    });

}); 