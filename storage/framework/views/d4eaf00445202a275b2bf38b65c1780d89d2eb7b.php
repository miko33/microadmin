<?php $__env->startSection('widget-body'); ?>
<div class="widget-list">
	<div class="row">
		<div class="widget-holder col-lg-8 col-md-12 col-sm-12 col-xs-12">
			<div class="widget-bg">
				<div class="widget-heading widget-heading-border">

					<h5 class="widget-title">User</h5>
					<?php if(App\General::page_access(Auth::user()->group_id, 'user', 'create')): ?>
					<div class="widget-actions">
						<a class="create btn btn-sm btn-primary ml-1" href="javascript:void(0);" data-callback="dataTable" data-type="post" data-url="<?php echo e(url('users')); ?>">Create New</a>
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

							<div class="row">
								<div class="col-lg-6">
									<div class="col-lg-6">
										<div class="form-group">
											<label for="inputName">Name</label>
											<input type="text" id="inputName" name="name" class="form-control" placeholder="Name" required />
										</div>
									</div>

									<div class="col-lg-12 row">
										<div class="col-lg-6">
											<div class="form-group">
												<label for="inputEmail">Email</label>
												<input type="email" id="inputEmail" name="email" class="form-control" placeholder="Email" required />
											</div>
										</div>

										<div class="col-lg-6">
											<div class="form-group">
												<label for="inputUsername">Username</label>
												<input type="text" id="inputUsername" name="username" class="form-control" placeholder="Username" required />
											</div>
										</div>
									</div>

									<div class="col-lg-12 row">
										<div class="col-lg-6">
											<div class="form-group">
												<label for="inputPassword">Password</label>
												<input type="password" id="inputPassword" name="password" class="form-control" placeholder="Password" required />
											</div>
										</div>

										<div class="col-lg-6">
											<div class="form-group">
												<label for="inputConfirmPassword">Confirm Password</label>
												<input type="password" id="inputConfirmPassword" name="password_confirmation" class="form-control" placeholder="Confirm Password" required />
											</div>
										</div>
									</div>

									<div class="col-lg-6">
										<div class="form-group">
											<label for="inputPasscode">Passcode</label>
											<input type="password" id="inputPasscode" name="passcode" class="form-control" placeholder="Passcode" required />
										</div>
									</div>
								</div>

								<div class="col-lg-6">
									<div class="col-lg-6">
										<div class="form-group">
											<label for="selectDivision" class="form-control-label">Division</label>
											<select class="selectpicker form-control" id="selectDivision" name="division[]" multiple="multiple" data-live-search="true" data-style="btn btn-default">
												<?php $__currentLoopData = $divisions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $division): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
													<option value="<?php echo e($division->id); ?>" /><?php echo e(ucfirst($division->name)); ?>

												<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
											</select>
										</div>
									</div>

									<div class="col-lg-6">
										<div class="form-group">
											<label for="selectUserGroup" class="form-control-label">User Group</label>
											<select class="selectpicker form-control" id="selectUserGroup" name="group_id" data-live-search="true" data-style="btn btn-default">
												<option selected disabled></option>
												<?php $__currentLoopData = $user_groups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user_group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
													<option value="<?php echo e($user_group->id); ?>" /><?php echo e(ucwords($user_group->name)); ?>

												<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
											</select>
										</div>
									</div>
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