<?php $__env->startSection('widget-body'); ?>
<div class="widget-list">
    <div class="row no-gutters">
        <div class="col mail-inbox">
            <form action="#" id="formPage">
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label for="pageTitle">Page Title</label>
                            <div class="input-group">
                                <input type="text" id="pageTitle" name="title" value="<?php if(!empty($page)): ?> <?php echo e($page->title); ?> <?php endif; ?>" class="form-control">
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-md btn-success" id="save_page" data-type="<?php echo e((!empty($page)) ? 'update' : 'store'); ?>" data-slug="<?php echo e((!empty($page)) ? $page->slug : ''); ?>" name="search" style="padding: 0.46rem 0.5em;">Save</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label for="pageSlug">Page Slug</label>
                            <input type="text" id="pageSlug" name="newslug" value="<?php if(!empty($page)): ?> <?php echo e($page->slug); ?> <?php endif; ?>" class="form-control">
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label for="pageMetaKeywords">Meta Keywords</label>
                            <input type="text" id="pageMetaKeywords" name="meta_keywords" value="<?php if(!empty($page)): ?> <?php echo e($page->meta_keywords); ?> <?php endif; ?>" class="form-control">
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label for="pageMetaDescription">Meta Description</label>
                            <textarea id="pageMetaDescription" name="meta_description" class="form-control"><?php if(!empty($page)): ?> <?php echo e($page->meta_description); ?> <?php endif; ?></textarea>
                        </div>
                    </div>
                    <div class="col-12">
                        <label for="pageContent">Page Content</label>
                        <textarea id="pageContent" name="content"><?php if(!empty($page)): ?> <?php echo e($page->content); ?> <?php endif; ?></textarea>
                        <input name="image" type="file" id="upload" style="display: none;">
                        <input type="hidden" name="site_id" id="site_id" value="<?php echo e($microsite->id); ?>">
                    </div>
                </div>
            </form>
        </div>
    </div>
	<!-- /.row -->
</div>
<!-- /.widget-list -->
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    var hostname = "<?php echo e($microsite->hostname); ?>";
    var uploadImageRoute = "<?php echo e(route('uploadimage')); ?>";
    var storePage = "<?php echo e(route('storepage', [$microsite->hostname])); ?>";
    var updatePage = "<?php echo e(route('updatepage', [$microsite->hostname])); ?>";
    var redirectTo = '<?php echo e(route('microsite', $microsite->hostname)); ?>';
    var image_list = [
        <?php $__currentLoopData = $microsite->images()->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            {
                title: '<?php echo e(substr($image->url, strrpos($image->url, '/') + 1)); ?>',
                value: '<?php echo e($image->url); ?>'
            }<?php if(!$loop->last): ?> , <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    ]
</script>
<script src="<?php echo e(url('assets/js/micropage.js?v=0.1')); ?>"></script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>