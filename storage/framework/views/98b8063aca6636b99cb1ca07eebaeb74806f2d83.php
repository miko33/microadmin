<?php $__env->startSection('widget-body'); ?>
<div class="widget-list">
    <div class="row no-gutters">
        <div class="col mail-inbox">
            <div class="row">
                <div class="col-12">
                    <label for="apiUrl">API URL to Fetch Links</label>
                    <div class="form-group d-flex">
                        <input type="text" id="apiUrl" name="apiUrl" value="<?php echo e($option->api_link); ?>" class="form-control">
                        <button type="button" class="btn btn-md btn-success" id="save_page" style="padding: 0.46rem 0.5em;">Save</button>
                    </div>
                </div>
                <div class="col-12">
                    <label for="title">Title</label>
                    <div class="form-group">
                        <input type="text" id="title" name="title" value="<?php echo e(@$option->title); ?>" class="form-control">
                    </div>
                </div>
                <div class="col-12">
                    <label for="favicon">Favicon</label>
                    <br/>
                    <img src="<?php echo e(@$option->favicon); ?>" id="favicon_image" alt="" height="30" class="img" style="height: 30px; width: auto; margin-bottom: 15px; <?php if(strlen(@$option->favicon) == 0): ?> display: none; <?php endif; ?>">
                    <div class="form-group">
                        <input type="file" id="favicon" name="favicon" class="form-control">
                        <input type="hidden" id="favicon_url" name="favicon_url" value="<?php echo e(@$option->favicon); ?>">
                    </div>
                </div>
                <div class="col-12">
                    <label for="home_header_logo">Home Header Logo</label>
                    <br/>
                    <img src="<?php echo e(@$option->home_header_logo); ?>" id="home_header_logo_image" alt="" height="150" class="img img-thumbnail" style="height: 150px; width: auto; margin-bottom: 15px; <?php if(strlen(@$option->home_header_logo) == 0): ?> display: none; <?php endif; ?>">
                    <div class="form-group">
                        <input type="file" id="home_header_logo" name="home_header_logo" class="form-control">
                        <input type="hidden" id="home_header_logo_url" name="home_header_logo_url" value="<?php echo e(@$option->home_header_logo); ?>">
                    </div>
                </div>
                <div class="col-12">
                    <label for="instruction_image">Instruction Image</label>
                    <br/>
                    <img src="<?php echo e(@$option->instruction_image_url); ?>" id="instruction_image_image" alt="" height="150" class="img img-thumbnail" style="height: 150px; width: auto; margin-bottom: 15px; <?php if(strlen(@$option->instruction_image_url) == 0): ?> display: none; <?php endif; ?>">
                    <div class="form-group">
                        <input type="file" id="instruction_image" name="instruction_image" class="form-control">
                        <input type="hidden" id="instruction_image_url" name="instruction_image_url" value="<?php echo e(@$option->instruction_image_url); ?>">
                    </div>
                </div>
                <div class="col-12">
                    <label for="footerDescription">Footer Text</label>
                    <div class="form-group">
                        <textarea type="text" id="footerDescription" name="footerDescription" class="form-control"><?php echo e($option->footer_text); ?></textarea>
                    </div>
                </div>
                <div class="col-12">
                    <label for="liveChatCode">Live Chat Code</label>
                    <div class="form-group">
                        <textarea type="text" id="liveChatCode" name="liveChatCode" class="form-control"><?php echo e($option->livechat_code); ?></textarea>
                    </div>
                </div>
                <div class="col-3">
                    <label for="pageTitle">Header Color</label>
                    <div class="form-group">
                        <div class="input-group colorpicker input-has-value" data-plugin-options='{"preferredFormat": "hex"}'>
                            <input type="text" class="form-control" value="<?php echo e($option->header_color); ?>" id="colorPicker1"> <span class="input-group-addon"><i style="background: #ffffff;"></i></span>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <label for="pageTitle">Font Color</label>
                    <div class="form-group">
                        <div class="input-group colorpicker input-has-value" data-plugin-options='{"preferredFormat": "hex"}'>
                            <input type="text" class="form-control" value="<?php echo e($option->font_color); ?>" id="colorPicker2"> <span class="input-group-addon"><i style="background: #ffffff;"></i></span>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <label for="pageTitle">"Main Sekarang" Button Color</label>
                    <div class="form-group">
                        <div class="input-group colorpicker input-has-value" data-plugin-options='{"preferredFormat": "hex"}'>
                            <input type="text" class="form-control" value="<?php echo e($option->playnow_color); ?>" id="colorPicker3"> <span class="input-group-addon"><i style="background: #ffffff;"></i></span>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <label for="pageTitle">"Register" Button Color</label>
                    <div class="form-group">
                        <div class="input-group colorpicker input-has-value" data-plugin-options='{"preferredFormat": "hex"}'>
                            <input type="text" class="form-control" value="<?php echo e($option->register_color); ?>" id="colorPicker4"> <span class="input-group-addon"><i style="background: #ffffff;"></i></span>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <label for="pageContent">Content</label>
                    <textarea id="pageContent"><?php echo e($option->content); ?></textarea>
                    <input name="image" type="file" id="upload" style="display: none;">
                    <input type="hidden" name="site_id" id="site_id" value="<?php echo e($linkalternative->id); ?>">
                </div>
            </div>
        </div>
    </div>
	<!-- /.row -->
</div>
<!-- /.widget-list -->
<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>
<script>
    var hostname = "<?php echo e($linkalternative->hostname); ?>";
    var uploadImageRoute = "<?php echo e(route('linkAlternative.uploadimage')); ?>";
    var updateHomeContentRoute = "<?php echo e(route('linkAlternative.updateHomeContent', [$linkalternative->hostname])); ?>";
    var image_list = [
        <?php $__currentLoopData = $linkalternative->images()->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            {
                title: '<?php echo e(substr($image->url, strrpos($image->url, '/') + 1)); ?>',
                value: '<?php echo e($image->url); ?>'
            }<?php if(!$loop->last): ?> , <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    ]
    // $(".colorpicker input").on('blur', function(e) {
    //     const colorString = $(this).val();
    //     $(this).next('.input-group-addon').spectrum("set", colorString);
    //     $(this).next('.input-group-addon').children('i').css("backgroundColor", colorString);
    // })
</script>
<script src="<?php echo e(url('assets/js/edit-linkalternative-homecontent.js?v=0.1')); ?>"></script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>