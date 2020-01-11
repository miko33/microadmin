
function clear_error() {
    $('input, select, button').removeClass('is-invalid')
    $('input, select').siblings('.invalid-feedback').remove();
}
$('body').on('click', 'button#microsite_customize', function () {
    window.location.href = $(this).attr('data-url');
});
$('#microsite_submit').click(function () {
  if ($("#togBtn").is(':checked')) {
    var valcheck = 'true';
      $("this").attr('value', 'true');
  }
  else {
    var valcheck = 'false';
      $("this").attr('value', 'false');
  }
    var settings = {
		"url": "/microsites/store",
		"method": "POST",
		"headers": {
		"Accept": "application/json",
		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        },
        "data": {
            'game_id': $('#gameID').val(),
            'template': $('select#selectTemplate').val(),
            'hostname': $('#inputHostname').val(),
            'title': $('#inputTitle').val(),
            'keyword': $('#inputKeyword').val(),
            'description': $('#inputDescription').val(),
            'custom_tag': $('#inputCustomTag').val(),
            'blogs': valcheck,
        }
	}

	$.ajax(settings).done(function (response) {
        clear_error();
        if (response.errors) {
            $.each(response.errors, function(k, v) {

                $input = $form.find('[name="' + k + '"]');
                console.log(k,$input,$form);

                if ($input.data('style') != null) {
                    $('[data-id="'+$input.attr('id')+'"]').addClass('is-invalid');
                }

                $input.addClass('is-invalid');
                $input.parent().append('<span class="invalid-feedback">' + v + '</span>');

            });
        } else {
            $('.cancel').trigger('click');
            window.LaravelDataTables['dataTableBuilder'].draw();
            $.toast({
                heading: response.heading,
                text: response.text,
                position: 'top-right',
                icon: response.icon,
                stack: false
            });
        }
    })
    .fail(function (jqXHR, textStatus, errorThrown) {
        $.toast({
            heading: errorThrown,
            text: textStatus.toUpperCase(),
            position: 'top-right',
            icon: 'error',
            stack: false
        });
    });
});
