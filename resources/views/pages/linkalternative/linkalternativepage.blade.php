@extends('layouts.app')
@section('widget-body')
<div class="widget-list">
    <div class="row no-gutters">
        <div class="col mail-inbox">
            <form action="#" id="formPage">
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label for="pageTitle">Page Title</label>
                            <div class="input-group">
                                <input type="text" id="pageTitle" name="title" value="@if(!empty($page)) {{$page->title}} @endif" class="form-control">
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-md btn-success" id="save_page" data-type="{{(!empty($page)) ? 'update' : 'store' }}" data-slug="{{(!empty($page)) ? $page->slug : '' }}" name="search" style="padding: 0.46rem 0.5em;">Save</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label for="pageSlug">Page Slug</label>
                            <input type="text" id="pageSlug" name="newslug" value="@if(!empty($page)) {{$page->slug}} @endif" class="form-control">
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label for="pageMetaKeywords">Meta Keywords</label>
                            <input type="text" id="pageMetaKeywords" name="meta_keywords" value="@if(!empty($page)) {{$page->meta_keywords}} @endif" class="form-control">
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label for="pageMetaDescription">Meta Description</label>
                            <textarea id="pageMetaDescription" name="meta_description" class="form-control">@if(!empty($page)) {{$page->meta_description}} @endif</textarea>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label for="pageHead">Page Head</label>
                            <textarea id="pageHead" class="form-control">@if(!empty($page)) {{@$page->head}} @endif</textarea>
                        </div>
                    </div>
                    <div class="col-12">
                        <label for="pageContent">Page Content</label>
                        <textarea id="pageContent" name="content">@if(!empty($page)) {{$page->content}} @endif</textarea>
                        <input name="image" type="file" id="upload" style="display: none;">
                        <input type="hidden" name="site_id" id="site_id" value="{{$linkalternative->id}}">
                    </div>
                </div>
            </form>
        </div>
    </div>
	<!-- /.row -->
</div>
<!-- /.widget-list -->
@endsection

@push('scripts')
<script>
    var hostname = "{{$linkalternative->hostname}}";
    var uploadImageRoute = "{{route('linkAlternative.uploadimage')}}";
    var storePage = "{{route('linkAlternative.storepage', [$linkalternative->hostname])}}";
    var updatePage = "{{route('linkAlternative.updatepage', [$linkalternative->hostname])}}";
    var redirectTo = '{{route('linkAlternative', $linkalternative->hostname)}}';
    var image_list = [
        @foreach($linkalternative->images()->get() as $image)
            {
                title: '{{ substr($image->url, strrpos($image->url, '/') + 1) }}',
                value: '{{ $image->url }}'
            }@if(!$loop->last) , @endif
        @endforeach
    ]
</script>
<script src="{{ url('assets/js/linkalternativepage.js?v=0.2') }}"></script>
@endpush