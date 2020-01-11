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
    image_list: imagelist,
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
    const template_id = $("#site_template").val();
    switch(template_id) {
        case '1':
            submitImage('home_header_logo', function() {
                submitImage('favicon', function() {
                    submitSave();
                });
            });
        break;
        case '2':
            submitImage('home_image', function() {
                submitImage('home_header_logo', function() {
                    submitImage('home_logo', function() {
                        submitImage('favicon', function() {
                            submitSave();
                        });
                    });
                });
            });
        break;
        case '3':
            submitImage('home_header_logo', function() {
                submitImage('favicon', function() {
                    submitSave();
                });
            });
        break;
        case '4':
            submitImage('home_header_logo', function() {
                submitImage('home_logo', function() {
                    submitImage('favicon', function() {
                        submitSave();
                    });
                });
            });
        break;
        case '5':
            submitImage('home_header_logo', function(){
              submitImage('home_logo', function() {
              submitImage('favicon', function() {
                submitSave();
              });
            });
          });
          break;
          case '6':
              submitImage('home_header_logo', function() {
                  submitImage('favicon', function() {
                      submitSave();
                  });
              });
          break;
        default:
            alert('invalid template id');
        break;
    }
});

function submitSave() {
    const template_id = $("#site_template").val();
    var settings = {
        "url": updateHomeContentRoute,
        "method": "POST",
        "headers": {
            "Accept": "application/json",
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        },
        "data": {
            'content_title': $('#contentTitle').val(),
            'content_subtitle': $('#contentSubtitle').val(),
            'content': tinymce.get('pageContent').getContent(),
            'home_header_logo': $('#home_header_logo_url').val(),
            'colorscheme': $('#colorscheme').val(),
            'display_play_reg_btn': $("#display_play_reg_btn").is(':checked') ? '1' : '0',
            'favicon': $('#favicon_url').val()
        }
    }

    if(template_id == 2) {
        settings.data = {
            'content_title': $('#contentTitle').val(),
            'content_subtitle': $('#contentSubtitle').val(),
            'content': tinymce.get('pageContent').getContent(),
            'home_image': $('#home_image_url').val(),
            'home_header_logo': $('#home_header_logo_url').val(),
            'favicon': $('#favicon_url').val(),
            'colorscheme': $('#colorscheme').val(),
            'footer_text': $('#footerText').val(),
            'home_logo': $('#home_logo_url').val(),
        }
    }

    if(template_id == 3) {
        settings.data = {
            'content_title': $('#contentTitle').val(),
            'content_title2': $('#contentTitle2').val(),
            'content': tinymce.get('pageContent').getContent(),
            'home_header_logo': $('#home_header_logo_url').val(),
            'favicon': $('#favicon_url').val(),
            'colorscheme': $('#colorscheme').val(),
            'video_url': $('#videoTutorial').val(),
            'description': $('#pageDescription').val(),
        }
    }

    if(template_id == 4) {
        settings.data = {
            'content_title': $('#contentTitle').val(),
            'content': tinymce.get('pageContent').getContent(),
            'favicon': $('#favicon_url').val(),
            'home_header_logo': $('#home_header_logo_url').val(),
            'home_logo': $('#home_logo_url').val(),
            'content_title_bottom': $('#contentTitleBottom').val(),
            'content_bottom': $('#pageDescriptionBottom').val(),
        }
    }

    if (template_id == 5) {
      settings.data = {
            'content_title': $('#contentTitle').val(),
            'content': tinymce.get('pageContent').getContent(),
            'home_header_logo': $('#home_header_logo_url').val(),
            'home_logo': $('#home_logo_url').val(),
            'content_footer': $('#contentFooter').val(),
            'colorscheme': $('#colorscheme').val(),
            'display_play_reg_btn': $("#display_play_reg_btn").is(':checked') ? '1' : '0',
            'favicon': $('#favicon_url').val(),
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
        let id_images = [];
        switch(template_id) {
            case '1':
                id_images = ['favicon', 'home_header_logo'];
            break;
            case '2':
                id_images = ['favicon', 'home_image', 'home_header_logo', 'home_logo'];
            break;
            case '3':
                id_images = ['favicon', 'home_header_logo'];
            break;
            case '4':
                id_images = ['favicon', 'home_header_logo', 'home_logo'];
            break;
            case '5':
                id_images = ['favicon', 'home_header_logo', 'home_logo'];
            break;
        }

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
