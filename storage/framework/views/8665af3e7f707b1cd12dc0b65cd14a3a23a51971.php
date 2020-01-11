<?php $__env->startSection('widget-body'); ?>
<div class="widget-list">
	<div class="row">
		<div class="widget-holder col-lg-6 col-md-12 col-sm-12 col-xs-12">
			<div class="widget-bg">
				<div class="widget-heading widget-heading-border">

					<h5 class="widget-title">Category</h5>
					<?php if(App\General::page_access(Auth::user()->group_id, 'category', 'create')): ?>
					<div class="widget-actions">
						<a class="create btn btn-sm btn-primary ml-1" href="javascript:void(0);" data-type="post" data-url="<?php echo e(url('categories')); ?>" data-params="prefix=_categories">Create New</a>
					</div>
					<?php endif; ?>

					<!-- /.widget-actions -->
				</div>
				<!-- /.widget-heading -->
				<div class="widget-body">

					<content-index style="display: <?php echo e(($create !== '') ? 'none' : 'block'); ?>;">

						<div class="col-md-3 col-sm-12 col-xs-12 mb-3">
							<div class="row">
								<select class="form-control" name="filterGame" data-placeholder="Select a game" data-toggle="select2">
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

						<div class="list-group">

							<div class="categoryList_processing m-auto p-5">
								No data available
							</div>

						</div>
						<!-- /.list-group -->

					</content-index>

					<content-form style="display: <?php echo e(($create !== '') ? 'block' : 'none'); ?>;">

						<form id="general-form" method="" action="" <?php if($create !== ''): ?> data-params="prefix=_categories" data-url="<?php echo e(url('categories')); ?>" data-type="post" <?php endif; ?>>
							<div class="col-lg-6">
								<div class="form-group">
									<label for="inputGame">Game</label>
									<select class="form-control" id="inputGame" name="game" data-placeholder="Select a game" data-toggle="select2">
										<option></option>
										<?php $__currentLoopData = $divisions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $division): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
										<optgroup label="<?php echo e(ucfirst($division->name)); ?>">
											<?php $__currentLoopData = explode(',', $division->game); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $game): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
											<option value="<?php echo e($division->name.'_'.$game); ?>" <?php echo e(($create == $division->name.'_'.$game) ? 'selected' : ''); ?>><?php echo e($game); ?></option>
											<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
										</optgroup>
										<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
									</select>
								</div>
							</div>
							<div class="col-lg-6">
								<div class="form-group">
									<label for="inputName">Name</label>
									<input type="text" id="inputName" name="name" class="form-control">
								</div>
							</div>
							<div class="col-lg-6">
								<div class="form-group">
									<label for="inputSlug">Slug</label>
									<input type="text" id="inputSlug" name="slug" class="form-control">
								</div>
							</div>

							<div class="form-actions btn-list">
								<button class="btn btn-success" type="submit">Submit</button>
								<?php if($create !== ''): ?>
								<button class="btn btn-outline-default" type="button" onclick="goBack()">Cancel</button>
								<?php else: ?>
								<button class="cancel btn btn-outline-default" type="button">Cancel</button>
								<?php endif; ?>
							</div>
						</form>

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

	//show list of categories specified by the selected game.
	$('select[name="filterGame"]').on('change', function() {

		var $this = $(this);

		$.ajax({
			url : site_url+'/categories',
			type: 'get',
			data: { game: $this.val(), prefix: '_categories' },
			beforeSend: function() {
				$($this).attr('disabled', true);
				$('.categoryList_processing').remove();
			},
			success: function(response) {

				var html = '';

				if (response.data.length > 0) {
					$.each(response.data, function(key, value) {
					html += '<div class="list-group-item list-group-item-action d-flex justify-content-end">' +
									'<strong class="mr-auto">'+value.name+'</strong>' +
									'<span class="badge badge-pill bg-info-contrast fs-12 mr-1 my-auto">'+value.count+'</span>' +
									'<a href="#" aria-expanded="true" data-toggle="dropdown"><i class="feather feather-more-horizontal icon icon-muted my-auto"></i></a>' +
									'<div role="menu" class="dropdown-menu">' +
										'<a class="dropdown-item" href="'+site_url+'/videos?game='+$this.val()+'&category='+value.id+'"><strong>View</strong></a>';

										if (response.alter) {
											html += '<a class="dropdown-item" id="edit" data-type="put" data-url="'+site_url+'/categories/'+value.id+'" data-params="game='+$this.val()+'&prefix=_categories" href="#"><strong>Edit</strong></a>';
										}

										if (response.drop) {
											html += '<div class="dropdown-divider"></div>' +
													'<a class="dropdown-item" id="delete" data-type="delete" data-url="'+site_url+'/categories/'+value.id+'" data-params="game='+$this.val()+'&prefix=_categories" href="#"><strong class="text-danger">Delete</strong></a>';
										}

							html +=	'</div>' +
							'</div>';
					});
				} else {
					html += `<div class="categoryList_processing m-auto p-5">
								No data available
							</div>`;
				}

				$('.list-group').html(html);

			}
		}).done(function() {
			$($this).attr('disabled', false);
		});

	});

	function draw_data() {
		if ($('select[name="filterGame"]').val()) { $('select[name="filterGame"]').trigger('change'); }
	}

</script>

<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>