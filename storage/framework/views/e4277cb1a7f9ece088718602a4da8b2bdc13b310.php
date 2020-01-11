<?php $__env->startSection('widget-body'); ?>
<link rel="stylesheet" href="<?php echo e(url('assets/vendors/image-picker/image-picker.css')); ?>">
<style>
    .image-picker-preview img {
        height: 150px;
        width: auto;
    }
</style>
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
                                            <h5 class="my-auto">Slider List</h5>
                                        </div>

                                        <div class="flex-1"></div>
                                        <?php if(App\General::page_access(Auth::user()->group_id, 'microsite', 'create')): ?>
                                        <div class="d-none d-sm-block text-right">
                                            <button class="btn btn-sm btn-color-scheme btn-xl px-4 h6 my-0 fs-16 fw-500" id="reorderSlider" href="javascript:void(0);">Reorder Slider</button>
                                        </div>
                                        <?php endif; ?>

                                    </div>

                                    <div class="px-4">
                                        <table class="mail-list contact-list table-responsive" id="video-list">
                                            <thead>
                                                <tr>
                                                    <th style="width: 3%">No.</th>
                                                    <th style="width: 47%">
                                                        <div class="lightbox-gallery ml-3" data-toggle="lightbox-gallery" data-type="image" data-effect="fadeInRight">
                                                            <div class="lightbox">
                                                                <span>URL</span>
                                                            </div>
                                                        </div>
                                                    </th>
                                                    <th style="width: 40%">Alt</th>
                                                    <th style="width: 10%">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody id="slider-container">
                                                <?php $__currentLoopData = $options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <tr>
                                                        <td><?php echo e($loop->iteration); ?></th>
                                                        <td>
                                                            <div class="lightbox-gallery ml-3" data-toggle="lightbox-gallery" data-type="image" data-effect="fadeInRight">
                                                                <div class="lightbox">
                                                                    <span class="slider-url" title="Click me to preview." style="cursor: pointer;"><?php echo e($option->url); ?></span>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <?php echo e($option->alt); ?>

                                                        </td>
                                                        <td>
                                                            <div class="btn-group">
                                                                <button type="button" class="edit-slider btn btn-default" data-key="<?php echo e($key); ?>" data-url="<?php echo e($option->url); ?>" data-alt="<?php echo e($option->alt); ?>">
                                                                    <i class="feather feather-edit-2"></i>
                                                                </button>
                                                                <button id="delete" data-delete-type="swal" data-type="delete" data-url="<?php echo e(route('deleteSliderImage', [$microsite->hostname, $key])); ?>" type="button" class="btn btn-default">
                                                                    <i class="feather feather-trash-2"></i>
                                                                </button>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="row px-4">
                                    <div class="col-md-2 d-flex mb-0">
                                    <button class="btn btn-sm btn-color-scheme btn-xl px-4 h6 my-0 fs-16 fw-500" style="margin-bottom: 50px !important" id="sfm-button">Select From Media</button>
                                        </div>
                                        <div class="col-md-4 d-flex mb-0">
                                            <div class="form-group ml-auto">
                                                <label for="hostname">Upload New Slider</label>
                                                <input type="file" id="sliderImage" name="sliderImage">
                                                <button class="btn btn-sm btn-success px-4 h6 my-0 fs-16 fw-500" id="uploadSlider" data-microsite="<?php echo e($microsite->hostname); ?>" style="display: none">Save</button>
                                            </div>
                                        </div>
                                        <div class="col-md-4 d-flex mb-0">
                                        <form id="imageupload" action="javascript:void(0)" encttype="multipart/form-data">
                                                <?php echo e(csrf_field()); ?>

                                                <div class="form-group ml-auto">
                                                    <label>Upload New Local Slider</label>
                                                    <input type="file" name="imagelocal" id="imagelocal" accept="image/x-png,image/gif,image/jpeg">
                                                    <input type="hidden" id="host" value="<?php echo e($microsite->hostname); ?>">
                                                    <button type="submit" class="btn btn-sm btn-success px-4 h6 my-0 fs-16 fw-500 saves" style="display: none;">Save</button>
                                                </div>
                                            </form>
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

                    <content-index class="secondStage" style="display: none">

                        <div class="row no-gutters">
                            <div class="col-12 mail-inbox">
                                <div class="mail-inbox-header">
                                    <div class="mail-inbox-tools d-flex align-items-center">
                                        <h5 class="my-auto">Slider Order</h5>
                                    </div>
                                </div>
                                <div class="px-4">
                                    <div class="dd" id="dd">
                                        <ol class="dd-list" id="most_parent_ol">
                                            <?php $__currentLoopData = $options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $slider): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <li class="dd-item" data-id="<?php echo e($key); ?>">
                                                <div class="dd-handle d-flex justify-content-between" style="width:100%;height: auto;">
                                                    <span class="align-middle"><?php echo e($slider->url); ?> </span>
                                                    <img class="" src="<?php echo e($slider->url); ?>" height="50px">
                                                </div>
                                            </li>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </ol>
                                    </div>
                                </div>
                                <div class="row px-4 mt-5 mb-2">
                                    <div class="col d-flex mt-5">
                                        <a class="btn btn-xs btn-primary px-2 my-0 fs-14 fw-450 ml-auto" id="cancelSliderOrder" href="javascript:void(0);">Cancel</a>
                                        <a class="btn btn-xs btn-success px-2 my-0 fs-14 fw-450 ml-1" id="saveSliderOrder" href="javascript:void(0);" style="display: none;">Save</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </content-index>

                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="selectImageModal" tabindex="-1" role="dialog" aria-labelledby="selectImageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="selectImageModalLabel">Select From Media</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <select class="image-picker show-html" id="image-selector">
                    <?php $__currentLoopData = $microsite->images()->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option data-img-src="<?php echo e($image->url); ?>" data-img-class="image-picker-preview" data-img-alt="<?php echo e($image->url); ?>" value="<?php echo e($image->url); ?>">  <?php echo e($image->url); ?>  </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-success" id="select-slider">Select</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="editSliderModal" tabindex="-1" role="dialog" aria-labelledby="editSliderModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editSliderModalLabel">Edit Slider</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="edit-slider-url">URL</label>
                    <input type="text" id="edit-slider-url" name="edit-slider-url" value="" disabled class="form-control">
                </div>
                <div class="form-group">
                    <label for="edit-slider-image-alt">Image Alt</label>
                    <input type="text" id="edit-slider-image-alt" name="edit-slider-image-alt" value="" class="form-control">
                    <input type="hidden" id="edit-slider-key" name="edit-slider-key" value="" class="form-control">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-success" id="save-edit-slider">Save</button>
            </div>
        </div>
    </div>
</div>
<!-- /.widget-list -->
<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>
<script>
    var hostname = "<?php echo e($microsite->hostname); ?>";
    var uploadImageRoute = "<?php echo e(route('uploadimage')); ?>";
    var selectSliderFromMedia = "<?php echo e(route('selectSliderFromMedia', $microsite->hostname)); ?>";
    var getSlidersRoute = "<?php echo e(route('getSliderImage', [$microsite->hostname])); ?>";
    var getOrderedSliderRoute = "<?php echo e(route('getOrderedSlider', [$microsite->hostname])); ?>";
    var reorderSliderRoute = "<?php echo e(route('reorderSlider', [$microsite->hostname])); ?>";
    var editSliderRoute = "<?php echo e(route('editSlider', [$microsite->hostname])); ?>";
</script>
<script src="<?php echo e(url('assets/vendors/image-picker/image-picker.min.js?v=0.1')); ?>"></script>
<script src="<?php echo e(url('assets/js/edit-sliderimages.js?v=0.1')); ?>"></script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>