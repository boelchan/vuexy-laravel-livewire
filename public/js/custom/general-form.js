var dropdownAjax =  function(targetObj, send_data, url) {
    targetObj.html("<option value='' >Loading...</option>");
    targetObj.select2("val", "");
    $.ajax({
        url: url,
        type: 'GET',
        dataType: 'json',
        data: send_data,
        beforeSend: function(e) {
            targetObj.prop("disabled", true);
        }
    }).done(function(response) {
        console.log("success");
        if (response) {
            if (response.length > 0) {
                targetObj.html("<option value='' >Pilih</option>");
                for (i = 0; i < response.length; i++) {
                    var option = "<option value='" + response[i]['id'] + "' ";
                    option += " >" + response[i]['nama'] + "</option>";
                    targetObj.append(option);
                }
                targetObj.prop("disabled", false);
            } else {
                targetObj.html("<option value='' >Tidak ada data</option>");
            }
            targetObj.select2("val", "");
        }
    }).fail(function(response) {
        console.log('error');
        // main.alertMessage('Oops!', response.message, 'warning');
    }).always(function() {
        // console.log("complete");
    });
}

var submitAjax = function(formObj,options={}) {
    var btnObj = formObj.find('button[type=submit]');

        if(formObj.attr('enctype')=="multipart/form-data"){
            var formData = new FormData(formObj[0]);
            options['cache'] = false;
            options['contentType'] = false;
            options['processData'] = false;
        }else{
            var formData = formObj.serialize();
        }
        // console.log(formData);

        $(".help-block-error" , formObj).remove();
        $(".form-group" , formObj).removeClass('has-error');
        // default settings
        options = $.extend(true, {
            url: formObj.attr('action'),
            dataType: "json",
            data: formData,
            type: formObj.attr('method'),

            beforeSend: function (e) {
                btnObj.button('loading');
            },
            error: function (e) {
                // console.log(e);
                if (e.status == 400){
                    form_set_errors(e.responseJSON.errors,formObj);
                    if (e.responseJSON.message) {
                        // toastr.error(e.responseJSON.message);
                        alert(e.responseJSON.message);
                    }
                }else{
                    Swal.fire({
                        title: 'Terjadi Kesalahan',
                        text: 'Silahkan ulangi kembali',
                        icon: 'error',
                        timer: 1000,                
                        showConfirmButton: false,
                    });
                }
            },
            success: function(response) {
                // console.log(response);
                if (response.success) {
                    if (options.f_response) {
                        toastr.success(response.message);
                        if (typeof options.f_response === "function") {
                            options.f_response(response);
                        }
                    }else{
                        form_success(response);
                    }
                } else {
                    toastr.error(response.message);
                }
            },
            complete:function (e) {
                btnObj.button('reset');
            }
        }, options);

        $.ajax(
            options
        );
}

function form_success(response) {
    if(response.message){
        var swal_message = response.message;
    }else{
        var swal_message = "Data berhasil disimpan";
    }
    Swal.fire({
        title: '',
        text: swal_message,
        icon: 'success',
        timer: 1000,                
        showConfirmButton: false,
    }).then(function() {
        if (response.redirect) {
            window.location.replace(response.redirect);
        }
    });
}

function form_set_errors(data_error,formObj) {
    // console.log(data_error);
    $.each(data_error, function(k, v) {
        var element = $("[name='"+k+"']" , formObj);
        // console.log(element);
        var error = $("<span/>")   // creates a div element
                            .addClass("error")   // add a class
                            .html(v);

        element.closest('.form-group').addClass('has-error');
        // element.closest('.help-block').remove();

        if (element.parent('.input-group').length) {
            error.insertAfter(element.parent());      // radio/checkbox?
        } else if (element.hasClass('select2-hidden-accessible')) {
            error.insertAfter(element.next('span'));  // select2
        } else {
            error.insertAfter(element);               // default
        }
    });
}

$('.form_ajax').submit(function(e) {
    e.preventDefault();
    submitAjax($(this));
});