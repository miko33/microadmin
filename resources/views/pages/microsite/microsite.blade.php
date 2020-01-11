@extends('layouts.app')

@section('widget-body')
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
                                        <button class="btn btn-xs btn-color-scheme px-2 my-0 fs-14 fw-450" id="edit-microsite">Edit</button>
                                        <button class="btn btn-xs btn-default px-2 my-0 fs-14 fw-450" id="cancel-edit-microsite" style="display:none">Cancel</button>
                                    </div>

                                </div>
								<form action="{{ route('microsite.update', $microsite->hostname) }}" id="edit-microsite-form">
                                	<div class="row p-auto m-1 ">
										<input type="hidden" name="_method" value="POST"/>
										<input type="hidden" name="id" value="{{ $microsite->id }}"/>
										<div class="col-12">
											<div class="form-group">
												<label for="hostname">Hostname</label>
												<input type="text" id="hostname" name="hostname" value="{{$microsite->hostname}}" data-hostname="{{$microsite->hostname}}" class="form-control" disabled>
											</div>
										</div>
										<div class="col-12">
											<div class="form-group">
												<label for="title">Home Title</label>
												<input type="text" id="title" name="title" value="{{$microsite->home_title}}" class="form-control" disabled>
											</div>
										</div>
										<div class="col-12">
											<div class="form-group">
												<label for="keyword">Meta Keyword</label>
												<textarea class="form-control" id="keywords" name="keywords" rows="3" disabled>{{$microsite->meta_keywords}}</textarea>
											</div>
										</div>
										<div class="col-12">
											<div class="form-group">
												<label for="description">Meta Description</label>
												<textarea class="form-control" id="inputDescription" name="description" rows="3" disabled>{{$microsite->meta_description}}</textarea>
											</div>
										</div>
										<div class="col-12">
											<div class="form-group">
												<label for="inputCustomTag">Custom Tags</label>
												<textarea class="form-control" id="inputCustomTag" name="custom_tag" rows="3" disabled>{{$microsite->custom_tag}}</textarea>
											</div>
										</div>
										<div class="col-12">
											<div class="form-group">
												<label for="inputStatus" class="d-block mb-3">Blog</label>
												<label class="switch"><input type="checkbox" id="togBtn" disabled><div class="slider round"></div></label>
												<input type="hidden" id="blogstatus"  value="{{$microsite->blogs}}">
											</div>
										</div>
										<div class="col-12">
											<button type="reset" class="btn btn-xs btn-color-scheme px-2 my-0 fs-14 fw-450" href="javascript:void(0);" style="display:none">Reset</button>
											<button class="btn btn-xs btn-color-scheme px-2 my-0 fs-14 fw-450" href="javascript:void(0);" id="edit-microsite-save-btn" style="display:none">Save</button>
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

										<div class="col-lg-12">
											<a class="btn btn-xs btn-color-scheme pull-right" href="javascript:;" id="clear-cache"><span class="fa fa-trash"></span>&nbsp;Clear Cache</a>
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
						            @if (App\General::page_access(Auth::user()->group_id, 'microsite', 'create'))
						            <div class="d-none d-sm-block text-right">
													@if(!$microsite->blog->isEmpty())
													<a class="btn btn-sm btn-color-scheme btn-xl px-4 h6 my-0 fs-16 fw-500 blog"  href="{{url('microsites/'.$microsite->hostname.'/blog/'.$microsite->blog[0]->id_blog)}}">Manage Blog</a>
													@else
													<a class="btn btn-sm btn-color-scheme btn-xl px-4 h6 my-0 fs-16 fw-500 blog" href="javascript:;" id="createblog">Manage Blog</a>
													@endif
													<a class="btn btn-sm btn-color-scheme btn-xl px-4 h6 my-0 fs-16 fw-500" href="{{url('microsites/'.$microsite->hostname.'/images')}}">Manage Images</a>
						            	<a class="btn btn-sm btn-color-scheme btn-xl px-4 h6 my-0 fs-16 fw-500" href="{{url('microsites/'.$microsite->hostname.'/createpage')}}">Create New Page</a>
						            </div>
						            @endif
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
						@include('pages.microsite._menulist')
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
                                            @if($microsite->options !== null)
                                                @foreach($microsite->options as $option)
                                                <tr>
                                                    <td>
                                                        <div class="lightbox-gallery" data-toggle="lightbox-gallery" data-type="image" data-effect="fadeInRight">
                                                            <div class="lightbox">
                                                                <span>{{$loop->iteration}}. </span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="contact-list-name">
                                                        <div class="lightbox-gallery ml-3" data-toggle="lightbox-gallery" data-type="image" data-effect="fadeInRight">
                                                            <div class="lightbox">
                                                                <span>{{ ucwords(str_replace('_', ' ', $option->option_name)) }}</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <span class="contact-list-phone d-block">{{$option->created_at}}</span>
                                                    </td>
                                                    <td>
                                                        <span class="badge bg-success-contrast color-success float-right">Active</span>
                                                    </td>
                                                    <td>
                                                        <div class="btn-group float-right">
                                                            <a href="{{ route('microsite.editoption', [$microsite->hostname, $option->option_name]) }}" data-type="{{ $option->option_name }}" class="btn btn-default btn-edit-option">
                                                                <i class="feather feather-edit-2"></i>
															</a>
                                                        </div>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            @else
						        			<tr>
						        				<td>
						        					<h5 class="text-center p-5">
						        						No Data Available
						        					</h5>
						        				</td>
                                            </tr>
                                            @endif
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

<div class="modal fade" id="edit-custom-css" tabindex="-1" role="dialog" aria-hidden="true">
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
					<input type="hidden" name="hostname" value="{{ str_slug($microsite->hostname) }}"/>
					<div class="col-12">
						<div class="form-group">
						<textarea rows="10" class="form-control" id="custom-css">{{ @$microsite->getOptionAttribute('custom_css')->value }}</textarea>
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

<div class="modal fade" id="blogcreate" tabindex="-1" role="dialog" aria-labelledby="createblogLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Blog Option</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form id="blog-form">
					<div class="row p-auto m-1 ">
						<div class="col-12">
							<div class="form-group">
								<label for="menuIsExternal">Title</label>
							<input  id="blogTitle" name="title"  class="form-control">
							</div>
						</div>
						<div class="col-12">
							<div class="form-group">
								<label for="menuTitle">Meta Keyword</label>
								<input  id="blogKeyword" name="keyword"  class="form-control">
							</div>
						</div>
						<div class="col-12">
							<div class="form-group">
								<label for="pageUrl">Meta Description</label>
								<input  id="blogDescriptions" value="" name="description"  class="form-control">
							</div>
						</div>
						<div class="col-12">
							<div class="form-group">
								<label for="menuUrl">Custom Tags</label>
								<textarea id="blogCustomTag" name="custom_tag" rows="4" class="form-control"></textarea>
							</div>
						</div>
						<input type="hidden" id="site_id" value="">
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
				<button type="submit" class="btn btn-success" id="storeBlog">Save</button>
			</div>
		</div>
	</div>
</div>
@endsection

@push('scripts')

<script>
var uploadImageRoute = "{{route('uploadimage')}}";
var microsite_route = '{{ route('microsite', '') }}';
var microsite_pages = '{{ route('microsite.pages', $microsite->hostname) }}';
var microsite_menus = '{{ route('microsite.menus', $microsite->hostname) }}';
var list_menus = '{{ route('list.menu', $microsite->hostname) }}'
var edit_page_url = '{{route('editpage', [$microsite->hostname, ''])}}';
var delete_page_url = '{{route('microsite.deletepage', [$microsite->hostname, ''])}}';
var delete_menu_url = '{{route('microsite.deletemenu', [$microsite->hostname, ''])}}';
var storeMenu_url = "{{route('storeMenu', [$microsite->hostname])}}";
var updateMenu_url = "{{route('updateMenu', [$microsite->hostname])}}";
var getOrdered_menu_url = '{{route('getOrderedMenu', $microsite->hostname )}}';
var reorder_menu_url = '{{route('reorderMenu', $microsite->hostname )}}';
var custom_css_url = '{{route('saveCustomCss', $microsite->hostname )}}';
var fetch_all_pages_url = '{{route('fetchAllPages', $microsite->hostname )}}';
var clear_cache_url = '{{route('clearCache', $microsite->hostname )}}';
var storeBlog_url = "{{route('storeBlog', [$microsite->hostname])}}";

var
	default_hostname = '{{ $microsite->hostname }}',
	default_title = '{{ $microsite->home_title }}',
	default_keywords = '{{ $microsite->meta_keywords }}',
	default_description = '{{ $microsite->meta_description }}',
	default_custom_css = $("#custom-css").val(),
	default_blogs ='{{$microsite->blogs}}'
;
</script>
<script src="{{ url('assets/js/microsite-info.js?v=0.1') }}"></script>
@endpush
