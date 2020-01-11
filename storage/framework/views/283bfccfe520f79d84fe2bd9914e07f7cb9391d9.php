<?php $__env->startSection('widget-body'); ?>
<div class="widget-list">
	<div class="row">
		<div class="widget-holder col-lg-6 col-md-12 col-sm-12 col-xs-12">
			<div class="widget-bg">
				<div class="widget-heading widget-heading-border">

				<h5 class="widget-title"><a href="<?php echo e(route('micrositeList')); ?>?game=<?php echo e($game->id); ?>"><strong><?php echo e($game->name); ?> </strong>Microsites</a></h5>
				<?php if(App\General::page_access(Auth::user()->group_id, 'game', 'create')): ?>
				<div class="widget-actions">
					<a class="create btn btn-sm btn-primary ml-1" href="javascript:void(0);" data-callback="dataTable" data-type="post" data-url="<?php echo e(url('games')); ?>">Create New Microsites</a>
				</div>
				<?php endif; ?>

					<!-- /.widget-actions -->
				</div>
				<!-- /.widget-heading -->
				<div class="widget-body">

					<content-index>


						<div class="col-lg-12">
							<?php echo $dataTable->table(['class' => 'table table-responsive w-100']); ?>

						</div>

					</content-index>

					<content-form style="display: none;">

						<form id="general-form">
							<div class="col-lg-6">
								<div class="form-group">
									<label for="selectDivision">Template</label>
									<select class="form-control" id="selectTemplate" name="template" data-placeholder="Select Template" data-toggle="select2">
										<option value="1">Template 1</option>
										<option value="2">Template 2</option>
										<option value="3">Template 3</option>
										<option value="4">Template 4</option>
										<option value="5">Template 5</option>
										<option value="6">Template 6</option>
									</select>
								</div>
							</div>
							<div class="col-lg-6">
								<div class="form-group">
									<label for="inputHostname">Hostname</label>
									<input type="text" id="inputHostname" name="hostname" class="form-control">
								</div>
							</div>
							<div class="col-lg-6">
								<div class="form-group">
									<label for="inputTitle">Title</label>
									<input type="text" id="inputTitle" name="title" class="form-control">
								</div>
							</div>
							<div class="col-lg-6">
								<div class="form-group">
									<label for="inputKeyword">Meta Keyword</label>
									<input type="text" id="inputKeyword" name="keyword" class="form-control">
								</div>
							</div>
							<div class="col-lg-6">
								<div class="form-group">
									<label for="inputDescription">Meta Description</label>
									<input type="text" id="inputDescription" name="description" class="form-control" >
								</div>
							</div>
							<div class="col-lg-6">
								<div class="form-group">
									<label for="inputCustomTag">Custom Tags</label>
									<textarea id="inputCustomTag" name="custom_tag" class="form-control"></textarea>
								</div>
							</div>
							<div class="col-lg-6">
								<div class="form-group">
									<label for="inputBlog" class="d-block mb-3">Blog</label>
									<label class="switch"><input type="checkbox" id="togBtn"><div class="slider round"></div></label>
								</div>
							</div>

							<div class="form-actions btn-list">
								<button class="btn btn-success" type="button" id="microsite_submit">Submit</button>
								<button class="cancel btn btn-outline-default" type="button">Cancel</button>
							</div>
							<input type="hidden" id="gameID" value="<?php echo e($game->id); ?>" />
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

<script src="<?php echo e(url('assets/js/microsite.js?v=0.1')); ?>"></script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>