"use strict";
$(document).ready(function() {
    // $('.pcoded-header').attr("header-theme", 'theme6');
    // $('.navbar-logo').attr("logo-theme", 'theme6');
    // $('.pcoded-navbar').attr("navbar-theme", 'theme6');

    $('.time-picker').timepicki({
        increase_direction: 'up',
        min_hour_value: 0,
        max_hour_value: 23,
        show_meridian: false
    });

    $(document).on('click', '.delete', function(e) {
        e.preventDefault();
        swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this!",
                icon: "error",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    $(this).parents().submit();
                } else {
                    return false;
                }
            });
    });

    $(document).on('click', '.block', function(e) {
        e.preventDefault();
        swal({
                title: "Are you sure?",
                text: "Want to block?",
                icon: "error",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    $(this).parents().submit();
                } else {
                    return false;
                }
            });
    });

    $(document).on('click', '.unblock', function(e) {
        e.preventDefault();
        swal({
                title: "Are you sure?",
                text: "You want to unblock?",
                // icon: "error",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    $(this).parents().submit();
                } else {
                    return false;
                }
            });
    });

    $(document).on('click', '.update', function(e) {
        e.preventDefault();
        swal({
                title: "Are you sure?",
                text: "This Balance will be added to the vendor's Wallet!",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    $(this).parents().submit();
                } else {
                    return false;
                }
            });
    });

    $(".custom-select").dateDropper({
        dropWidth: 200,
        init_animation: "bounce",
        dropPrimaryColor: "#1abc9c",
        dropBorder: "1px solid #1abc9c",
        minYear: "2019",
        maxYear: "2030",
    });

    var url = $("#url").val();

    var table = $('#dataTable').DataTable({
        "processing": true,
        "serverSide": true,
        'language': {
            'loadingRecords': '&nbsp;',
            'processing': '<img src="./assets/loader.gif" />',
            'paginate': {
                'first': '|',
                'next': '<i class="fa fa-arrow-circle-right"></i>',
                'previous': '<i class="fa fa-arrow-circle-left"></i>',
                'last': '|'
            }
        },
        "order": [],

        "ajax": {
            url: url,
            type: "POST",
            data: function(data) {
                data.status = $('#cust-status').val();
                /*data.end_date = $('#end_date').val();*/
            },
        },
        "columnDefs": [{
            "targets": 'target',
            "orderable": false,
        }, ],
    });

    var dash_table = $('.dom-table').DataTable({
        "processing": true,
        "serverSide": true,
        'language': {
            'loadingRecords': '&nbsp;',
            'processing': '<img src="./assets/loader.gif" />',
            'paginate': {
                'first': '|',
                'next': '<i class="fa fa-arrow-circle-right"></i>',
                'previous': '<i class="fa fa-arrow-circle-left"></i>',
                'last': '|'
            }
        },
        "order": [],

        "ajax": {
            url: url,
            type: "POST",
            data: function(data) {
                data.status = $('#status').val();
                data.for_vendor = $('#for_vendor').val();
                data.number_hide = $('#number_hide').val();
            },
        },
        "columnDefs": [{
            "targets": 'target',
            "orderable": false,
        }, ],
        "drawCallback": function(settings) {}
    });

    if ($('#dashboard').val() == 'dashboard') {
        function startTime() {
            var today = new Date();
            var s = today.getSeconds();
            s = checkTime(s);
            dash_table.ajax.reload();
            var t = setTimeout(function() { startTime() }, 60000);
        }

        function checkTime(i) {
            return i;
        }

        startTime()
    }

    $(".nav-link").click(function() {

        // var status = $('.table .table-striped .table-bordered .nowrap .dom-table').data('status');
        var id = $(this).attr('href').replace("#", "");
        var status = $("#" + id + ' table:first-child').data('status');
        $('#status').val(status);
        dash_table.ajax.reload();
    });

    $(document).on('click', '#add-sub_menu', function() {

        var sub_menu = $("input[type='text'][name='sub_menu']").val();
        var sub_url = $("input[type='text'][name='sub_url']").val();

        $('.add-sub_menu').append('<div class="form-group row"><div class="col-sm-2"><label class="col-form-label" for="sub_menu_add">Sub Menu Name</label></div><div class="col-sm-4"><input type="text" class="form-control" name="sub_menu[]" id="sub_menu_add"></div><div class="col-sm-2"><label class="col-form-label" for="sub_url_add">Sub Menu URL</label></div><div class="col-sm-3"><input type="text" class="form-control" name="sub_url[]" id="sub_url_add"></div><div class="col-sm-1"><button type="button" class="btn btn-danger btn-round waves-effect waves-light fa fa-minus remove-button"></button></div></div>');
        $('#sub_menu_add').attr('value', sub_menu);
        $('#sub_menu_add').attr('readonly', 'readonly');
        $('#sub_menu_add').attr('id', 'sub_menu_' + sub_menu);
        $('#sub_url_add').attr('value', sub_url);
        $('#sub_url_add').attr('readonly', 'readonly');
        $('#sub_url_add').attr('id', 'sub_url_' + sub_url);
        $("input[type='text'][name='sub_menu']").val('');
        $("input[type='text'][name='sub_url']").val('');
    })

    $(document).on('click', '.remove-button', function() {
        $(this).parent('div').parent('div').remove();
    })

    $(document).on('change', '.priority', function() {
        $(this).parent('form').submit();
    })

    $('.category').on('change', function() {
        var id = $(this).val();
        var url = $('#caturl').val();
        var val = $(this).data("value");
        var dependent = $(this).data('dependent');

        if (id == "") {
            $("#" + dependent).html('<option value="">Select Sub Category</option>');
            $('.sub_cat_id').trigger('change');
        } else {
            var select = $(this).attr('id');
            $.ajax({
                url: url,
                method: "POST",
                async: false,
                data: { id: id, select: select },
                success: function(result) {
                    $("#" + dependent).html(result);
                    $('#' + dependent).val(val);
                },
            })
        }
    })
    $('.category').trigger('change');

    $('.sub_cat_id').on('change', function() {
        var id = $(this).val();
        var url = $('#serviceurl').val();

        if (id == "") {
            $(".view-service").children('div').remove();
        } else {
            $.ajax({
                url: url,
                method: "POST",
                async: false,
                data: { id: id },
                success: function(result) {
                    $(".view-service").html(result);
                },
            })
        }
    })

    $('.sub_cat_id').trigger('change');

    $(document).on('click', '.add-ser', function(e) {
        e.preventDefault();
        $(".view-service").children('div').clone().appendTo(".add-service");
        $('.category').val('');
        $('.sub_cat_id').val('');
        $('.sub_cat_id').trigger('change');
        $('.add-ser').parents().first('div').html('<button class="btn btn-danger btn-round waves-effect waves-light fa fa-minus rem-ser"></button>');
    });

    $(document).on('click', '.rem-ser', function(e) {
        e.preventDefault();
        $(this).parents('.remove-ser').remove();
    });

    $('#cust-status').on('change', function() {
        table.ajax.reload();
    })

    $(document).on('click', '.add-promo', function(e) {
        e.preventDefault();
        var val = $('#ser_id').children("option:selected").html();
        var id = $('#ser_id').children("option:selected").val();
        if (id != "") {
            $('.add-promocode').append('<div class="col-md-6 remove-ser"><div class="form-group row"><div class="col-sm-4"><label class="col-form-label">Membership Name</label></div><div class="col-sm-6"><input type="hidden" name="mem_id[]" value="' + id + '"><input type="text" value="' + val + '" class="form-control" disabled=""></div><div class="col-sm-1"><button class="btn btn-danger btn-round waves-effect waves-light fa fa-minus rem-ser"></button></div></div></div>');
            $('#ser_id').val('');
        }
    });

    $("#add-condition").click(function() {
        var condition = $("#conditions").val();
        if (condition != "") {
            $('#view-condition').append('<div class="col-md-6" id="' + condition + '"><div class="form-group row"><div class="col-sm-4"><label class="col-form-label" for="' + condition + '">Service Conditions</label></div><div class="col-sm-6"><input type="text" class="form-control" name="conditions[]" id="' + condition + '" value="' + condition + '" readonly /></div><div class="col-sm-2"><button type="button" class="btn btn-danger btn-round waves-effect waves-light fa fa-minus remove-condition" data-id="' + condition + '"></button></div></div></div>');
            $('#conditions').val('');
        } else {
            return false;
        }

    });

    $(document).on('click', ".remove-condition", function() {
        var condition = $(this).data('id');
        $('#' + condition).remove();
    });

    /*$('.access').on('submit', function(e){
        e.preventDefault();
        var check = $(this).find("input[type='checkbox'][name='operation[]']:checked").length;
        
        if (check > 0) {
            $(this).unbind('submit').submit();
        }    
        else{
            swal('Error!', 'Select Atleast One Access!', 'error');
        }
    })*/
    /*
     * Notifications
     */
    function notify(title, message, from, align, icon, type, animIn, animOut) {
        $.growl({
            icon: icon,
            title: '&nbsp&nbsp&nbsp' + title,
            message: message,
            url: ''
        }, {
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

    $('.remove-image').click(function() {
        var img = $(this).data('id');
        var remove = $(this).data('remove');
        $.ajax({
            url: $('#slider-url').val(),
            method: "POST",
            dataType: 'json',
            async: false,
            data: { image: img, id: $('#cat-id').val() },
            success: function(result) {
                if (result.error == false) {
                    notify('Success | ', result.message, 'top', 'right', 'fa fa-check', 'success', 'animated fadeInDown', 'animated fadeOutDown');
                    $('#' + remove).remove();
                } else
                    notify('Error | ', result.message, 'top', 'right', 'fa fa-exclamation-triangle', 'danger', 'animated fadeInDown', 'animated fadeOutDown');

            },
        })
    });

    /*$('.image').on('click', function(){
        var image = $(this).data('value');
        var img = $(this).data('id');
        var url = $('#imageurl').val();
        swal({
              title: "Are you sure?",
              text: "Once deleted, you will not be able to recover this!",
              icon: "error",
              buttons: true,
              dangerMode: true,
            })
            .then((willDelete) => {
              if (willDelete) {
                $.ajax({  
                     url:url,   
                     method:"POST",  
                     data:{img:image},  
                     async:false,
                     success:function(data)  
                     {  
                        if (!data.includes("not")) {
                            notify('Success | ',data,'top', 'right', 'fa fa-check', 'success', 'animated fadeInDown', 'animated fadeOutDown');
                            $('.'+img).remove();
                            $(this).remove();
                        }else{
                            notify('Error | ',data,'top', 'right', 'fa fa-exclamation-triangle', 'danger', 'animated fadeInDown', 'animated fadeOutDown');    
                        }
                     }  
                });
              } else {
                
              }
            });
    });*/

    $(".js-example-placeholder-multiple").select2({
        placeholder: "Select Vendor Services"
    });

    // card js start
    $(".card-header-right .close-card").on('click', function() {
        var $this = $(this);
        $this.parents('.card').animate({
            'opacity': '0',
            '-webkit-transform': 'scale3d(.3, .3, .3)',
            'transform': 'scale3d(.3, .3, .3)'
        });

        setTimeout(function() {
            $this.parents('.card').remove();
        }, 800);
    });
    $(".card-header-right .reload-card").on('click', function() {
        var $this = $(this);
        $this.parents('.card').addClass("card-load");
        $this.parents('.card').append('<div class="card-loader"><i class="feather icon-radio rotate-refresh"></div>');
        setTimeout(function() {
            $this.parents('.card').children(".card-loader").remove();
            $this.parents('.card').removeClass("card-load");
        }, 3000);
    });
    $(".card-header-right .card-option .open-card-option").on('click', function() {
        var $this = $(this);
        if ($this.hasClass('icon-x')) {
            $this.parents('.card-option').animate({
                'width': '30px',
            });
            $this.parents('.card-option').children('li').children(".open-card-option").removeClass("icon-x").fadeIn('slow');
            $this.parents('.card-option').children('li').children(".open-card-option").addClass("icon-chevron-left").fadeIn('slow');
            $this.parents('.card-option').children(".first-opt").fadeIn();
        } else {
            $this.parents('.card-option').animate({
                'width': '130px',
            });
            $this.parents('.card-option').children('li').children(".open-card-option").addClass("icon-x").fadeIn('slow');
            $this.parents('.card-option').children('li').children(".open-card-option").removeClass("icon-chevron-left").fadeIn('slow');
            $this.parents('.card-option').children(".first-opt").fadeOut();
        }
    });
    $(".card-header-right .minimize-card").on('click', function() {
        var $this = $(this);
        var port = $($this.parents('.card'));
        var card = $(port).children('.card-block').slideToggle();
        $(this).toggleClass("icon-minus").fadeIn('slow');
        $(this).toggleClass("icon-plus").fadeIn('slow');
    });
    $(".card-header-right .full-card").on('click', function() {
        var $this = $(this);
        var port = $($this.parents('.card'));
        port.toggleClass("full-card");
        $(this).toggleClass("icon-minimize");
        $(this).toggleClass("icon-maximize");
    });
    $("#more-details").on('click', function() {
        $(".more-details").slideToggle(500);
    });
    $(".mobile-options").on('click', function() {
        $(".navbar-container .nav-right").slideToggle('slow');
    });
    $(".search-btn").on('click', function() {
        $(".main-search").addClass('open');
        $('.main-search .form-control').animate({
            'width': '200px',
        });
    });
    $(".search-close").on('click', function() {
        $('.main-search .form-control').animate({
            'width': '0',
        });
        setTimeout(function() {
            $(".main-search").removeClass('open');
        }, 300);
    });
    // card js end
    $("#styleSelector .style-cont").slimScroll({
        setTop: "1px",
        height: "calc(100vh - 480px)",
    });
    /*chatbar js start*/
    /*chat box scroll*/
    var a = $(window).height() - 80;
    $(".main-friend-list").slimScroll({
        height: a,
        allowPageScroll: false,
        wheelStep: 5
    });
    var a = $(window).height() - 155;
    $(".main-friend-chat").slimScroll({
        height: a,
        allowPageScroll: false,
        wheelStep: 5
    });

    // search
    $("#search-friends").on("keyup", function() {
        var g = $(this).val().toLowerCase();
        $(".userlist-box .media-body .chat-header").each(function() {
            var s = $(this).text().toLowerCase();
            $(this).closest('.userlist-box')[s.indexOf(g) !== -1 ? 'show' : 'hide']();
        });
    });

    // open chat box
    $('.displayChatbox').on('click', function() {
        var my_val = $('.pcoded').attr('vertical-placement');
        if (my_val == 'right') {
            var options = {
                direction: 'left'
            };
        } else {
            var options = {
                direction: 'right'
            };
        }
        $('.showChat').toggle('slide', options, 500);
    });

    //open friend chat
    $('.userlist-box').on('click', function() {
        var my_val = $('.pcoded').attr('vertical-placement');
        if (my_val == 'right') {
            var options = {
                direction: 'left'
            };
        } else {
            var options = {
                direction: 'right'
            };
        }
        $('.showChat_inner').toggle('slide', options, 500);
    });
    //back to main chatbar
    $('.back_chatBox').on('click', function() {
        var my_val = $('.pcoded').attr('vertical-placement');
        if (my_val == 'right') {
            var options = {
                direction: 'left'
            };
        } else {
            var options = {
                direction: 'right'
            };
        }
        $('.showChat_inner').toggle('slide', options, 500);
        $('.showChat').css('display', 'block');
    });
    $('.back_friendlist').on('click', function() {
        var my_val = $('.pcoded').attr('vertical-placement');
        if (my_val == 'right') {
            var options = {
                direction: 'left'
            };
        } else {
            var options = {
                direction: 'right'
            };
        }
        $('.p-chat-user').toggle('slide', options, 500);
        $('.showChat').css('display', 'block');
    });
    // /*chatbar js end*/
    $('[data-toggle="tooltip"]').tooltip();

    // wave effect js
    Waves.init();
    Waves.attach('.flat-buttons', ['waves-button']);
    Waves.attach('.float-buttons', ['waves-button', 'waves-float']);
    Waves.attach('.float-button-light', ['waves-button', 'waves-float', 'waves-light']);
    Waves.attach('.flat-buttons', ['waves-button', 'waves-float', 'waves-light', 'flat-buttons']);

    // $('#mobile-collapse i').addClass('icon-toggle-right');
    // $('#mobile-collapse').on('click', function() {
    //     $('#mobile-collapse i').toggleClass('icon-toggle-right');
    //     $('#mobile-collapse i').toggleClass('icon-toggle-left');
    // });
    // materia form

    $('.form-control').on('blur', function() {
        if ($(this).val().length > 0) {
            $(this).addClass("fill");
        } else {
            $(this).removeClass("fill");
        }
    });
    $('.form-control').on('focus', function() {
        $(this).addClass("fill");
    });
    $('#mobile-collapse i').addClass('icon-toggle-right');
    $('#mobile-collapse').on('click', function() {
        $('#mobile-collapse i').toggleClass('icon-toggle-right');
        $('#mobile-collapse i').toggleClass('icon-toggle-left');
    });
});
$(document).ready(function() {
    var $window = $(window);
    // $('.loader-bar').animate({
    //     width: $window.width()
    // }, 1000);
    // setTimeout(function() {
    // while ($('.loader-bar').width() == $window.width()) {
    // $(window).on('load',function(){
    $('.loader-bg').fadeOut();
    // });

    // break;

    // }
    // }, 2000);
    // $("#dropper-animation").dateDropper( {
    //                     dropWidth: 200, 
    //                     init_animation: "bounce",
    //                     dropPrimaryColor: "#1abc9c",
    //                     dropBorder: "1px solid #1abc9c"
    //                 });
});

// toggle full screen
function toggleFullScreen() {
    var a = $(window).height() - 10;

    if (!document.fullscreenElement && // alternative standard method
        !document.mozFullScreenElement && !document.webkitFullscreenElement) { // current working methods
        if (document.documentElement.requestFullscreen) {
            document.documentElement.requestFullscreen();
        } else if (document.documentElement.mozRequestFullScreen) {
            document.documentElement.mozRequestFullScreen();
        } else if (document.documentElement.webkitRequestFullscreen) {
            document.documentElement.webkitRequestFullscreen(Element.ALLOW_KEYBOARD_INPUT);
        }
    } else {
        if (document.cancelFullScreen) {
            document.cancelFullScreen();
        } else if (document.mozCancelFullScreen) {
            document.mozCancelFullScreen();
        } else if (document.webkitCancelFullScreen) {
            document.webkitCancelFullScreen();
        }
    }
    $('.full-screen').toggleClass('icon-maximize');
    $('.full-screen').toggleClass('icon-minimize');
}