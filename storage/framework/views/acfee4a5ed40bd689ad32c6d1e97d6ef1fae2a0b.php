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
                                    <div class="mail-inbox-tools d-flex align-items-center">
                                        <h5 class="my-auto">Basic Information</h5>
                                    </div>
                                    <div class="flex-1"></div>
                                    <div class="d-none d-sm-block text-right">
                                        <button class="btn btn-xs btn-color-scheme px-2 my-0 fs-14 fw-450" id="edit-linkalternative">Edit</button>
                                        <button class="btn btn-xs btn-default px-2 my-0 fs-14 fw-450" id="cancel-edit-linkalternative" style="display:none">Cancel</button>
                                    </div>

                                </div>
								<form action="<?php echo e(route('linkAlternative.update', $linkalternative->hostname)); ?>" id="edit-linkalternative-form">
                                	<div class="row p-auto m-1 ">
										<input type="hidden" name="_method" value="PATCH"/>
										<input type="hidden" name="id" value="<?php echo e($linkalternative->id); ?>"/>
										<div class="col-12">
											<div class="form-group">
												<label for="hostname">Hostname</label>
												<input type="text" id="hostname" name="hostname" value="<?php echo e($linkalternative->hostname); ?>" data-hostname="<?php echo e($linkalternative->hostname); ?>" class="form-control" disabled>
											</div>
										</div>
										<div class="col-12">
											<div class="form-group">
												<label for="title">Home Title</label>
												<input type="text" id="title" name="title" value="<?php echo e($linkalternative->home_title); ?>" class="form-control" disabled>
											</div>
										</div>
										<div class="col-12">
											<div class="form-group">
												<label for="keyword">Meta Keyword</label>
												<textarea class="form-control" id="keywords" name="keywords" rows="3" disabled><?php echo e($linkalternative->meta_keywords); ?></textarea>
											</div>
										</div>
										<div class="col-12">
											<div class="form-group">
												<label for="description">Meta Description</label>
												<textarea class="form-control" id="inputDescription" name="description" rows="3" disabled><?php echo e($linkalternative->meta_description); ?></textarea>
											</div>
										</div>
										<div class="col-12">
											<div class="form-group">
												<label for="inputCustomTag">Custom Tags</label>
												<textarea class="form-control" id="inputCustomTag" name="custom_tag" rows="3" disabled><?php echo e($linkalternative->custom_tag); ?></textarea>
											</div>
										</div>
										<div class="col-12">
											<button type="reset" class="btn btn-xs btn-color-scheme px-2 my-0 fs-14 fw-450" href="javascript:void(0);" style="display:none">Reset</button>
											<button class="btn btn-xs btn-color-scheme px-2 my-0 fs-14 fw-450" href="javascript:void(0);" id="edit-linkalternative-save-btn" style="display:none">Save</button>
											<hr>
										</div>
										
										<div class="col-lg-12 mt-2">
											<div class="form-group">
												<label>Custom CSS</label>
												<span class="float-right">
													<a href="javascript:;" id="edit-custom-css">
														<span class="fa fa-pencil"></span>
													</a>
												</span>
											</div>
											<hr>
										</div>

										
									</div>
								</form>
						    </div>
						    <!-- /.mail-sidebar -->
						    <!-- Mails List -->
						    <div class="col-lg-9 col-md-9 mail-inbox">
						        <div class="mail-inbox-header">
						        	<div class="mail-inbox-tools d-flex align-items-center">
										<h5 class="my-auto">Page List</h5>
										<div class="row no-gutters mr-l-20">
											<div class="col-9">
											<input type="text" id="searchInput" name="searchInput" class="form-control" placeholder="Search...">
											</div>
											<div class="col-3">
											<button type="button" class="btn btn-md btn-primary" id="search-page" name="search" style="padding: 0.46rem 0.5em;">Search</button>
											</div>
										</div>
						        	</div>
						        	<!-- /.mail-inbox-tools -->
						            <div class="flex-1"></div>
						            <?php if(App\General::page_access(Auth::user()->group_id, 'linkalternatives', 'create')): ?>
						            <div class="d-none d-sm-block text-right">
										<a class="btn btn-sm btn-color-scheme btn-xl px-4 h6 my-0 fs-16 fw-500" href="<?php echo e(url('linkalternatives/'.$linkalternative->hostname.'/images')); ?>">Manage Images</a>
						            	<a class="btn btn-sm btn-color-scheme btn-xl px-4 h6 my-0 fs-16 fw-500" href="<?php echo e(url('linkalternatives/'.$linkalternative->hostname.'/createpage')); ?>">Create New Page</a>
						            </div>
						            <?php endif; ?>

						        </div>
						        <!-- /.mail-inbox-header -->
						        <div class="px-4">
						        	<table class="mail-list contact-list table-responsive" id="video-list">
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th style="text-align: center">Page Title</th>
                                                <th style="color: #6931e7;">Page Slug</th>
                                                <th>Status</th>
                                                <th style="text-align: center">Action</th>
                                            </tr>
                                        </thead>
						        		<tbody id="page-container">
						        		</tbody>
						            </table>
						            <!-- /.contact-list -->
								</div>
								<div class="row px-4 mt-5 mb-5" id="page-pagination-control">
									<div class="col-7 text-muted mt-1"><span class="headings-font-family pagination-result"></span>
									</div>
									<div class="col-5">
										<div class="btn-group float-right pagination-controls"></div>
									</div>
								</div>
						        <!-- /.px-4 -->
						    </div>
						</div>

                    </content-index>
					<hr>
						<?php echo $__env->make('pages.linkalternative._menulist', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
					<hr>
                    <content-index>
						
						<div class="row no-gutters">
						    <div class="col-12 mail-inbox">
						        <div class="mail-inbox-header">
						        	<div class="mail-inbox-tools d-flex align-items-center">
                                        <h5 class="my-auto">Option List</h5>
						        	</div>
						            <div class="flex-1"></div>
						        </div>
						        <div class="px-4">
						        	<table class="mail-list contact-list table-responsive" id="video-list">
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th>Option Name.</th>
                                                <th>Created At</th>
                                                <th style="text-align: right;">Status</th>
                                                <th style="text-align: right;">Action</th>
                                            </tr>
                                        </thead>
						        		<tbody>
                                            <?php if($linkalternative->options !== null): ?>
                                                <?php $__currentLoopData = $linkalternative->options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td>
                                                        <div class="lightbox-gallery" data-toggle="lightbox-gallery" data-type="image" data-effect="fadeInRight">
                                                            <div class="lightbox">
                                                                <span><?php echo e($loop->iteration); ?>. </span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="contact-list-name">
                                                        <div class="lightbox-gallery ml-3" data-toggle="lightbox-gallery" data-type="image" data-effect="fadeInRight">
                                                            <div class="lightbox">
                                                                <span><?php echo e(ucwords(str_replace('_', ' ', $option->option_name))); ?></span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <span class="contact-list-phone d-block"><?php echo e($option->created_at); ?></span>
                                                    </td>
                                                    <td>
                                                        <span class="badge bg-success-contrast color-success float-right">Active</span>
                                                    </td>
                                                    <td>
                                                        <div class="btn-group float-right">
                                                            <a href="<?php echo e(route('linkAlternative.editoption', [$linkalternative->hostname, $option->option_name])); ?>" data-type="<?php echo e($option->option_name); ?>" class="btn btn-default btn-edit-option">
                                                                <i class="feather feather-edit-2"></i>
															</a>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php else: ?>
						        			<tr>
						        				<td>
						        					<h5 class="text-center p-5">
						        						No Data Available
						        					</h5>
						        				</td>
                                            </tr>
                                            <?php endif; ?>
						        		</tbody>
						            </table>
						        </div>
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

<!-- Modal -->
<div class="modal fade" id="createMenuModal" tabindex="-1" role="dialog" aria-labelledby="createMenuModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Manage Menu</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
					<div class="row p-auto m-1 ">
						<input type="hidden" name="_method" value="PATCH"/>
						<input type="hidden" name="id" value="<?php echo e($linkalternative->id); ?>"/>
						<div class="col-12">
							<div class="form-group">
								<label for="menuIsExternal">External Link</label>
								<select class="form-control" id="menuIsExternal" name="menuIsExternal">
									<option value="0" selected>No</option>
									<option value="1">Yes</option>
								</select>
							</div>
						</div>
						<div class="col-12">
							<div class="form-group">
								<label for="menuTitle">Menu Title</label>
								<input type="menuText" id="menuTitle" name="title" value="" class="form-control">
							</div>
						</div>
						<div class="col-12">
							<div class="form-group">
								<label for="pageUrl">Select Page</label>
								<select id="pageUrl" name="pageUrl" class="form-control">
									<option value="" disabled selected>-</option>
								</select>
							</div>
						</div>
						<div class="col-12" style="display: none">
							<div class="form-group">
								<label for="menuUrl">Menu URL</label>
								<input type="text" id="menuUrl" name="menuUrl" value="" class="form-control">
							</div>
						</div>
						<input type="hidden" id="menuId" value="">
					</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
				<button type="button" class="btn btn-success" id="storeNewMenu">Save</button>
				<button type="button" class="btn btn-success" id="updateMenu">Update</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="editCssModal" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="">Edit Custom CSS</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="row p-auto m-1 ">
					<input type="hidden" name="hostname" value="<?php echo e(str_slug($linkalternative->hostname)); ?>"/>
					<div class="col-12">
						<div class="form-group">
						<textarea rows="10" class="form-control" id="custom-css"><?php echo e(@$linkalternative->getOptionAttribute('custom_css')->value); ?></textarea>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
				<button type="button" class="btn btn-success" id="saveCustomCss">Save</button>
			</div>
		</div>
	</div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
var uploadImageRoute = "<?php echo e(route('linkAlternative.uploadimage')); ?>";
var linkalternative_route = '<?php echo e(route('linkAlternative', '')); ?>';
var linkalternative_pages = '<?php echo e(route('linkAlternative.pages', $linkalternative->hostname)); ?>';
var linkalternative_menus = '<?php echo e(route('linkAlternative.menus', $linkalternative->hostname)); ?>';
var edit_page_url = '<?php echo e(route('linkAlternative.editpage', [$linkalternative->hostname, ''])); ?>';
var delete_page_url = '<?php echo e(route('linkAlternative.deletepage', [$linkalternative->hostname, ''])); ?>';
var delete_menu_url = '<?php echo e(route('linkAlternative.deletemenu', [$linkalternative->hostname, ''])); ?>';
var storeMenu_url = "<?php echo e(route('linkAlternative.storeMenu', [$linkalternative->hostname])); ?>";
var updateMenu_url = "<?php echo e(route('linkAlternative.updateMenu', [$linkalternative->hostname])); ?>";
var getOrdered_menu_url = '<?php echo e(route('linkAlternative.getOrderedMenu', $linkalternative->hostname )); ?>';
var reorder_menu_url = '<?php echo e(route('linkAlternative.reorderMenu', $linkalternative->hostname )); ?>';
var custom_css_url = '<?php echo e(route('linkAlternative.saveCustomCss', $linkalternative->hostname )); ?>';
var fetch_all_pages_url = '<?php echo e(route('linkAlternative.fetchAllPages', $linkalternative->hostname )); ?>';
var clear_cache_url = '<?php echo e(route('linkAlternative.clearCache', $linkalternative->hostname )); ?>';

var 
	default_hostname = '<?php echo e($linkalternative->hostname); ?>',
	default_title = '<?php echo e($linkalternative->home_title); ?>',
	default_keywords = '<?php echo e($linkalternative->meta_keywords); ?>',
	default_description = '<?php echo e($linkalternative->meta_description); ?>',
	default_custom_css = $("#custom-css").val()
;
</script>
<script src="<?php echo e(url('assets/js/linkalternative-info.js?v=0.1')); ?>"></script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>