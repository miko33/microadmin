
function clear_error() {
    $('input, select, button').removeClass('is-invalid')
    $('input, select').siblings('.invalid-feedback').remove();
}
$('body').on('click', 'button#livechat_customize', function () {
    window.location.href = $(this).attr('data-url');
});

$('#livechat_submit').click(function () {
    var settings = {
		"url": "/livechats/store",
		"method": "POST",
		"headers": {
		"Accept": "application/json",
		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        },
        "data": {
            'game_id': $('#gameID').val(),
            'hostname': $('#inputHostname').val(),
            'title': $('#inputTitle').val(),
            'keyword': $('#inputKeyword').val(),
            'description': $('#inputDescription').val(),
            'custom_tag': $('#inputCustomTag').val(),
        }
	}

	$.ajax(settings).done(function (response) {
        clear_error();
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