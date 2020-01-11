<?php $__env->startSection('widget-body'); ?>
<div class="widget-list">
    <div class="row">
        <div class="col-md-12 widget-holder widget-full-content border-all px-0">
            <div class="widget-bg">
                <div class="widget-body clearfix">
                    <content-index class="firstStage">
                        <div class="row no-gutters">
                            <div class="col-12 mail-inbox">
                                <div class="mail-inbox-header">
                                    <div class="mail-inbox-tools d-flex align-items-center">
                                        <h5 class="my-auto">Image List</h5>
                                    </div>
                                    
                                    <div class="flex-1"></div>
                
                                </div>
                                
                                <div class="px-4">
                                    <table class="mail-list contact-list table-responsive" id="video-list">
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th>
                                                    <div class="lightbox-gallery ml-3" data-toggle="lightbox-gallery" data-type="image" data-effect="fadeInRight">
                                                        <div class="lightbox">
                                                            <span>URL</span>
                                                        </div>
                                                    </div>
                                                </th>
                                                <th>
                                                    <div class="lightbox-gallery ml-3" data-toggle="lightbox-gallery" data-type="image" data-effect="fadeInRight">
                                                        <div class="lightbox">
                                                            <span>Thumbnail</span>
                                                        </div>
                                                    </div>
                                                </th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="images-container">
                                            <?php $__currentLoopData = $images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td><?php echo e($loop->iteration); ?></th>
                                                    <td>
                                                        <div class="lightbox-gallery ml-3" data-toggle="lightbox-gallery" data-type="image" data-effect="fadeInRight">
                                                            <div class="lightbox">
                                                                <span class="slider-url" title="Click me to preview." style="cursor: pointer;"><?php echo e($image->url); ?></span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td style="width:15%">
                                                        <img src="<?php echo e($image->url); ?>" style="height: 100px">
                                                    </td>
                                                    <td>
                                                        <div class="btn-group">
                                                            <button id="delete" data-delete-type="swal" data-type="delete" data-url="<?php echo e(route('deleteImage', [$microsite->hostname, $image->id])); ?>" type="button" class="btn btn-default">
                                                                <i class="feather feather-trash-2"></i>
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="row px-4 mt-5 mb-5" id="images-pagination-control">
						            <div class="col-7 text-muted mt-1">
                                        <span class="headings-font-family pagination-result" id="images-pagination-result">Showing 1 - 5 of <?php echo e($images->toArray()['total']); ?> result</span>
						            </div>
						            <div class="col-5">
                                        <div class="btn-group float-right pagination-controls">
                                            <a href="<?php echo e($images->toArray()['last_page_url']); ?>" class="btn fs-18 bw-1 radius-0 btn-outline-default ripple px-2 prev">
                                                <i class="list-icon material-icons">keyboard_arrow_left</i>
                                            </a>
                                            <a href="<?php echo e(url('microsites/'.$microsite->hostname.'/images')); ?>?page=2" class="btn fs-18 bw-1 radius-0 btn-outline-default ripple px-2 next">
                                                <i class="list-icon material-icons">keyboard_arrow_right</i>
                                            </a>
                                        </div>
						            </div>
						        </div>
                            </div>
                        </div>
                        
                    </content-index>
                    <content-index class="firstStage previewImage" style="display: none">
                        <div class="row no-gutters">
                            <div class="col-12 mail-inbox">
                                <div class="px-4 pb-4 pt-0 my-0">
                                    <button class="delete btn btn-sm btn-success h6 mt-0 mb-1 fs-16 fw-500" id="slideUp" title="Slide me up"><i class="list-icon feather feather-chevron-up"></i></button><br>
                                    <img class="my-0" id="previewImage" src="">
                                </div>
                            </div>
                        </div>
                    </content-index>

                </div>
            </div>
        </div>
    </div>
</div>
<!-- /.widget-list -->
<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>
<script>
    var hostname = "<?php echo e($microsite->hostname); ?>";
    var imagesRoute = "<?php echo e(route('images', [$microsite->hostname])); ?>";
</script>
<script src="<?php echo e(url('assets/js/edit-sliderimages.js?v=0.1')); ?>"></script>
<script src="<?php echo e(url('assets/js/manage-images.js?v=0.1')); ?>"></script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>