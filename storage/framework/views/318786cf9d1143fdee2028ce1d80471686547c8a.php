<?php $__env->startSection('widget-body'); ?>
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
						                    <?php $__currentLoopData = $divisions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $division): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						                    <optgroup label="<?php echo e(ucfirst($division->name)); ?>">
						                        <?php $__currentLoopData = explode(',', $division->game); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $game): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						                        <option value="<?php echo e($division->name.'_'.$game); ?>"><?php echo e($game); ?></option>
						                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						                    </optgroup>
						                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
								<div class="px-3">
						            <a href="<?php echo e(url("categories?create=true")); ?>" id="toCreateCategory">Add new category</a>
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
						        			<?php if(App\General::page_access(Auth::user()->group_id, 'video', 'drop')): ?>
						        			<a id="delete" data-delete-type="swal" data-type="delete" data-option="multiple" href="javascript:void(0)" class="btn btn-sm btn-link mr-2 text-muted">
						        				<i class="list-icon fs-18 feather feather-trash-2"></i>
						        			</a>
						        			<?php endif; ?>
						        			<div class="dropdown">
						        				<a href="javascript:void(0)" data-toggle="dropdown" class="btn btn-sm fs-14 fw-semibold btn-link dropdown-toggle headings-color">
						        					<i class="feather feather-more-vertical text-muted fs-18 mr-2"></i> More
						        				</a>
						        				<div role="menu" class="dropdown-menu animated fadeIn">
						        					<a id="show_all" class="dropdown-item" href="javascript:void(0)">Show All</a>
						        					<?php if(App\General::page_access(Auth::user()->group_id, 'trash', 'view')): ?>
						        					<div class="dropdown-divider"></div>
						        					<a class="dropdown-item" href="<?php echo e(url('/videos/trash')); ?>">Trash</a>
						        					<?php endif; ?>
						        				</div>
						        			</div>
						        			<!-- /.dropdown -->
										</div>
										<!-- /.btn-group -->
										
										<div class="row no-gutters">
											<div class="col-9">
											<input type="text" id="searchInput" name="searchInput" class="form-control" placeholder="Search...">
											</div>
											<div class="col-3">
											<button type="button" class="btn btn-md btn-primary" id="search" name="search" style="padding: 0.46rem 0.5em;">Search</button>
											</div>
										</div>
						        	</div>
						        	<!-- /.mail-inbox-tools -->
						            <div class="flex-1"></div>
						            <?php if(App\General::page_access(Auth::user()->group_id, 'video', 'create')): ?>
						            <div class="d-none d-sm-block text-right">
						            	<a class="create btn btn-color-scheme btn-xl px-4 h6 my-0 fs-16 fw-500" href="javascript:void(0);" data-type="post" data-url="<?php echo e(url('videos')); ?>" data-params="prefix=_videos">Add Video</a>
						            </div>
						            <?php endif; ?>

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

					<content-form style="display: none;">

						<div class="p-4">
							<form id="general-form" method="" action="">
								<div class="row">
									<div class="col-lg-4 px-3">
										<div class="row">
											<div class="col-lg-6">
												<div class="form-group">
													<label for="inputGame">Game</label>
													<select class="form-control" id="inputGame" name="game" data-placeholder="Select a game" data-toggle="select2">
														<option></option>
														<?php $__currentLoopData = $divisions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $division): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
														<optgroup label="<?php echo e(ucfirst($division->name)); ?>">
															<?php $__currentLoopData = explode(',', $division->game); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $game): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
															<option value="<?php echo e($division->name.'_'.$game); ?>"><?php echo e($game); ?></option>
															<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
														</optgroup>
														<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
													</select>
												</div>
											</div>
											<div class="col-lg-6">
												<div class="form-group">
													<label for="inputStatus" class="d-block mb-3">Status</label>
													<input name="status" type="checkbox" checked="checked" class="js-switch" data-color="#38d57a" data-size="small" />
												</div>
											</div>
										</div>
										<div class="col-lg-12">
											<div class="row">
												<div class="col-lg-6">
													<div class="form-group">
														<label for="inputId">Youtube ID</label>
														<input type="text" id="inputId" name="youtube_id" class="form-control">
													</div>
												</div>
												<div class="col-lg-6">
													<div class="form-group">
														<label for="inputUrl">
															<span class="checkbox">
																<label class="">
																	<input type="checkbox" name="checkboxUrl">
																	<span class="label-text">
																		Youtube URL
																		<i class="text-info fs-16 fw-700 feather feather-alert-circle"  data-toggle="tooltip" data-placement="top" title="Retrieve data from url"></i>
																	</span>
																</label>
															</span>
														</label>
														<input type="text" id="inputUrl" name="youtube_url" data-option="disabled" class="form-control" disabled>
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-lg-6">
													<div class="form-group">
														<label for="inputTitle">Title</label>
														<input type="text" id="inputTitle" name="title" class="form-control">
													</div>
												</div>
												<div class="col-lg-6">
													<div class="form-group">
														<label for="inputSlug">Slug</label>
														<input type="text" id="inputSlug" name="slug" class="form-control">
													</div>
												</div>										
											</div>
											<div class="col-lg-12">
												<div class="form-group">
													<label for="inputDescription">Description</label>
													<textarea class="form-control" id="inputDescription" name="description" rows="3"></textarea>
												</div>
											</div>
										</div>
									</div>
									<div class="col-lg-4 px-3 d-none" id="categoryContainer"></div>
									<div class="col-lg-4 px-3 d-none" id="videoContainer">
										<div class="row lightbox-gallery" data-toggle="lightbox-gallery" data-type="image" data-effect="fadeInRight">
											<div id="lightbox-popup-video" class="col-md-12 mr-b-20 lightbox">
												<h5 class="box-title">Video</h5>
												<a href="https://www.youtube.com/watch?v=mxxIloURtoU" class="mfp-iframe custom-thumbnail" data-toggle="lightbox" data-type="iframe">
													<img src="./assets/demo/carousel/carousel-6.jpg" alt="Thumb 1">
												</a>
												<input type="file" name="custom_thumbnail" class="d-none">
												<input type="text" name="thumbnails" class="d-none">
											</div>
										</div>
										<div class="row">
											<div class="col-lg-3 col-md-3 sub-heading-font-family text-center p-3">
												<i class="feather feather-eye"></i> <span id="viewCount">2,350</span>
											</div>
											<div class="col-lg-3 col-md-3 sub-heading-font-family text-center p-3">
												<i class="feather feather-thumbs-up"></i> <span id="likeCount">2,350</span>
											</div>
											<div class="col-lg-3 col-md-3 sub-heading-font-family text-center p-3">
												<i class="feather feather-thumbs-down"></i> <span id="dislikeCount">2,350</span>
											</div>
											<div class="col-lg-3 col-md-3 sub-heading-font-family text-center p-3">
												<i class="feather feather-message-circle"></i> <span id="commentCount">2,350</span>
											</div>
											<input type="text" name="statistics" class="d-none">
										</div>
										<input type="text" name="duration" class="d-none">
										<input type="text" name="publishedAt" class="d-none">
									</div>
								</div>
								<div class="form-actions btn-list px-3 clearfix">
									<button class="btn btn-success" type="submit">Submit</button>
									<button class="cancel btn btn-outline-default" type="button">Cancel</button>
								</div>								
							</form>
						</div>

					</content-form>

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
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>

<script type="text/javascript">

	window.onload = function() {
		$('select[name="filterGame"]').change();
	}

	$('select[name="filterGame"]').on('change', function() {

		var $this = $(this);
		var CreCatURL = $("#toCreateCategory").attr("href").split("=");
		var newCreCatURL = CreCatURL[0]+"="+$this.val();
		$("#toCreateCategory").attr("href", newCreCatURL);
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
		var searchQuery = $('#searchInput').val();
		fetchVideos(null, searchQuery);
	});

	$(document).on('click', 'input[name="category[]"]', function() {
		searchQuery = $('#searchInput').val();
		//uncheck "select all", if one of the listed checkbox item is unchecked
		if($(this).prop('checked') == false) {
			$('.select_all').prop('checked', false);
		}
 		//check "select all" if all checkbox items are checked
		if ($('input[name="category[]"]:checked').length == $('input[name="category[]"]').length ){
			$('.select_all').prop('checked', true);
		}
		fetchVideos(null, searchQuery);
	});

	$(document).on('click', '#show_all', function() {
		fetchVideos('all');
	});

	$(document).on('click', '#search', function() {
		var searchQuery = $('#searchInput').val();
		fetchVideos(null, searchQuery);
	});
	$(document).on('keyup', '#searchInput', function(e) {
		if (e.which == 13) {
			var searchQuery = $(this).val();
			fetchVideos(null, searchQuery);
		} else if (e.which == 27) {
			$(this).val("");
			fetchVideos();
		}
		
	});

	function fetchVideos(page = null, searchQuery = "") {

		$game = $('select[name="filterGame"]');

		$target = $('input[name="category[]"]:checked');
		$container = $('#video-list>tbody');

		var value = $target.map(function() {
			return $(this).val();
		}).get();

		if ($target.length) {

			$('#delete').attr({
				'data-url': site_url+'/videos/',
				'data-params': 'game='+$game.val()+'&prefix=_videos'
			});

			var data = { type: 'videos', game: $game.val(), category: value, prefix: '_videos' };

			if (page) {
				data.page = page;
			}

			if (searchQuery != "") {
				data.searchQuery = searchQuery;
			}

			$.ajax({
				url : site_url+'/videos',
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

							var status = '<span class="badge bg-success-contrast color-success px-3">Active</span>';
								switch (v.status) {
								    case 0:
								    		status = '<span class="badge bg-warning-contrast color-warning px-3">Disabled</span>';
								        break;
								}
							
			        			html += '<tr>'+
					        				'<td class="contact-list-user">'+
					        					'<label class="mail-select-checkbox">'+
					        					'<input data-id="'+v.id+'" data- type="checkbox" />'+
					        						'<figure>'+
					        								'<img class="rounded" src="'+(thumbnails.custom ? ('/storage/thumbnails/'+$game.val().replace('_', '/')+'/'+v.slug+'/'+thumbnails.custom) : thumbnails.default)+'" alt="" />'+
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
					        				'<td class="contact-list-badge">'+status+
					        				'</td>'+
					        				'<td class="contact-list-action">'+
					        				'<div class="btn-group">';

					        				if (response.alter) {
					        					html += '<button id="edit" data-type="put" data-url="'+site_url+'/videos/'+v.id+'" data-params="game='+$game.val()+'&prefix=_videos" type="button" class="btn btn-default"><i class="feather feather-edit-2"></i></button>';
					        				}

					        				if (response.drop) {
					        					html += '<button id="delete" data-delete-type="swal" data-type="delete" data-url="'+site_url+'/videos/'+v.id+'" data-params="game='+$game.val()+'&prefix=_videos" type="button" class="btn btn-default"><i class="feather feather-trash-2"></i></button>';
					        				}
					        				
					        		html +=	'</div>'+
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
		searchQuery = $('#searchInput').val();
		fetchVideos($(this).attr('href').split('page=')[1], searchQuery);
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

	//create

	$('input[name="checkboxUrl"]').on('click', function() {
		var prop = this.checked ? false : true;
		$('#inputUrl').prop('disabled', prop);
	});

    $.contextMenu({
        selector: '.mfp-iframe.custom-thumbnail', 
        callback: function(itemKey, opt, rootMenu, originalEvent) {
            var m = "global: " + key;
            window.console && console.log(m) || alert(m); 
        },
        items: {
            "edit": {
                name: "Change Thumbnail", 
                icon: "upload", 
                // superseeds "global" callback
                callback: function(itemKey, opt, rootMenu, originalEvent) {
                	$('[name="custom_thumbnail"]').trigger('click');
                }
            },
            "sep1": " ",
            "cancel": {
            	name: "Cancel",
            	icon: function($element, key, item) { return 'context-menu-icon context-menu-icon-quit'; },
            	callback: $.noop
            }
        }
    });


    $(document).on('change', '[name="custom_thumbnail"]', function() {
    	if (typeof (FileReader)) {

    		$target = $('.custom-thumbnail > img');

    		var reader = new FileReader();
    		reader.onload = function (e) {
    			$target.prop('src', e.target.result);
    		}

    		if ($(this)[0].files[0]) {
    			reader.readAsDataURL($(this)[0].files[0]);
    		} else {
    			var thumbnails = JSON.parse($('input[name="thumbnails"]').val());
    			$target.prop('src', thumbnails.maxres);
    		}
    		
    	} else {
    		console.log('This browser does not support FileReader.');
    	}
    });

	$('#inputGame').on('change', function() {

		var fadeIn = 'animated fadeIn';

		getMultiSelect($(this).val());

	});

	function getMultiSelect(game, res = []) {

		$.ajax({
			url : site_url+'/videos',
			type: 'get',
			data: { type: 'category', game: game, prefix: '_categories' },
			beforeSend: function() {
				$('#inputGame').attr('disabled', false);
				$('#categoryContainer').html('');
			},
			success: function(response) {

				var html = `<h5 class="box-title">Category</h5>
							<div class="form-group">
								<select class="form-control" multiple="multiple" id="public-methods" data-toggle="multiselect" name="category[]">`;
								if (response.length > 0) {
									$.each(response, function(key, value) {
										if ($.inArray(value.id.toString(), res) > -1) {
											html += '<option value="'+value.id+'" selected>'+value.name+'</option>';
										} else {
											html += '<option value="'+value.id+'">'+value.name+'</option>';
										}
									});
								} else {
									html += `<option disabled>No data available</option>`;
								}
						html += `</select>
								</div>
                            <div class="button-box mr-t-20">
                            	<a id="select-all" data-multiselect-target="#public-methods" data-multiselect-method="select_all" data-event="click" class="btn btn-outline-danger btn-sm mr-r-10 mr-b-10" href="#">Select all</a>
                            	<a id="deselect-all" data-multiselect-target="#public-methods" data-multiselect-method="deselect_all" data-event="click" class="btn btn-outline-info btn-sm mr-r-10 mr-b-10" href="#">Deselect all</a>
                            </div>`

				$('#categoryContainer').html(html);
				

			},
		}).done(function() {
			animate('#categoryContainer', 'fadeIn');
			$('#inputGame').attr('disabled', false);
			MultiSelect();
			$('div.ms-selectable').prepend('Selectable categories');
			$('div.ms-selection').prepend('Selected categories');
		});

	}

	$('input[name="youtube_id"]').on('input', function() {

		$this = $(this);

		if ($this.val().length == 11) {
			
			fetchDetails({
				youtube_id: $this.val()
			});
		}

	});

	$('input[name="youtube_url"]').on('input', function() {

		var p = /^(?:https?:\/\/)?(?:m\.|www\.)?(?:youtu\.be\/|youtube\.com\/(?:embed\/|v\/|watch\?v=|watch\?.+&v=))((\w|-){11})(?:\S+)?$/;

		$this = $(this);

		if ($this.val().match(p)) {
			
			fetchDetails({
				youtube_url: $this.val()
			});

		}

	});

	function fetchDetails(data) {
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			} 
		});

		$.ajax({
			url : site_url+'/videos/create',
			type: 'get',
			data: data,
			success: function(response) {
				if (response.errors) {
					$.each(response.errors, function(k, v) {

						$input = $form.find('[name="' + k + '"]');

						$input.addClass('is-invalid');
						$input.parent().append('<span class="invalid-feedback">' + v + '</span>');

					});
				} else {

					$('input[name="duration"]').val(response.contentDetails.duration);
					$('input[name="publishedAt"]').val(response.snippet.publishedAt);

					$('input[name="youtube_id"]').val(response.id);
					$('input[name="title"]').val(response.snippet.title);
					$('input[name="slug"]').val(getSlug(response.snippet.title));
					$('textarea[name="description"]').val(response.snippet.description);
					$('#lightbox-popup-video').find('a').prop('href', response.url);


					var thumbres = ['maxres', 'high', 'default'];

					for (var i = 0; i < thumbres.length; i++) {
						if (!($.isEmptyObject(response.snippet.thumbnails[thumbres[i]])) && ($.inArray('default', thumbres) > -1)) {
							thumbres.splice($.inArray('default'), 1);
							$('#lightbox-popup-video').find('img').prop('src', response.snippet.thumbnails[thumbres[i]].url);
						}
					}

					var thumbnails = {};
					$.each(response.snippet.thumbnails, function(k, v) {
						thumbnails[k] = v.url;
					});
					$('input[name="thumbnails"]').val(JSON.stringify(thumbnails));

					var statistics = {};
					$.each(response.statistics, function(k, v) {
						$('#'+k).html(numberFormat(v));
						statistics[k] = v;
					});
					$('input[name="statistics"]').val(JSON.stringify(statistics));
				}
			}
		}).done(function() {
			animate('#videoContainer', 'fadeIn');
		});
	}

	$('.cancel').on('click', function() {
		$('#categoryContainer').addClass('d-none');
		$('#videoContainer').addClass('d-none');
	});

	function draw_data() {
		if ($('select[name="filterGame"]').val()) { $('select[name="filterGame"]').trigger('change'); }
	}

</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>