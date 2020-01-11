//
function getSlug(str) {
  return str
    .toString()
    .trim()
    .toLowerCase()
    .replace(/\s+/g, "-")
    .replace(/[^\w\-]+/g, "")
    .replace(/\-\-+/g, "-")
    .replace(/^-+/, "")
    .replace(/-+$/, "");
}

// /Intl.NumberFormat
function numberFormat(number) {
	return new Intl.NumberFormat().format(number);
}


//add animation
function animate(e, x) {
	$(e).removeClass('d-none').addClass(x + ' animated').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function () {
		$(this).removeClass(x + ' animated');
	});
}

//switchery
function setSwitchery(element, checked) {
  if ( ( element.is(':checked') && checked == false ) || ( !element.is(':checked') && checked == true ) ) {
    element.parent().find('.switchery').trigger('click');
  }
}

$(function() {

	//select2
	$('select[data-toggle="select2"]').select2({
		matcher: function(params, data) {
			var original_matcher = $.fn.select2.defaults.defaults.matcher;
			var result = original_matcher(params, data);
			if (result && data.children && result.children && data.children.length != result.children.length) {
				result.children = data.children;
			}
			return result;
		}
	});

	// datatables custom filter data
	$('#dataTableBuilder').on('preXhr.dt', function ( e, settings, data ) {
		data.id = $('select[name="filterDivision"]').val();
	});

	$(document).on('change', 'select[name="filterDivision"]', function() {
		window.LaravelDataTables['dataTableBuilder'].draw();
	});

	$(document).on('change', 'input, select', function() {
		$(this).removeClass('is-invalid')
		$(this).siblings('.invalid-feedback').remove();
		$('[data-id="'+$(this).attr('id')+'"]').removeClass('is-invalid');
	});


	//create
	$('.create').on('click', function(e) {

		$(this).hide();

		show_form($(this));

	});


	//cancel
	$('.cancel').on('click', function(e) {

		$form = $('form#general-form');

		$form.each(function() {
			$(this).find('select:disabled').removeAttr('disabled');
			$(this)[0].reset();
			$(this).removeAttr('data-url data-type');
			$(this).find('[data-option="disabled"]').attr('disabled', true);
		});

		$('select[data-toggle="select2"]').select2();
		$('.selectpicker').val('default').selectpicker('refresh');

		clear_error();

		$('content-form').hide();
		$('.bs-modal-md').modal('hide');

		$('.create').show();
		$('content-index').show();

	});


	//edit
	$(document).on('click', '#edit', function() {

		$('.create').hide();

		$this = $(this);

		var params = $this.attr('data-params');

		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});

		$.ajax({
			url: $this.attr('data-url') + '/edit',
			type: 'get',
			data: params,
			beforeSend: function() {
				$($this).attr('disabled', true);
			},
			success: function(response) {
				$.each(response, function(key, value) {
					var $input = $('[name="'+key+'"]');
					switch (value.input_type) {
						case 'select2':
								$input.val(value.input_value).select2();
								if (value.input_disabled) { $input.attr('disabled', true); }
							break;
						case 'selectpicker':
								$input.val(value.input_value);
								$input.selectpicker('refresh');
							break;
						case 'checkbox':
								$input.val(value.input_value);
								if (value.input_value == 1){
									if ($input.is(':checked')) {
										$input.trigger('click');
									}
									setSwitchery($input, true);
								} else {
									setSwitchery($input, false);
								}
							break;
						case 'multiselect':
								getMultiSelect(response['game']['input_value'], $.parseJSON(value.input_value));
							break;
						case 'parent':
								$('#'+key).find('a').attr('href', value.link);
								$('#'+key).find('img').attr('src', value.thumbnail);
							break;
						case 'object':
								var data = {};
								$.each(value.input_value, function(k, v) {
									$('#'+k).html(numberFormat(v));
									data[k] = v;
								});
								$input.val(JSON.stringify(data));
							break;
						default:
								$input.val(value.input_value);
							break;
					}
					if (value.input_fadeIn) { animate(value.input_fadeIn, 'fadeIn'); }
				});
			},
			complete: function() {
				show_form($this);
			},
		}).done(function() {
			$($this).attr('disabled', false);
		});

	});

	//reload
	$(document).on('click', '#reload', function() {
		draw_data();
	});

	//delete
	$(document).on('click', '#delete', function() {

		$form = $('.bs-modal-md').find('#general-form');

		var id = [];
		var allCheckboxes = $('.mail-inbox').find('.mail-list .mail-select-checkbox input[type="checkbox"]');

		if ($(this).data('option') == 'multiple') {
			for( var i = 0; i < allCheckboxes.length; i++ ) {
				if ($(allCheckboxes[i]).is(':checked')) {
					id.push($(allCheckboxes[i]).data('id'));
				}
			}
		}

		if ($(this).data('empty-trash') == true) {
			id.push('all');
		}

		$form.attr({
			'data-url': $(this).data('url') + id.join(),
			'data-type': $(this).data('type'),
			'data-callback': $(this).data('callback'),
			'data-delete-type': $(this).data('delete-type'),
			'data-params': $(this).data('params')
		});

		var text = 'You won\'t be able to revert this!';
		var confirmButtonText = 'Yes, delete it!';

		if ((url(1) == 'videos') && (url(2) == null)) {
			text = 'You want to move the video in Trash.';
			confirmButtonText = 'Yes, move it!';
		}

		if (id.length || $(this).data('option') != 'multiple') {
			switch ($(this).data('delete-type')) {
			    case 'swal':
						swal({
							title: 'Are you sure?',
							text: text,
							type: 'warning',
							showCancelButton: true,
							confirmButtonClass: 'btn btn-warning',
							confirmButtonText: confirmButtonText,
							showLoaderOnConfirm: true,
							allowEnterKey: false,
						}).then((result) => {
							if (result.value) {
								$form.submit();
							}
						});
			        break;

			    default:
					    $('.bs-modal-md').modal({
					    	backdrop: 'static',
					    	keyboard: false
					    });
			        break;
			}
		} else {
			swal(
				'Oops...',
				'Please select a video!',
				'error'
				);
		}

	});


	//submit
	$(document).on('submit', '#general-form', function(e) {

		e.preventDefault();

		$form = $(this);

		var url = $form.attr('data-url');
		var type = $form.attr('data-type');
		var callback = $form.attr('data-callback');
		var deleteType = $form.attr('data-delete-type');
		var params = $form.attr('data-params');
		var formData = new FormData($(this)[0]);

		switch (type) {
		    case 'put':
		    case 'patch':
		    case 'delete':
		    		formData.append('_method', type);
			    	type = 'post';
		        break;
		}

		if (params) {
			params = params.split('&');
			for (var i = 0; i < params.length; i++) {
				var pair = params[i].split('=');
				formData.append(pair[0], pair[1]);
			}
		}

		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});

		$.ajax({
			url : url,
			type: type,
			data: formData,
			contentType: false,
			processData: false,
			beforeSend: function() {
				$('button[type="submit"]').attr('disabled', false);
			},
			success: function(response) {

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

					switch (callback) {
					    case 'dataTable':
					    		window.LaravelDataTables['dataTableBuilder'].draw();
					    	break;

					    default:
				    		draw_data();

					}

					switch (deleteType) {
						case 'swal':
								swal({
									title: response.heading,
									text: response.text,
									type: 'success',
									confirmButtonClass: 'btn btn-success'
								});
							break;

						default:
							$.toast({
								heading: response.heading,
								text: response.text,
								position: 'top-right',
								icon: response.icon,
								stack: false
							});
					}

				}
			}
		})
		.done(function() {
			$('button[type="submit"]').attr('disabled', false);
		})
		.fail(function(jqXHR, textStatus, errorThrown) {
			$.toast({
				heading: errorThrown,
				text: textStatus.toUpperCase(),
				position: 'top-right',
				icon: 'error',
				stack: false
			});
		});

	});

	function show_form($this) {

		$('content-index').hide();

		$('content-form').show();

		$form = $('#general-form');

		$form.attr({
			'data-url': $this.data('url'),
			'data-type': $this.data('type'),
			'data-callback': $this.data('callback'),
			'data-params': $this.data('params')
		});

	}

	function clear_error() {

		$('input, select, button').removeClass('is-invalid')
		$('input, select').siblings('.invalid-feedback').remove();
	}

});

function goBack() {
    window.history.back();
}
