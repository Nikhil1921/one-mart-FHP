$(document).ready(function(){
    var url = window.location.href;

    $('#loginForm').bootstrapValidator({
        excluded: [':disabled', ':hidden', ':not(:visible)'],
        feedbackIcons: {
            valid: 'fa fa-check log_valid',
            invalid: 'fa fa-close log_invalid',
            validating: 'fa fa-spinner',
        },
        fields: {
            mobile: {
                validators: {
                    notEmpty: {
                        message: 'The Mobile is required'
                    },
                    stringLength: {
                        min: 10,
                        max: 10,
                        message: 'The Mobile must be 10 characters long'
                    },
                    regexp: {
                        regexp: /^[0-9]+$/,
                        message: 'The Mobile can only consist of number'
                    }
                }
            },
            password: {
                validators: {
                    notEmpty: {
                        message: 'The Password is required'
                    },
                    regexp: {
                        regexp: /^[a-zA-Z0-9_]+$/,
                        message: 'The Password can only consist of alphabetical, number and underscore'
                    }
                }
            }
        }
    });

    $('#operation_form').bootstrapValidator({
        excluded: [':disabled', ':hidden', ':not(:visible)'],
        feedbackIcons: {
            valid: 'fa fa-check valid',
            invalid: 'fa fa-close invalid',
            validating: 'fa fa-spinner',
        },
        fields: {
            type: {
                validators: {
                    notEmpty: {
                        message: 'The operation type is required'
                    },
                    regexp: {
                        regexp: /^[a-zA-Z]+$/,
                        message: 'The operation type can only consist of alphabetical'
                    }
                }
            }
        }
    });

    $('#menu_form').bootstrapValidator({
        excluded: [':disabled', ':hidden', ':not(:visible)'],
        feedbackIcons: {
            valid: 'fa fa-check valid',
            invalid: 'fa fa-close invalid',
            validating: 'fa fa-spinner',
        },
        fields: {
            name: {
                validators: {
                    notEmpty: {
                        message: 'The Menu Name is required'
                    },
                    regexp: {
                        regexp: /^[a-zA-Z ]+$/,
                        message: 'The Menu Name can only consist of alphabetical'
                    }
                }
            }
        }
    });

    $('#role_form').bootstrapValidator({
        excluded: [':disabled', ':hidden', ':not(:visible)'],
        feedbackIcons: {
            valid: 'fa fa-check valid',
            invalid: 'fa fa-close invalid',
            validating: 'fa fa-spinner',
        },
        fields: {
            role: {
                validators: {
                    notEmpty: {
                        message: 'The role Name is required'
                    },
                    regexp: {
                        regexp: /^[a-zA-Z 0-9_]+$/,
                        message: 'The role Name can only consist of alphabetical'
                    }
                }
            }
        }
    });

    $('#userForm').bootstrapValidator({
        excluded: [':disabled', ':hidden', ':not(:visible)'],
        feedbackIcons: {
            valid: 'fa fa-check valid',
            invalid: 'fa fa-close invalid',
            validating: 'fa fa-spinner',
        },
        fields: {
            role: {
                validators: {
                    notEmpty: {
                        message: 'The Role is required'
                    }
                }
            },
            mobile: {
                validators: {
                    notEmpty: {
                        message: 'The Mobile is required'
                    },
                    stringLength: {
                        min: 10,
                        max: 10,
                        message: 'The Mobile must be 10 characters long'
                    },
                    regexp: {
                        regexp: /^[0-9]+$/,
                        message: 'The Mobile can only consist of number'
                    }
                }
            },
            email: {
                validators: {
                    notEmpty: {
                        message: 'The Email Address is required'
                    },
                    emailAddress: {
                        message: 'The Email Address is not valid'
                    },
                    regexp: {
                        regexp: /^[a-zA-Z_@0-9.]+$/,
                        message: 'The Email Address is not valid'
                    }
                }
            },
            password: {
                validators: {
                    notEmpty: {
                        message: 'The Password is required'
                    },
                    regexp: {
                        regexp: /^[a-zA-Z0-9_]+$/,
                        message: 'The Password can only consist of alphabetical, number and underscore'
                    }
                }
            },
            c_password: {
                validators: {
                    notEmpty: {
                        message: 'The Confirm Password is required'
                    },
                    identical: {
                        field: 'password',
                        message: 'The Password and confirm password must be same'
                    }
                }
            },
            username: {
                validators: {
                    notEmpty: {
                        message: 'The User Name is required'
                    },
                    regexp: {
                        regexp: /^[a-zA-Z_ ]+$/,
                        message: 'The User Name is not valid'
                    }
                }
            },
            image: {
                validators: {
                    notEmpty: {
                        message: 'The User Image is required'
                    },
                    file: {
                        extension: 'jpeg,jpg',
                        type: 'image/jpeg,image/jpg',
                        maxSize: 2048 * 1024,
                        message: 'The selected User Image is not valid'
                    }
                }
            }
        }
    });

    
    if (url.indexOf('/staff/update/') != -1) {
        var form = $("#userForm").attr("action");
        var str2 = "/staff/update/";
        if(form.indexOf(str2) != -1){
            $('#userForm').bootstrapValidator('enableFieldValidators','image', false, 'notEmpty');
            $('#userForm').bootstrapValidator('enableFieldValidators','password', false, 'notEmpty');
            $('#userForm').bootstrapValidator('enableFieldValidators','c_password', false, 'notEmpty');
        }
    }

    if (url.indexOf('/profile') != -1) {
        var form = $("#userForm").attr("action");
        var str2 = "/profile/update/";
        if(form.indexOf(str2) != -1){
            $('#userForm').bootstrapValidator('enableFieldValidators','image', false, 'notEmpty');
        }
    }

    $('#vendorForm').bootstrapValidator({
        excluded: [':disabled', ':hidden', ':not(:visible)'],
        feedbackIcons: {
            valid: 'fa fa-check valid',
            invalid: 'fa fa-close invalid',
            validating: 'fa fa-spinner',
        },
        fields: {
            mobile: {
                validators: {
                    notEmpty: {
                        message: 'The Mobile is required'
                    },
                    stringLength: {
                        min: 10,
                        max: 10,
                        message: 'The Mobile must be 10 characters long'
                    },
                    regexp: {
                        regexp: /^[0-9]+$/,
                        message: 'The Mobile can only consist of number'
                    }
                }
            },
            email: {
                validators: {
                    notEmpty: {
                        message: 'The Email Address is required'
                    },
                    emailAddress: {
                        message: 'The Email Address is not valid'
                    },
                    regexp: {
                        regexp: /^[a-zA-Z_@0-9.]+$/,
                        message: 'The Email Address is not valid'
                    }
                }
            },
            password: {
                validators: {
                    notEmpty: {
                        message: 'The Password is required'
                    },
                    regexp: {
                        regexp: /^[a-zA-Z0-9_]+$/,
                        message: 'The Password can only consist of alphabetical, number and underscore'
                    }
                }
            },
            c_password: {
                validators: {
                    notEmpty: {
                        message: 'The Confirm Password is required'
                    },
                    identical: {
                        field: 'password',
                        message: 'The Password and confirm password must be same'
                    }
                }
            },
            username: {
                validators: {
                    notEmpty: {
                        message: 'The Vendor Name is required'
                    },
                    regexp: {
                        regexp: /^[a-zA-Z_ ]+$/,
                        message: 'The Vendor Name is not valid'
                    }
                }
            },
            com_name: {
                validators: {
                    notEmpty: {
                        message: 'The Company Name is required'
                    },
                    regexp: {
                        regexp: /^[a-zA-Z_ ]+$/,
                        message: 'The Company Name is not valid'
                    }
                }
            },
            image: {
                validators: {
                    notEmpty: {
                        message: 'The Vendor Image is required'
                    },
                    file: {
                        extension: 'jpeg,jpg',
                        type: 'image/jpeg,image/jpg',
                        maxSize: 2048 * 1024,
                        message: 'The selected Vendor Image is not valid'
                    }
                }
            },
            gst_image: {
                validators: {
                    file: {
                        extension: 'jpeg,jpg',
                        type: 'image/jpeg,image/jpg',
                        maxSize: 2048 * 1024,
                        message: 'The selected GST Image is not valid'
                    }
                }
            },
            gst: {
                validators: {
                    regexp: {
                        regexp: /^[0-9a-zA-Z]+$/,
                        message: 'The Vendor GST is not valid'
                    }
                }
            },
            photo_image: {
                validators: {
                    file: {
                        extension: 'jpeg,jpg',
                        type: 'image/jpeg,image/jpg',
                        maxSize: 2048 * 1024,
                        message: 'The selected photo id Image is not valid'
                    }
                }
            },
            photo: {
                validators: {
                    regexp: {
                        regexp: /^[0-9a-zA-Z]+$/,
                        message: 'The Vendor photo id is not valid'
                    }
                }
            },
            /*pan_image: {
                validators: {
                    file: {
                        extension: 'jpeg,jpg',
                        type: 'image/jpeg,image/jpg',
                        maxSize: 2048 * 1024,
                        message: 'The selected Pan Image is not valid'
                    }
                }
            },
            pan: {
                validators: {
                    regexp: {
                        regexp: /^[0-9a-zA-Z]+$/,
                        message: 'The Vendor Pan is not valid'
                    }
                }
            },*/
            address: {
                validators: {
                    notEmpty: {
                        message: 'The Vendor Address is required'
                    }
                }
            },
            "cat_id[]": {
                validators: {
                    notEmpty: {
                        message: 'The Vendor Service is required'
                    }
                }
            }
        }
    });

    if (url.indexOf('/vendor/update/') != -1) {
        var form = $("#vendorForm").attr("action");
        var str2 = "/vendor/update/";
        if(form.indexOf(str2) != -1){
            $('#vendorForm').bootstrapValidator('enableFieldValidators','image', false, 'notEmpty');
            $('#vendorForm').bootstrapValidator('enableFieldValidators','password', false, 'notEmpty');
            $('#vendorForm').bootstrapValidator('enableFieldValidators','c_password', false, 'notEmpty');
        }
    }

    $('#catForm').bootstrapValidator({
        excluded: [':disabled', ':hidden', ':not(:visible)'],
        feedbackIcons: {
            valid: 'fa fa-check valid',
            invalid: 'fa fa-close invalid',
            validating: 'fa fa-spinner',
        },
        fields: {
            from_time: {
                validators: {
                    notEmpty: {
                        message: 'The From Time is required'
                    }
                }
            },
            to_time: {
                validators: {
                    notEmpty: {
                        message: 'The To Time is required'
                    }
                }
            },
            for_vendor: {
                validators: {
                    notEmpty: {
                        message: 'The for Contract is required'
                    }
                }
            },
            number_hide: {
                validators: {
                    notEmpty: {
                        message: 'The Hide Number is required'
                    }
                }
            },
            cat_name: {
                validators: {
                    notEmpty: {
                        message: 'The category Name is required'
                    },
                    regexp: {
                        regexp: /^[a-zA-Z_ ]+$/,
                        message: 'The category Name is not valid'
                    }
                }
            },
            image: {
                validators: {
                    notEmpty: {
                        message: 'The category Image is required'
                    },
                    file: {
                        extension: 'png',
                        type: 'image/png',
                        maxSize: 2048 * 1024,
                        message: 'The selected category Image is not valid'
                    }
                }
            },
            price: {
                validators: {
                    notEmpty: {
                        message: 'The Conract/Hide No. Price is required'
                    },
                    regexp: {
                        regexp: /^[0-9.]+$/,
                        message: 'The Conract/Hide No. Price is not valid'
                    }
                }
            },
        }
    });

    if (url.indexOf('/category/update/') != -1) {
        var form = $("#catForm").attr("action");
        var str2 = "/category/update/";
        if(form.indexOf(str2) != -1){
            $('#catForm').bootstrapValidator('enableFieldValidators','image', false, 'notEmpty');
        }
    }

    if (url.indexOf('/inquiryCategory/update/') != -1) {
        var form = $("#catForm").attr("action");
        var str2 = "/inquiryCategory/update/";
        if(form.indexOf(str2) != -1){
            $('#catForm').bootstrapValidator('enableFieldValidators','image', false, 'notEmpty');
        }
    }

    $('#subcatForm').bootstrapValidator({
        excluded: [':disabled', ':hidden', ':not(:visible)'],
        feedbackIcons: {
            valid: 'fa fa-check valid',
            invalid: 'fa fa-close invalid',
            validating: 'fa fa-spinner',
        },
        fields: {
            sub_cat: {
                validators: {
                    notEmpty: {
                        message: 'The Sub category name is required'
                    },
                    regexp: {
                        regexp: /^[a-zA-Z_ ]+$/,
                        message: 'The Sub category Name is not valid'
                    }
                }
            },
            cat_id: {
                validators: {
                    notEmpty: {
                        message: 'The category Name is required'
                    }
                }
            },
            image: {
                validators: {
                    notEmpty: {
                        message: 'The sub category Image is required'
                    },
                    file: {
                        extension: 'png,jpeg,jpg',
                        type: 'image/png,image/jpg,image/jpeg',
                        maxSize: 2048 * 1024,
                        message: 'The selected sub category Image is not valid'
                    }
                }
            }
        }
    });

    if (url.indexOf('/subCategory/update/') != -1) {
        var form = $("#subcatForm").attr("action");
        var str2 = "/subCategory/update/";
        if(form.indexOf(str2) != -1){
            $('#subcatForm').bootstrapValidator('enableFieldValidators','image', false, 'notEmpty');
        }
    }

    if (url.indexOf('/inquirySubCategory/update/') != -1) {
        var form = $("#subcatForm").attr("action");
        var str2 = "/inquirySubCategory/update/";
        if(form.indexOf(str2) != -1){
            $('#subcatForm').bootstrapValidator('enableFieldValidators','image', false, 'notEmpty');
        }
    }

    $('#serviceForm').bootstrapValidator({
        excluded: [':disabled', ':hidden', ':not(:visible)'],
        feedbackIcons: {
            valid: 'fa fa-check valid',
            invalid: 'fa fa-close invalid',
            validating: 'fa fa-spinner',
        },
        fields: {
            name: {
                validators: {
                    notEmpty: {
                        message: 'The Service name is required'
                    },
                    regexp: {
                        regexp: /^[a-zA-Z_ 0-9-+]+$/,
                        message: 'The Service Name is not valid'
                    }
                }
            },
            price: {
                validators: {
                    notEmpty: {
                        message: 'The Service price is required'
                    },
                    regexp: {
                        regexp: /^[0-9.]+$/,
                        message: 'The Service price is not valid'
                    }
                }
            },
            visiting_charge: {
                validators: {
                    notEmpty: {
                        message: 'The Visiting Charge is required'
                    },
                    regexp: {
                        regexp: /^[0-9.]+$/,
                        message: 'The Visiting Charge is not valid'
                    }
                }
            },
            cat_id: {
                validators: {
                    notEmpty: {
                        message: 'The category Name is required'
                    }
                }
            },
            sub_cat_id: {
                validators: {
                    notEmpty: {
                        message: 'The Sub category Name is required'
                    }
                }
            },
            description: {
                validators: {
                    notEmpty: {
                        message: 'The Service description is required'
                    }
                }
            },
            image: {
                validators: {
                    notEmpty: {
                        message: 'The service Image is required'
                    },
                    file: {
                        extension: 'jpg,jpeg',
                        type: 'image/jpg,image/jpeg',
                        maxSize: 2048 * 1024,
                        message: 'The selected Vendor Image is not valid'
                    }
                }
            },
            conditions: {
                validators: {
                    notEmpty: {
                        message: 'The Service condition is required'
                    },
                    regexp: {
                        regexp: /^[a-zA-Z_ ]+$/,
                        message: 'The Service condition is not valid'
                    }
                }
            }
        }
    });

    if (url.indexOf('/services/update/') != -1) {
        var form = $("#serviceForm").attr("action");
        var str2 = "/services/update/";
        if(form.indexOf(str2) != -1){
            $('#serviceForm').bootstrapValidator('enableFieldValidators','image', false, 'notEmpty');
        }
    }

    if (url.indexOf('/inquiry/update/') != -1) {
        var form = $("#serviceForm").attr("action");
        var str2 = "/inquiry/update/";
        if(form.indexOf(str2) != -1){
            $('#serviceForm').bootstrapValidator('enableFieldValidators','conditions', false, 'notEmpty');
            $('#serviceForm').bootstrapValidator('enableFieldValidators','conditions', false, 'regexp');
            $('#serviceForm').bootstrapValidator('enableFieldValidators','image', false, 'notEmpty');
        }
    }

    $('#membershipForm').bootstrapValidator({
        excluded: [':disabled', ':hidden', ':not(:visible)'],
        feedbackIcons: {
            valid: 'fa fa-check valid',
            invalid: 'fa fa-close invalid',
            validating: 'fa fa-spinner',
        },
        fields: {
            plan: {
                validators: {
                    notEmpty: {
                        message: 'The plan name is required'
                    }
                }
            },
            price: {
                validators: {
                    notEmpty: {
                        message: 'The plan price is required'
                    },
                    regexp: {
                        regexp: /^[0-9.]+$/,
                        message: 'The plan price is not valid'
                    }
                }
            },
            details: {
                validators: {
                    notEmpty: {
                        message: 'The plan details is required'
                    }
                }
            },
            active: {
                validators: {
                    notEmpty: {
                        message: 'The plan activation is required'
                    }
                }
            },
            use_count: {
                validators: {
                    notEmpty: {
                        message: 'The use count is required'
                    }
                }
            },
            time_period: {
                validators: {
                    notEmpty: {
                        message: 'The time period is required'
                    }
                }
            },
            image: {
                validators: {
                    notEmpty: {
                        message: 'The Membership Image is required'
                    },
                    file: {
                        extension: 'jpg,jpeg',
                        type: 'image/jpg,image/jpeg',
                        maxSize: 2048 * 1024,
                        message: 'The selected Vendor Image is not valid'
                    }
                }
            }
        }
    });
    
    if (url.indexOf('/membership/update/') != -1 || url.indexOf('/vendorMembership/update/') != -1) {
        var form = $("#membershipForm").attr("action");
        var str2 = "/membership/update/";
        var str3 = "/vendorMembership/update/";
        if(form.indexOf(str2) != -1 || form.indexOf(str3) != -1){
            $('#membershipForm').bootstrapValidator('enableFieldValidators','image', false, 'notEmpty');
        }
    }

    $('#bannerForm').bootstrapValidator({
        excluded: [':disabled', ':hidden', ':not(:visible)'],
        feedbackIcons: {
            valid: 'fa fa-check valid',
            invalid: 'fa fa-close invalid',
            validating: 'fa fa-spinner',
        },
        fields: {
            image: {
                validators: {
                    notEmpty: {
                        message: 'The banner Image is required'
                    },
                    file: {
                        extension: 'jpg,jpeg',
                        type: 'image/jpg,image/jpeg',
                        maxSize: 2048 * 1024,
                        message: 'The selected banner Image is not valid'
                    }
                }
            }
        }
    });

    $('#promoForm').bootstrapValidator({
        excluded: [':disabled', ':hidden', ':not(:visible)'],
        feedbackIcons: {
            valid: 'fa fa-check valid',
            invalid: 'fa fa-close invalid',
            validating: 'fa fa-spinner',
        },
        fields: {
            code: {
                validators: {
                    notEmpty: {
                        message: 'The Promo Code is required'
                    }
                }
            },
            discount: {
                validators: {
                    notEmpty: {
                        message: 'The Promo Discount is required'
                    },
                    regexp: {
                        regexp: /^[0-9.]+$/,
                        message: 'The Promo Discount is not valid'
                    }
                }
            },
            details: {
                validators: {
                    notEmpty: {
                        message: 'The Promo details is required'
                    }
                }
            },
            active: {
                validators: {
                    notEmpty: {
                        message: 'The Promo activation is required'
                    }
                }
            }
        }
    });
});