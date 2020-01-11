<?php $__env->startSection('widget-body'); ?>
<div class="widget-list">
	<div class="row">
		<div class="widget-holder col-lg-6 col-md-12 col-sm-12 col-xs-12">
			<div class="widget-bg-transparent">
				<div class="widget-heading widget-heading-border">
					<h5 class="widget-title">User Group</h5>
					<?php if(App\General::page_access(Auth::user()->group_id, 'user_group', 'create')): ?>
					<div class="widget-actions">
						<a class="create btn btn-sm btn-primary ml-1" href="javascript:void(0);" data-type="post" data-url="<?php echo e(url('user_groups')); ?>">Create New</a>
					</div>
					<?php endif; ?>
				</div>
				<div class="widget-body clearfix">

					<content-index>


					<div class="accordion accordion-minimal" id="accordion-minimal" role="tablist" aria-multiselectable="true"></div>

					</content-index>

					<content-form style="display: none;">

						<form id="general-form" method="" action="">
							<div class="col-lg-3">
								<div class="form-group">
									<label for="inputName">Name</label>
									<input type="text" id="inputName" name="name" class="form-control">
								</div>
							</div>
	
							<div class="user_modules">
								
							</div>

							<div class="form-actions btn-list mt-3">
								<button class="btn btn-success" type="submit">Submit</button>
								<button class="cancel btn btn-outline-default" type="button">Cancel</button>
							</div>
						</form>

					</content-form>

				</div>
				<!-- /.widget-body -->
			</div>
			<!-- /.widget-bg -->
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

	$(function() {

		var permission = {
			alter: false,
			drop: false
		}

		fetchUserGroups(permission);

		$('#accordion-minimal').on('show.bs.collapse', function(e) {
			var e = $(document).find("[href='#" + $(e.target).attr('id') + "']");

			var el = e.parents('div.card').find('div[role="tabpanel"] > .card-body');

			el.html('');

			var id = e.attr('href').replace('#', '');

			e.parent('.card-title').find('.inline-input').remove();

			var input = `<div class="col-md-3 inline-input">
                            <div class="form-group">
                                <input class="form-control" name="name" placeholder="" type="text" value="${e.text()}">
                            </div>
                        </div>`;

			e.parent('.card-title').append(input);

			var html = `<form id="general-form" data-type="put" data-url="/user_groups/${id}">
							<div class="user_groups"></div>
							<div class="form-actions btn-list my-3 float-right">`;
							if (permission.drop) {
								html += `<button id="delete" data-callback="draw_data" data-type="delete" data-delete-type="swal" data-url="/user_groups/${id}" class="btn btn-danger btn-sm" type="button">Delete</button>`;
							}
							if (permission.alter) {
								html += `<button id="save" class="btn btn-success btn-sm" type="button">Save</button>`;
							}
					html += `</div>
						</form>`;

			el.html(html);

			fetchModules($('.user_groups'), id);

		});

		$('#accordion-minimal').on('hidden.bs.collapse', function (e) {
			var e = $(document).find("[href='#" + $(e.target).attr('id') + "']");

			var el = e.parents('div.card').find('div[role="tabpanel"] > .card-body');

			el.html('');

			e.parent('.card-title').find('.inline-input').remove();
			
		})

		$(document).on('click', 'input:checkbox', function() {
			var value = $(this).val();

			if($(this).attr('name') == 'create[]' || $(this).attr('name') == 'alter[]' || $(this).attr('name') == 'drop[]') {
				if(!$('#view_'+value).is(':checked')){
					$('#view_'+value).prop('checked', true);
					$('#game_filtered').removeClass('d-none');
				}
			}

			if($(this).attr('name') == 'view[]') {

				$parent = $(this).parents('li.list-group-item');
				var id  = $parent.data('parent-id');

				$target_view = $('.parent-menu-'+id).find('#view_'+id);

				if(!$(this).is(':checked')){
					$('#create_'+value).prop('checked', false);
					$('#alter_'+value).prop('checked', false);
					$('#drop_'+value).prop('checked', false);

					if (!$('[data-parent-id="'+id+'"]').find('[name="view[]"]:checked').length) { 
						$target_view.prop('checked', false);
					}
				}

				if ($(this).is(':checked')) {
					if ($parent.hasClass('sub-menu')) {
						if (!$target_view.is(':checked')) {
							$target_view.prop('checked', true);
						}
					}
				}
			}
		});

		$(document).on('click', '#save', function() {
			$form = $(this).parents('form#general-form');

			$form.attr('data-params', `name=${$('input[name="name"]').val()}`);

			$form.submit();
		})

		$(document).on('click', '.create', function() {
			fetchModules($('.user_modules'));
		})

	});

	//show list of user group.
	function fetchUserGroups(permission = null) {
		$.ajax({
			url : site_url+'/user_groups/',
			type: 'get',
			dataType: 'json',
			success: function(response) {

				var html = '';

				if (permission != null) {
					if (response.alter) {
						permission.alter = response.alter;
					}

					if (response.drop) {
						permission.drop = response.drop;
					}
				}

				if (response.data.length > 0) {
					$.each(response.data, function(key, value) {
						html += `<div class="card">
									<div class="card-header" role="tab">
										<h6 class="card-title">
											<a role="button" class="collapsed" data-toggle="collapse" data-parent="#accordion-minimal" href="#${value.id}" aria-expanded="true" aria-controls="${value.id}">${value.name}</a>
										</h6>
									</div>
									<div id="${value.id}" class="card-collapse collapse" role="tabpanel">
										<div class="card-body"></div>
									</div>
								</div>`;
					});
				} else {
					html += `<div class="m-auto p-5 m-auto p-5 text-center">
								No data available
							</div>`;
				}

				$('#accordion-minimal').html(html);

			}
		});
	}

	function fetchModules(el, id) {
		$.ajax({
			url : site_url+'/user_modules/',
			type: 'get',
			dataType: 'json',
			success: function(response) {

				var html = '';

				if (response.length > 0) {

				html += `<ol class="list-group menus">`;

					for (let key = 0; key < response.length; key++) {
						const value = response[key];

	                 	html += `<li class="list-group-item bg-color-scheme text-inverse d-flex parent-menu-${value.parent.id}">
	                                    <div class="mr-auto">${(value.parent.icon) ? '<i class="' + value.parent.icon + '"></i>' : ''} <span class="hide-menu">${value.parent.name}</span></div>`;

	                                    if (value.sub.length > 0) {

	                                    	html += `<div class="d-none">
				                                        <div class="checkbox checkbox-circle d-inline">
				                                            <label>
				                                                <input id="view_${value.parent.id}" name="view[]" value="${value.parent.id}" type="checkbox" /> <span class="label-text">View</span>
				                                            </label>
				                                        </div>
				                                        <div class="checkbox checkbox-circle d-inline">
				                                            <label>
				                                                <input id="create_${value.parent.id}" name="create[]" value="${value.parent.id}" type="checkbox" /> <span class="label-text">Create</span>
				                                            </label>
				                                        </div>
				                                        <div class="checkbox checkbox-circle d-inline">
				                                            <label>
				                                                <input id="alter_${value.parent.id}" name="alter[]" value="${value.parent.id}" type="checkbox" /> <span class="label-text">Edit</span>
				                                            </label>
				                                        </div>
				                                        <div class="checkbox checkbox-circle d-inline">
				                                            <label>
				                                                <input id="drop_${value.parent.id}" name="drop[]" value="${value.parent.id}" type="checkbox" /> <span class="label-text">Delete</span>
				                                            </label>
				                                        </div>
				                                    </div>`;

	                                    	$.each(value.sub, function(k, v) {
                                    	
                                    		html +=	`<li class="list-group-item d-flex sub-menu ml-5" data-parent-id="${value.parent.id}">
			                                    		<div class="mr-auto">${v.name}</div>
			                                    		<div>
					                                        <div class="checkbox checkbox-circle checkbox-color-scheme d-inline">
					                                            <label>
					                                                <input id="view_${v.id}" name="view[]" value="${v.id}" type="checkbox" /> <span class="label-text">View</span>
					                                            </label>
					                                        </div>
					                                        <div class="checkbox checkbox-circle checkbox-color-scheme d-inline">
					                                            <label>
					                                                <input id="create_${v.id}" name="create[]" value="${v.id}" type="checkbox" /> <span class="label-text">Create</span>
					                                            </label>
					                                        </div>
					                                        <div class="checkbox checkbox-circle checkbox-color-scheme d-inline">
					                                            <label>
					                                                <input id="alter_${v.id}" name="alter[]" value="${v.id}" type="checkbox" /> <span class="label-text">Edit</span>
					                                            </label>
					                                        </div>
					                                        <div class="checkbox checkbox-circle checkbox-color-scheme d-inline">
					                                            <label>
					                                                <input id="drop_${v.id}" name="drop[]" value="${v.id}" type="checkbox" /> <span class="label-text">Delete</span>
					                                            </label>
					                                        </div>
					                                    </div>
		                                    		</li>`;
	                                    		
	                                    	});

	                                    } else {
	                                    	html += `<div>
				                                        <div class="checkbox checkbox-circle d-inline">
				                                            <label>
				                                                <input id="view_${value.parent.id}" name="view[]" value="${value.parent.id}" type="checkbox" /> <span class="label-text">View</span>
				                                            </label>
				                                        </div>
				                                        <div class="checkbox checkbox-circle d-inline">
				                                            <label>
				                                                <input id="create_${value.parent.id}" name="create[]" value="${value.parent.id}" type="checkbox" /> <span class="label-text">Create</span>
				                                            </label>
				                                        </div>
				                                        <div class="checkbox checkbox-circle d-inline">
				                                            <label>
				                                                <input id="alter_${value.parent.id}" name="alter[]" value="${value.parent.id}" type="checkbox" /> <span class="label-text">Edit</span>
				                                            </label>
				                                        </div>
				                                        <div class="checkbox checkbox-circle d-inline">
				                                            <label>
				                                                <input id="drop_${value.parent.id}" name="drop[]" value="${value.parent.id}" type="checkbox" /> <span class="label-text">Delete</span>
				                                            </label>
				                                        </div>
				                                    </div>`;
	                                    }

	                      	html += `</li>`;

					}

				html += `</ol>`;


				}

				$(el).html(html);
				setTimeout(fetchAccess, 500, id);

			}
		});
	}

	function fetchAccess(id) {
		$.ajax({
			url : site_url+'/user_groups/'+id,
			type: 'get',
			dataType: 'json',
			success: function(response) {
				console.log(response);

				$.each($.parseJSON(response.view), function(i, v) {
				console.log($('#view_'+v).length);
					$('#view_'+v).prop('checked', true);
				});
				$.each($.parseJSON(response.create), function(i, v) {
					console.log($('#view_'+v).length);
					$('#view_'+v).prop('checked', true);
					$('#create_'+v).prop('checked', true);
				});
				$.each($.parseJSON(response.alter), function(i, v) {
					console.log($('#view_'+v).length);
					$('#view_'+v).prop('checked', true);
					$('#alter_'+v).prop('checked', true);
				});
				$.each($.parseJSON(response.drop), function(i, v) {
					console.log($('#view_'+v).length);
					$('#view_'+v).prop('checked', true);
					$('#drop_'+v).prop('checked', true);
				});

			}
		});
	}

	function draw_data() {
		fetchUserGroups();
	}


</script>

<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>