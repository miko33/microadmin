tinymce.init({
    selector: '#pageContent',
    height: 700,
    paste_data_images: true,
    content_css: 'https://use.fontawesome.com/releases/v5.1.0/css/all.css',
    noneditable_noneditable_class: 'fa',
    plugins: [
      'fullpage advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker',
      'searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking',
      'save table contextmenu directionality emoticons template paste textcolor fontawesome noneditable'
    ],
    external_plugins: {
        'fontawesome': '/assets/vendors/tinymceplugins/fontawesome/plugin.min.js',
        'image': '/assets/vendors/tinymceplugins/images/plugin.js'
    },
    image_list: image_list,
    code_dialog_width: 1000,
    code_dialog_height: 700,
    image_advtab: true,
    toolbar: 'fontawesome | bold italic underline strikethrough forecolor backcolor | alignleft aligncenter alignright alignjustify | styleselect | formatselect | fontselect | fontsizeselect | link image media table | bullist numlist | blockquote  subscript superscript |  outdent indent | undo redo | cut copy paste | removeformat',
    valid_elements: '*[*]',
    file_picker_callback: function(callback, value, meta) {
      if (meta.filetype == 'image') {
        var input = document.createElement('input');
        input.setAttribute('type', 'file');
        input.setAttribute('accept', 'image/*');
        input.onchange = function() {
            var file = this.files[0];
            var reader = new FileReader();
            reader.onload = function(e) {
                console.log(e);
                var settings = {
                    "url": uploadImageRoute,
                    "method": "POST",
                    "headers": {
                    "Accept": "application/json",
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    },
                    "data": {
                        'image': e.target.result,
                        'hostname': hostname
                    }
                }

                $.ajax(settings).done(function (response) {
                    callback(response.location, {
                        alt: ''
                    });
                });
            };
            reader.readAsDataURL(file);
        };
        input.click();
      }
    }
});

$('#save_page').click(function () {
    $(this).attr('disabled', 'disabled');
    submitImage('favicon', function() {
        submitImage('home_header_logo', function() {
            submitSave();
        });
    });
});

function submitSave() {
    var settings = {
        "url": updateHomeContentRoute,
        "method": "POST",
        "headers": {
            "Accept": "application/json",
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        },
        "data": {
            'api_link': $('#apiUrl').val(),
            'title': $('#title').val(),
            'footer_text': $('#footerDescription').val(),
            'livechat_url': $('#liveChatUrl').val(),
            'header_color': $('#colorPicker1').val(),
            'font_color': $('#colorPicker2').val(),
            'playnow_color': $('#colorPicker3').val(),
            'register_color': $('#colorPicker4').val(),
            'content': tinymce.get('pageContent').getContent(),
            'favicon_url': $('#favicon_url').val(),
            'home_header_logo_url': $('#home_header_logo_url').val(),
        }
    }

    $.ajax(settings).done(function (response) {
        $.toast({
            heading: response.heading,
            text: response.text,
            position: 'top-right',
            icon: response.icon,
            stack: false
        });
        let id_images = ['favicon', 'home_header_logo'];
        
        for (let index = 0; index < id_images.length; index++) {
            const element = id_images[index];
            $(`#${element}_image`).attr('src', $(`#${element}_url`).val());
            if($(`#${element}_url`).val().length > 0) {
                $(`#${element}_image`).show();
            } else {
                $(`#${element}_image`).hide();
            }
            $(`#${element}`).val('');
        }
        $('#save_page').removeAttr('disabled');
    });
}

function submitImage(id, callback = null) {
    if($(`#${id}`).length > 0) {
        const reader = new FileReader(), file = $(`#${id}`)[0].files[0];
        if(file) {
            reader.readAsDataURL(file);
            reader.onload = function () {
                $.ajax({
                    type: "POST",
                    "headers": {
                        "Accept": "application/json",
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    },
                    url: uploadImageRoute,
                    data: {
                        image: reader.result,
                        hostname: hostname
                    },
                    dataType: "json",
                    success: function (response) {
                        $(`#${id}_url`).val(response.location);
                        if(typeof callback == "function") {
                            callback();
                        }
                    }
                });          
            };
            reader.onerror = function (error) {
              console.log('Error: ', error);
            };
        } else {
            if(typeof callback == "function") {
                callback();
            }
        }
    } else {
        if(typeof callback == "function") {
            callback();
        }
    }
}