<?php $__env->startSection('widget-body'); ?>
<div class="widget-list">
	<div class="row">
		<div class="widget-holder col-lg-6 col-md-12 col-sm-12 col-xs-12">
			<div class="widget-bg">
				<div class="widget-heading widget-heading-border">

				<h5 class="widget-title">Game</h5>
					<?php if(App\General::page_access(Auth::user()->group_id, 'game', 'create')): ?>
					<div class="widget-actions">
						<a class="create btn btn-sm btn-primary ml-1" href="javascript:void(0);" data-callback="dataTable" data-type="post" data-url="<?php echo e(url('games')); ?>">Create New</a>
					</div>
					<?php endif; ?>

					<!-- /.widget-actions -->
				</div>
				<!-- /.widget-heading -->
				<div class="widget-body">

					<content-index>
						<?php if(count($divisions) > 1): ?>
							<div class="col-md-3 col-sm-12 col-xs-12">
								<div class="row">
									<select class="form-control" name="filterDivision" data-placeholder="Select a division" data-toggle="select2">
										<option></option>
										<?php $__currentLoopData = $divisions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $division): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
											<option value="<?php echo e($division->id); ?>"><?php echo e(ucfirst($division->name)); ?></option>
										<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
									</select>
								</div>
							</div>
						<?php endif; ?>

						<div class="col-lg-12">
							<?php echo $dataTable->table(['class' => 'table table-responsive w-100']); ?>

						</div>

					</content-index>

					<content-form style="display: none;">

						<form id="general-form">
							<div class="col-lg-6">
								<div class="form-group">
									<label for="selectDivision">Division</label>
									<select class="form-control" id="selectDivision" name="game_division" data-placeholder="Select a division" data-toggle="select2">
										<option></option>
											<?php $__currentLoopData = $divisions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $division): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
												<option value="<?php echo e($division->id); ?>"><?php echo e(ucfirst($division->name)); ?></option>
											<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
									</select>
								</div>
							</div>
							<div class="col-lg-6">
								<div class="form-group">
									<label for="inputName">Name</label>
									<input type="text" id="inputName" name="game_name" class="form-control">
								</div>
							</div>
							<div class="col-lg-6">
								<div class="form-group">
									<label for="inputUrl">Url</label>
									<input type="text" id="inputUrl" name="game_url" class="form-control" placeholder="http://example.com">
								</div>
							</div>

							<div class="form-actions btn-list">
								<button class="btn btn-success" type="submit">Submit</button>
								<button class="cancel btn btn-outline-default" type="button">Cancel</button>
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

<?php echo $dataTable->scripts(); ?>


<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>