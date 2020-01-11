<content-index>
    <div class="row no-gutters">
            <div class="col-12 mail-inbox">
                <div class="mail-inbox-header">
                    <div class="mail-inbox-tools d-flex align-items-center">
                        <h5 class="my-auto">Menu List</h5>
                        <div class="row no-gutters mr-l-20">
                            <div class="col-9">
                            <input type="text" id="searchInput-menu" name="searchInput" class="form-control" placeholder="Search...">
                            </div>
                            <div class="col-3">
                            <button type="button" class="btn btn-md btn-primary" id="search-menu" name="search" style="padding: 0.46rem 0.5em;">Search</button>
                            </div>
                        </div>
                    </div>
                    <!-- /.mail-inbox-tools -->
                    <div class="flex-1"></div>
                    <?php if(App\General::page_access(Auth::user()->group_id, 'microsite', 'create')): ?>
                    <div class="d-none d-sm-block text-right">
                        <button class="btn btn-sm btn-color-scheme btn-xl px-4 h6 my-0 fs-16 fw-500" id="order-menu-btn" href="javascript:void(0);">Reorder Menu</button>
                        <a class="btn btn-sm btn-color-scheme px-4 h6 my-0 fs-16 fw-500" id="createNewMenu" href="javascript:void(0);">Create New Menu</a>
                    </div>
                    <?php endif; ?>

                </div>
                <!-- /.mail-inbox-header -->
                <div class="px-4">
                    <table class="mail-list contact-list table-responsive" id="video-list">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th style="text-align: center">Menu Title</th>
                                <th style="text-align: center">URL</th>
                                <th>Created At</th>
                                <th>Status</th>
                                <th style="text-align: center">Action</th>
                            </tr>
                        </thead>
                        <tbody id="menu-container">
                        </tbody>
                    </table>
                    <!-- /.contact-list -->
                </div>
                <!-- /.px-4 -->
                <!-- Mails Navigation -->
                <div class="row px-4 mt-5 mb-5" id="menu-pagination-control">
                    <div class="col-7 text-muted mt-1"><span class="headings-font-family pagination-result"></span>
                    </div>
                    <div class="col-5">
                        <div class="btn-group float-right pagination-controls"></div>
                    </div>
                </div>
            </div>
    </div>
</content-index>

<content-index id="menu-order" style="display:none">

    <div class="row no-gutters">
        <div class="col-12 mail-inbox">
            <div class="mail-inbox-header">
                <div class="mail-inbox-tools d-flex align-items-center">
                    <h5 class="my-auto">Menu Order</h5>
                </div>
            </div>
            <div class="px-4">
                <div class="dd" id="dd">
                    <ol class="dd-list" id="most_parent_ol">
                        <?php $__currentLoopData = $microsite->menuOrder; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $menu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li class="dd-item" data-id="<?php echo e($menu['id']); ?>">
                            <div class="dd-handle"><?php echo e($menu['title']); ?></div>
                            <?php if(array_key_exists("children", $menu) && is_array($menu['children'])): ?>
                            <ol class="dd-list">
                                <?php $__currentLoopData = $menu['children']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $keyChild => $child): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li class="dd-item" data-id="<?php echo e($child['id']); ?>">
                                        <div class="dd-handle"><?php echo e($child['title']); ?></div>
                                    </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ol>
                            <?php endif; ?>
                        </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ol>
                </div>
            </div>
            <div class="row px-4 mt-5">
                <div class="col d-flex mt-5">
                    <a class="btn btn-xs btn-primary px-2 my-0 fs-14 fw-450 ml-auto" id="cancelMenuOrder" href="javascript:void(0);">Cancel</a>
                    <a class="btn btn-xs btn-success px-2 my-0 fs-14 fw-450 ml-1" id="saveMenuOrder" href="javascript:void(0);" style="display: none;">Save</a>
                </div>
            </div>
        </div>
    </div>

</content-index>
