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
                    <div class="d-none d-sm-block text-right">
                        <a class="btn btn-sm btn-color-scheme px-4 h6 my-0 fs-16 fw-500" id="createNewMenu" href="javascript:void(0);">Create New Menu</a>
                    </div>
                </div>
                <!-- /.mail-inbox-header -->
                <div class="px-4">
                    <table class="mail-list contact-list table-responsive" id="video-list">
                        <thead>
                            <tr>
                                <th></th>
                                <th>No.</th>
                                <th>Menu Title</th>
                                <th>URL</th>
                                <th>Created At</th>
                                <th>Status</th>
                                <th style="text-align: center">Action</th>
                            </tr>
                        </thead>
                        <tbody class="table-hover" id="menu-container">

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
