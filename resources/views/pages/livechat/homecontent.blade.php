@extends('layouts.app')
@section('widget-body')
<div class="widget-list">
    <div class="row no-gutters">
        <div class="col mail-inbox">
            <div class="row">
                <div class="col-12">
                    <label for="apiUrl">API URL to Fetch Links</label>
                    <div class="form-group d-flex">
                        <input type="text" id="apiUrl" name="apiUrl" value="{{$option->api_link}}" class="form-control">
                        <button type="button" class="btn btn-md btn-success" id="save_page" style="padding: 0.46rem 0.5em;">Save</button>
                    </div>
                </div>
                <div class="col-12">
                    <label for="title">Title</label>
                    <div class="form-group">
                        <input type="text" id="title" name="title" value="{{@$option->title}}" class="form-control">
                    </div>
                </div>
                <div class="col-12">
                    <label for="footerDescription">Footer Text</label>
                    <div class="form-group">
                        <textarea type="text" id="footerDescription" name="footerDescription" class="form-control">{{$option->footer_text}}</textarea>
                    </div>
                </div>
                <div class="col-12">
                    <label for="favicon">Favicon</label>
                    <br/>
                    <img src="{{@$option->favicon}}" id="favicon_image" alt="" height="30" class="img" style="height: 30px; width: auto; margin-bottom: 15px; @if(strlen(@$option->favicon) == 0) display: none; @endif">
                    <div class="form-group">
                        <input type="file" id="favicon" name="favicon" class="form-control">
                        <input type="hidden" id="favicon_url" name="favicon_url" value="{{@$option->favicon}}">
                    </div>
                </div>
                <div class="col-12">
                    <label for="home_header_logo">Home Header Logo</label>
                    <br/>
                    <img src="{{@$option->home_header_logo}}" id="home_header_logo_image" alt="" height="150" class="img img-thumbnail" style="height: 150px; width: auto; margin-bottom: 15px; @if(strlen(@$option->home_header_logo) == 0) display: none; @endif">
                    <div class="form-group">
                        <input type="file" id="home_header_logo" name="home_header_logo" class="form-control">
                        <input type="hidden" id="home_header_logo_url" name="home_header_logo_url" value="{{@$option->home_header_logo}}">
                    </div>
                </div>
                <div class="col-12">
                    <label for="liveChatUrl">Live Chat Iframe URL</label>
                    <div class="form-group">
                        <textarea type="text" id="liveChatUrl" name="liveChatUrl" class="form-control">{{@$option->livechat_url}}</textarea>
                    </div>
                </div>
                <div class="col-3">
                    <label for="pageTitle">Header Color</label>
                    <div class="form-group">
                        <div class="input-group colorpicker input-has-value" data-plugin-options='{"preferredFormat": "hex"}'>
                            <input type="text" class="form-control" value="{{$option->header_color}}" id="colorPicker1"> <span class="input-group-addon"><i style="background: #ffffff;"></i></span>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <label for="pageTitle">Font Color</label>
                    <div class="form-group">
                        <div class="input-group colorpicker input-has-value" data-plugin-options='{"preferredFormat": "hex"}'>
                            <input type="text" class="form-control" value="{{$option->font_color}}" id="colorPicker2"> <span class="input-group-addon"><i style="background: #ffffff;"></i></span>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <label for="pageTitle">"Main Sekarang" Button Color</label>
                    <div class="form-group">
                        <div class="input-group colorpicker input-has-value" data-plugin-options='{"preferredFormat": "hex"}'>
                            <input type="text" class="form-control" value="{{$option->playnow_color}}" id="colorPicker3"> <span class="input-group-addon"><i style="background: #ffffff;"></i></span>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <label for="pageTitle">"Register" Button Color</label>
                    <div class="form-group">
                        <div class="input-group colorpicker input-has-value" data-plugin-options='{"preferredFormat": "hex"}'>
                            <input type="text" class="form-control" value="{{$option->register_color}}" id="colorPicker4"> <span class="input-group-addon"><i style="background: #ffffff;"></i></span>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <label for="pageContent">Content</label>
                    <textarea id="pageContent">{{$option->content}}</textarea>
                    <input name="image" type="file" id="upload" style="display: none;">
                    <input type="hidden" name="site_id" id="site_id" value="{{$livechat->id}}">
                </div>
            </div>
        </div>
    </div>
	<!-- /.row -->
</div>
<!-- /.widget-list -->
@endsection
@push('scripts')
<script>
    var hostname = "{{$livechat->hostname}}";
    var uploadImageRoute = "{{route('liveChat.uploadimage')}}";
    var updateHomeContentRoute = "{{route('liveChat.updateHomeContent', [$livechat->hostname])}}";
    var image_list = [
        @foreach($livechat->images()->get() as $image)
            {
                title: '{{ substr($image->url, strrpos($image->url, '/') + 1) }}',
                value: '{{ $image->url }}'
            }@if(!$loop->last) , @endif
        @endforeach
    ]
    // $(".colorpicker input").on('blur', function(e) {
    //     const colorString = $(this).val();
    //     $(this).next('.input-group-addon').spectrum("set", colorString);
    //     $(this).next('.input-group-addon').children('i').css("backgroundColor", colorString);
    // })
</script>
<script src="{{ url('assets/js/edit-livechat-homecontent.js?v=0.1') }}"></script>
@endpush