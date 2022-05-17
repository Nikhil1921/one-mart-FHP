  'use strict';
/*$(window).on('load',function(){
    //Welcome Message (not for login page)
    function notify(message, type){
        $.growl({
            message: message
        },{
            type: type,
            allow_dismiss: true,
            label: 'Cancel',
            className: 'btn-xs btn-inverse',
            placement: {
                from: 'bottom',
                align: 'right'
            },
            delay: 2500,
            animate: {
                    enter: 'animated fadeInRight',
                    exit: 'animated fadeOutRight'
            },
            offset: {
                x: 30,
                y: 30
            }
        });
    };

   
    notify('Welcome to Notification page', 'success');
   
});*/

$(document).ready(function() {
   
    /*--------------------------------------
         Notifications & Dialogs
     ---------------------------------------*/
    /*
     * Notifications
     */
    function notify(title,message,from, align, icon, type, animIn, animOut){
        $.growl({
            icon: icon,
            title: '&nbsp&nbsp&nbsp'+title,
            message: message,
            url: ''
        },{
            element: 'body',
            type: type,
            allow_dismiss: true,
            placement: {
                from: from,
                align: align
            },
            offset: {
                x: 30,
                y: 30
            },
            spacing: 10,
            z_index: 999999,
            delay: 2500,
            timer: 1000,
            url_target: '_blank',
            mouse_over: false,
            animate: {
                enter: animIn,
                exit: animOut
            },
            icon_type: 'class',
            template: '<div data-growl="container" class="alert" role="alert">' +
            '<button type="button" class="close" data-growl="dismiss">' +
            '<span aria-hidden="true">&times;</span>' +
            '<span class="sr-only">Close</span>' +
            '</button>' +
            '<span data-growl="icon"></span>' +
            '<span data-growl="title"></span>' +
            '<span data-growl="message"></span>' +
            '<a href="#" data-growl="url"></a>' +
            '</div>'
        });
    };

    /*$('.notifications .btn').on('click',function(e){
        e.preventDefault();
        var nFrom = $(this).attr('data-from');
        var nAlign = $(this).attr('data-align');
        var nIcons = $(this).attr('data-icon');
        var nType = $(this).attr('data-type');
        var nAnimIn = $(this).attr('data-animation-in');
        var nAnimOut = $(this).attr('data-animation-out');

        notify(nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut);
    });*/
    var succ = $("#success_alert").val();
    var err = $("#error_alert").val();

    if (succ != null) {
        var nFrom = $("#success_alert").attr('data-from');
        var nAlign = $("#success_alert").attr('data-align');
        var nIcons = $("#success_alert").attr('data-icon');
        var nType = $("#success_alert").attr('data-type');
        var nAnimIn = $("#success_alert").attr('data-animation-in');
        var nAnimOut = $("#success_alert").attr('data-animation-out');
        notify('Success | ',succ,nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut);
    }

    if (err != null) {
        var nFrom = $("#error_alert").attr('data-from');
        var nAlign = $("#error_alert").attr('data-align');
        var nIcons = $("#error_alert").attr('data-icon');
        var nType = $("#error_alert").attr('data-type');
        var nAnimIn = $("#error_alert").attr('data-animation-in');
        var nAnimOut = $("#error_alert").attr('data-animation-out');
        notify('Error | ',err, nFrom, nAlign, nIcons, nType, nAnimIn, nAnimOut);
    }
        
});

