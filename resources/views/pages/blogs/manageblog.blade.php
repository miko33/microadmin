@extends('layouts.app')

@section('widget-body')
<!-- <style media="screen">
input[type=number]::-webkit-inner-spin-button,
input[type=number]::-webkit-outer-spin-button {
	-webkit-appearance: none;
	-moz-appearance: none;
	appearance: none;
	margin: 0;
}
</style> -->
<div class="widget-list">
	<div class="row">
		<div class="col-md-12 widget-holder widget-full-content border-all px-0">
			<div class="widget-bg">
				<div class="widget-body clearfix">
					<content-index>
						<div class="row no-gutters">
						    <div class="col-md-3 mail-sidebar">
                  <div class="mail-inbox-header">
                      <div class="mail-inbox-tools d-flex align-items-center">
                          <h5 class="my-auto">{{$microsite->hostname}}</h5>
                      </div>
											<div class="flex-1"></div>
                      <div class="d-none d-sm-block text-right">
                          <button class="btn btn-xs btn-color-scheme px-2 my-0 fs-14 fw-450" id="edit-blog">Edit</button>
                          <button class="btn btn-xs btn-default px-2 my-0 fs-14 fw-450" id="cancel-edit-blog" style="display:none">Cancel</button>
                      </div>
                  </div>
									<form action="#" id="edit-blog-form">
                	<div class="row p-auto m-1 ">
										<div class="col-12">
											<div class="form-group">
												<label for="title">Title</label>
												<input type="text" id="title" name="title" value="{{$blogs->title}}" class="form-control" disabled>
											</div>
										</div>
										<div class="col-12">
											<div class="form-group">
												<label for="keyword">Meta Keyword</label>
												<textarea class="form-control" id="keywords" name="keywords" rows="3" disabled>{{$blogs->meta_keywords}}</textarea>
											</div>
										</div>
										<div class="col-12">
											<div class="form-group">
												<label for="description">Meta Description</label>
												<textarea class="form-control" id="inputDescription" name="description" rows="3" disabled>{{$blogs->meta_description}}</textarea>
											</div>
										</div>
										<div class="col-12">
											<div class="form-group">
												<label for="inputCustomTag">Custom Tags</label>
												<textarea class="form-control" id="inputCustomTag" name="custom_tag" rows="3" disabled>{{$blogs->custom_tag}}</textarea>
											</div>
										</div>
										<div class="col-12">
											<div class="form-group">
												<label for="inputCustomTag">Custom Tags</label>
												<textarea class="form-control" id="inputCustomTag" name="custom_tag" rows="3" disabled>{{$blogs->id_menu}}</textarea>
											</div>
										</div>
										<div class="col-12">
											<button type="reset" class="btn btn-xs btn-color-scheme px-2 my-0 fs-14 fw-450" href="javascript:void(0);" style="display:none">Reset</button>
											<button class="btn btn-xs btn-color-scheme px-2 my-0 fs-14 fw-450" href="javascript:void(0);" id="edit-blog-save-btn" style="display:none">Save</button>
										</div>
									</div>
									</form>
						    </div>
						    <!-- /.mail-sidebar -->
						    <!-- Mails List -->
							 <!-- tessst -->
							 <div class="col-lg-9 col-md-9 mail-inbox">
									 <div class="mail-inbox-header">
										 <div class="mail-inbox-tools d-flex align-items-center">
									 <h5 class="my-auto">Content List</h5>
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
											 @if (App\General::page_access(Auth::user()->group_id, 'microsite', 'create'))
											 <div class="d-none d-sm-block text-right">
												 <a class="btn btn-sm btn-color-scheme btn-xl px-4 h6 my-0 fs-16 fw-500" href="#">Manage Images</a>
										     <a class="btn btn-sm btn-color-scheme btn-xl px-4 h6 my-0 fs-16 fw-500" href="{{url('microsites/'.$microsite->hostname.'/blog/'.$blogs->id_blog.'/content')}}">Create Content</a>
											 </div>
											 @endif

									 </div>
									 <!-- /.mail-inbox-header -->
									 <div class="px-4">
										 <table class="mail-list contact-list table-responsive" id="video-list">
																			 <thead>
																					 <tr>
																							 <th>No.</th>
																							 <th>Page Title</th>
																							 <th style="color: #6931e7;">Page Slug</th>
																							 <th>Feature Image</th>
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
								@include('pages.blogs._blogmenu')
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


<!-- //Modal CREATE LIST MENU -->
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
						<input type="hidden" name="id" value="{{ $microsite->id }}"/>
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
							<div class="row">
								<div class="col-12">
									<div class="form-group">
										<label for="menuTitle">Menu Title</label>
										<input type="menuText" id="menuTitle" name="title" value="" class="form-control">
									</div>
								</div>
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
@endsection
@push('scripts')
<script>
var blog_page = '{{ route('contentblog',$blogs->id_blog) }}';
var blog_menus = '{{ route('list.menu',$blogs->id_blog) }}';
var editblogpage = '{{ route('editblogpage',[$microsite->hostname, $blogs->id_blog, ''] )}}';
var delete_content = '{{ route('deleteblog', [$microsite->hostname,$blogs->id_blog, ''] )}}';
var delete_list = '{{ route('deletelist', [$blogs->id_blog, ''] )}}';
var fetch_all_content = '{{ route('fetchAllContent', [$blogs->id_blog] ) }}';
var fetch_all_menu = '{{ route('fetchAllMenu', [$blogs->id_blog] ) }}';
var storeMenus = '{{ route('createMenus', [$blogs->id_blog] ) }}';
var upadteMenus = '{{ route('updateMenus', [$blogs->id_blog] ) }}';


</script>
<script src="{{ url('assets/js/blog-option.js?v=0.1') }}"></script>
@endpush
