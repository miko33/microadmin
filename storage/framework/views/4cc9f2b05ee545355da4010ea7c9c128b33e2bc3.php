<?php $__env->startSection('widget-body'); ?>
<div class="widget-list">
    <div class="row">
        <div class="col-md-12 widget-holder widget-full-content border-all px-0">
            <div class="widget-bg">
                <div class="widget-body clearfix">
                    <div class="row no-gutters">
                        <div class="col-12 mail-inbox">
                            <div class="mail-inbox-header">
                                <div class="mail-inbox-tools d-flex align-items-center">
                                    <h5 class="my-auto">Footer Button List</h5>
                                </div>
                                <!-- /.mail-inbox-tools -->
                                <div class="flex-1"></div>
                                <?php if(App\General::page_access(Auth::user()->group_id, 'microsite', 'create')): ?>
                                <div class="d-none d-sm-block text-right">
                                    <a class="create btn btn-sm btn-color-scheme px-4 h6 my-0 fs-16 fw-500" data-type="post" data-url="<?php echo e(route('createfooter', $microsite->hostname)); ?>"  href="javascript:void(0);">Create New Footer Button</a>
                                </div>
                                <?php endif; ?>

                            </div>
                            <content-index>
                            <!-- /.mail-inbox-header -->
                                <div class="px-4">
                                    <table class="mail-list contact-list table-responsive" id="footer-btn-tbl">
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th style="text-align: center">Button Title</th>
                                                <th style="text-align: center">URL</th>
                                                <th style="text-align: center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                    <!-- /.contact-list -->
                                </div>
                                <!-- /.px-4 -->
                            </content-index>
                            <content-form style="display: none;">
                                <div class="px-4" style="padding-top: 10px">    
                                    <form id="general-form">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="title">Title</label>
                                                <input type="text" id="title" name="title" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="url">Url</label>
                                                <input type="text" id="url" name="url" class="form-control" placeholder="http://example.com">
                                            </div>
                                        </div>
            
                                        <div class="form-actions btn-list">
                                            <button class="btn btn-success" type="submit">Submit</button>
                                            <button class="cancel btn btn-outline-default" type="button">Cancel</button>
                                        </div>
                                    </form>
                                </div>
        
                            </content-form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /.widget-list -->
<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>
<script>
    var footer_buttons_url = '<?php echo e(route('footer', $microsite->hostname)); ?>';
    var delete_footer_url = '<?php echo e(route('deletefooter', [$microsite->hostname, ''])); ?>';
    var edit_footer_url = '<?php echo e(route('updatefooter', [$microsite->hostname, ''])); ?>';
</script>
<script src="<?php echo e(url('assets/js/edit-footerbuttons.js?v=0.1')); ?>"></script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>