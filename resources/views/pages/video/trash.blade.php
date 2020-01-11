@extends('layouts.app')

@section('widget-body')
<div class="widget-list">
	<div class="row">
		<div class="col-md-12 widget-holder widget-full-content border-all px-0">
			<div class="widget-bg">
				<div class="widget-body clearfix">

					<content-index>
						
						<div class="row no-gutters">
						    <!-- Mail Sidebar -->
						    <div class="col-md-3 mail-sidebar">
						        <div class="mail-inbox-header">
						            <div class="col-lg-6 col-md-12">
						                <form action="#" method="get" />
						                <select class="form-control" name="filterGame" data-placeholder="Select a game" data-toggle="select2" data-category="all">
						                    @foreach ($divisions as $division)
						                    <optgroup label="{{ ucfirst($division->name) }}">
						                        @foreach (explode(',', $division->game) as $game)
						                        <option value="{{ $division->name.'_'.$game }}">{{ $game }}</option>
						                        @endforeach
						                    </optgroup>
						                    @endforeach
						                </select>
						                <!-- /.form-group -->
						                </form>
						            </div>
						        </div>
						        <!-- /.mail-inbox-header -->
						        <div class="px-3">
						            <h5 class="pl-3 mt-4 mb-4">View by Category</h5>
						            <form action="" method="" />
						            <ul class="list-unstyled px-3" id="category_list">
						                <div class="categoryList_processing text-center p-5">
						                    No data available
						                </div>
						            </ul>
						            </form>
						        </div>
						        <!-- /.inbox-labels -->
						    </div>
						    <!-- /.mail-sidebar -->
						    <!-- Mails List -->
						    <div class="col-lg-9 col-md-9 mail-inbox">
						        <div class="mail-inbox-header">
						        	<div class="mail-inbox-tools d-flex align-items-center">
						        		<span class="checkbox checkbox-primary bw-3 heading-font-family fs-14 fw-semibold headings-color mail-inbox-select-all mr-r-20">
						        			<label>
						        				<input type="checkbox" />
						        				<span class="label-text">Select all</span>
						        			</label>
						        		</span>
						        		<div class="btn-group">
						        			<a id="reload" href="javascript:void(0)" class="btn btn-sm btn-link mr-2 text-muted">
						        				<i class="list-icon fs-18 feather feather-refresh-cw"></i>
						        			</a> 
						        			<a id="delete" data-delete-type="swal" data-type="delete" data-option="multiple" href="javascript:void(0)" class="btn btn-sm btn-link mr-2 text-muted">
						        				<i class="list-icon fs-18 feather feather-trash-2"></i>
						        			</a>
						        			<div class="dropdown">
						        				<a href="javascript:void(0)" data-toggle="dropdown" class="btn btn-sm fs-14 fw-semibold btn-link dropdown-toggle headings-color">
						        					<i class="feather feather-more-vertical text-muted fs-18 mr-2"></i> More
						        				</a>
						        				<div role="menu" class="dropdown-menu animated fadeIn">
						        					<a id="restore" class="dropdown-item" href="javascript:void(0)">Restore</a>
						        					<div class="dropdown-divider"></div>
						        					<a id="delete" data-empty-trash="true" data-delete-type="swal" data-type="delete" data-option="multiple" class="dropdown-item" href="javascript:void(0)">Empty Trash</a>
						        				</div>
						        			</div>
						        			<!-- /.dropdown -->
						        		</div>
						        		<!-- /.btn-group -->
						        	</div>
						        	<!-- /.mail-inbox-tools -->
						        </div>
						        <!-- /.mail-inbox-header -->
						        <div class="px-4">
						        	<table class="mail-list contact-list table-responsive" id="video-list">
						        		<tbody>
						        			<tr>
						        				<td>
						        					<h5 class="text-center p-5">
						        						No Data Available
						        					</h5>
						        				</td>
						        			</tr>
						        		</tbody>
						            </table>
						            <!-- /.contact-list -->
						        </div>
						        <!-- /.px-4 -->
						        <!-- Mails Navigation -->
						        <div class="row px-4 mt-5 mb-5">
						            <div class="col-7 text-muted mt-1"><span class="headings-font-family pagination-result"></span>
						            </div>
						            <div class="col-5">
						                <div class="btn-group float-right pagination-controls"></div>
						            </div>
						        </div>
						    </div>
						</div>

					</content-index>

				</div>
				<!-- /.widget-body -->
			</div>
			<!-- /.widget-bg -->
		</div>
		<!-- /.widget-holder -->
	</div>
	<!-- /.row -->
</div>
<!-- /.widget-list -->
@endsection

@push('scripts')

<script type="text/javascript">

	window.onload = function() {
		$('select[name="filterGame"]').change();
	}

	$('select[name="filterGame"]').on('change', function() {

		var $this = $(this);

		$.ajax({
			url : site_url+'/videos',
			type: 'get',
			data: { type: 'category', game: $this.val(), prefix: '_categories' },
			beforeSend: function() {
				$($this).attr('disabled', true);
				$('.categoryList_processing').remove();
			},
			success: function(response) {

				var html = '';

				if (response.length > 0) {

					html += '<li>' +
								'<div class="d-block checkbox checkbox-full-bg checkbox-lg checkbox-rounded checkbox-default bw-0">' +
									'<label class="d-block">' +
										'<input type="checkbox" class="select_all" /> <span class="label-text heading-font-family headings-color pd-l-50">All</span>' +
									'</label>' +
								'</div>' +
							'</li>';

					$.each(response, function(key, value) {
					html += '<li>' +
								'<div class="d-block checkbox checkbox-full-bg checkbox-lg checkbox-rounded checkbox-default bw-0">' +
									'<label class="d-block">' +
										'<input type="checkbox" name="category[]" value="'+value.id+'" /> <span class="label-text heading-font-family headings-color pd-l-50">'+value.name+'</span>' +
									'</label>' +
								'</div>' +
							'</li>';
					});
				} else {
					html += `<div class="categoryList_processing text-center p-5">
								No data available
							</div>`;
				}

				$('#category_list').html(html);

			},
			complete: function() {
				$category = $this.attr('data-category');
				if ($category == 'all') {
					$('.select_all').trigger('click');
				} else {
					$category = $this.attr('data-category').split(',');
					for (var i = 0; i < $category.length; i++) {
						$('input[name="category[]"][value='+$category[i]+']').trigger('click');
					}
				}
			}
		}).done(function() {
			$($this).attr('disabled', false);
		});

	});

	$(document).on('click', '.select_all', function() {
		$('input[name="category[]"]').prop('checked', this.checked);
		fetchVideos();
	});

	$(document).on('click', 'input[name="category[]"]', function() {
		//uncheck "select all", if one of the listed checkbox item is unchecked
		if($(this).prop('checked') == false) {
			$('.select_all').prop('checked', false);
		}
 		//check "select all" if all checkbox items are checked
		if ($('input[name="category[]"]:checked').length == $('input[name="category[]"]').length ){
			$('.select_all').prop('checked', true);
		}
		fetchVideos();
	});

	function fetchVideos(page = null) {

		$game = $('select[name="filterGame"]');

		$target = $('input[name="category[]"]:checked');
		$container = $('#video-list>tbody');

		var value = $target.map(function() {
			return $(this).val();
		}).get();

		if ($target.length) {

			$('[data-type="delete"]').attr({
				'data-url': site_url+'/videos/trash/',
				'data-params': 'game='+$game.val()+'&prefix=_videos'
			});

			var data = { type: 'videos', game: $game.val(), category: value, prefix: '_videos' };

			if (page) {
				data.page = page;
			}

			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				} 
			});

			$.ajax({
				url : site_url+'/videos/trash',
				type: 'get',
				data: data,
				beforeSend: function() {
					$('input[name="category[]"]').attr('disabled', false);
				},
				success: function(response) {

					var html = '';
					var result ='';
					var controls ='';

					if (response.data.length > 0) {
						$.each(response.data, function(k, v) {
							var thumbnails = $.parseJSON(v.thumbnails);
							var status = '<span class="badge bg-warning-contrast color-warning px-3">Testing</span>';
			        			html += '<tr>'+
					        				'<td class="contact-list-user">'+
					        					'<label class="mail-select-checkbox">'+
					        					'<input data-id="'+v.id+'" data- type="checkbox" />'+
					        						'<figure>'+
					        								'<img class="rounded" src="'+thumbnails.default+'" alt="" />'+
					        						'</figure>'+
					        					'</label>'+
					        				'</td>'+
					        				'<td class="contact-list-name">'+
					        					'<div class="lightbox-gallery" data-toggle="lightbox-gallery" data-type="image" data-effect="fadeInRight">'+
					        						'<div class="lightbox">'+
					        							'<a href="https://www.youtube.com/watch?v='+v.youtube_id+'" target="_blank" class="d-block fw-semibold" data-toggle="lightbox" data-type="iframe">'+v.title+'</a> <small>'+v.author+'</small>'+
					        							'</a>'+
					        						'</div>'+
					        					'</div>'+
					        				'</td>'+
					        				'<td class="contact-list-message"><span class="contact-list-phone d-block">'+v.slug+'</span> <small>'+moment(v.created_at).format('MMMM Do YYYY')+'</small>'+
					        				'</td>'+
					        			'</tr>';
						});

						result += 'Showing '+response.from+' - '+response.to+' of '+response.total+' result';
						controls += ' <a href="'+(response.prev_page_url || '#')+'" class="btn fs-18 bw-1 radius-0 btn-outline-default ripple px-2 prev '+(response.prev_page_url || 'disabled')+'">'+
										'<i class="list-icon material-icons">keyboard_arrow_left</i>'+
									  '</a>'+
									  '<a href="'+(response.next_page_url || '#')+'" class="btn fs-18 bw-1 radius-0 btn-outline-default ripple px-2 next '+(response.next_page_url || 'disabled')+'">'+
									  	'<i class="list-icon material-icons">keyboard_arrow_right</i>'+
									  '</a>';
					} else {
						html += `<tr>
			        				<td>
			        					<h5 class="text-center p-5">
			        						No Data Available
			        					</h5>
			        				</td>
			        			</tr>`;
					}

					$container.html(html);
					$('.pagination-result').text(result);
					$('.pagination-controls').html(controls);
				}
			}).done(function() {
				$('input[name="category[]"]').attr('disabled', false);
				MagnificPopup();
				empty_trash();
			});

		} else {
			$container.html(`<tr>
		        				<td>
		        					<h5 class="text-center p-5">
		        						No Category Selected
		        					</h5>
		        				</td>
		        			</tr>`);
			$('.pagination-result').text('');
			$('.pagination-controls').html('');
		}

	}

	$(document).on('click', '.pagination-controls a', function (e) {
		e.preventDefault();
		fetchVideos($(this).attr('href').split('page=')[1]);
	});
//http://localhost:8000/videos?game=sports_dewabet&category=1
	// get the string following the ?
	var query = window.location.search.substring(1)

	// is there anything there ?
	if(query.length) {

		var v = {};

		var p = query.split('&');
		for (var i = 0; i < p.length; i++) {
			var nv = p[i].split('=');
			if (!nv[0]) continue;
			v[nv[0]] = nv[1] || true;
		}

		$this = $('select[name="filterGame"]');
		$this.attr('data-category', v.category);
		$this.select2().val(v.game).trigger('change');
		

	   // are the new history methods available ?
	   if(window.history != undefined && window.history.pushState != undefined) {
	        // if pushstate exists, add a new state the the history, this changes the url without reloading the page

	        window.history.pushState({}, document.title, window.location.pathname);
	   }
	}

	//delete
	$(document).on('click', '#restore', function() {

		var id = [];
		var allCheckboxes = $('.mail-inbox').find('.mail-list .mail-select-checkbox input[type="checkbox"]');

		for( var i = 0; i < allCheckboxes.length; i++ ) {
			if ($(allCheckboxes[i]).is(':checked')) {
				id.push($(allCheckboxes[i]).data('id'));
			}
		}

		$game = $('select[name="filterGame"]');

		var data = { game: $game.val(), prefix: '_videos' };

		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			} 
		});

		if (id.length) {

			$.ajax({
				url : site_url+'/videos/trash/' + id.join(),
				type: 'put',
				data: data,
				success: function(response) {

					draw_data();

					swal({
						title: response.heading,
						text: response.text,
						type: 'success',
						confirmButtonClass: 'btn btn-success'
					});
				}
			});

		} else {
			swal(
				'Oops...',
				'Please select a video!',
				'error'
				);
		}

	});

	function empty_trash() {
		var allCheckboxes = $('.mail-inbox').find('.mail-list .mail-select-checkbox input[type="checkbox"]');
		if (!allCheckboxes.length) {
			$el = $('[data-empty-trash="true"]');
			$el.parent().find('.dropdown-divider').remove();
			$el.remove();
		}
	}

	function draw_data() {
		if ($('select[name="filterGame"]').val()) { $('select[name="filterGame"]').trigger('change'); }
	}

</script>

@endpush