tinymce.init({
    selector: '#pageContent',
    height: 700,
    paste_data_images: true,
    content_css: 'https://use.fontawesome.com/releases/v5.1.0/css/all.css',
    noneditable_noneditable_class: 'fa',
    plugins: [
      'fullpage advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker',
      'searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime nonbreaking',
      'save table contextmenu directionality emoticons paste textcolor fontawesome noneditable'
    ],
    external_plugins: {
        'fontawesome': '/assets/vendors/tinymceplugins/fontawesome/plugin.min.js',
        'image': '/assets/vendors/tinymceplugins/images/plugin.js'
    },
    image_list: image_list,
    code_dialog_width: 1000,
    code_dialog_height: 700,
    image_advtab: true,
    toolbar: 'fontawesome | bold italic underline strikethrough forecolor backcolor | alignleft aligncenter alignright alignjustify | styleselect | formatselect | fontselect | fontsizeselect | link image table | bullist numlist | blockquote  subscript superscript |  outdent indent | undo redo | cut copy paste | removeformat',
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
    var slug = "";
    if ($(this).attr('data-type') == 'update') {
       url = updatePage;
       slug = $(this).attr('data-slug');
    } else {
       url = storePage;
    }
    var settings = {
        "url": url,
        "method": "POST",
        "headers": {
        "Accept": "application/json",
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        },
        "data": {
            'title': $('#pageTitle').val(),
            'newslug': $('#pageSlug').val(),
            'meta_keywords': $('#pageMetaKeywords').val(),
            'meta_description': $('#pageMetaDescription').val(),
            'head': $('#pageHead').val(),
            'content': tinymce.get('pageContent').getContent(),
            'site_id': $('#site_id').val(),
            'slug': slug
        }
    }

    $.ajax(settings).done(function (response) {

        var $form = $("#formPage");

		$('input, select, button').removeClass('is-invalid')
        $('input, select').siblings('.invalid-feedback').remove();
        $('#save_page').removeAttr('disabled');
        
        if (response.errors) {
            $.each(response.errors, function(k, v) {

                $input = $form.find('[name="' + k + '"]');

                if ($input.data('style') != null) {
                    $('[data-id="'+$input.attr('id')+'"]').addClass('is-invalid');
                }

                $input.addClass('is-invalid');
                $input.parent().append('<span class="invalid-feedback">' + v + '</span>');

            });
        } else {
            if(slug != "" && slug !=  $('#pageSlug').val()) {
                window.location = redirectTo;
            }
            $('#save_page').attr('data-type', 'update');
            $('#save_page').attr('data-slug', response.page.slug);
            $.toast({
                heading: response.heading,
                text: response.text,
                position: 'top-right',
                icon: response.icon,
                stack: false
            });
        }
    });
});