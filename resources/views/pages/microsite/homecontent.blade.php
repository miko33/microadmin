@extends('layouts.app')
@section('widget-body')
@php
    $default_color = 'FFFFFF';
    if($microsite->template_id == 1)
        $default_color = '60bb46';
@endphp
<script src="{{ url('js/jscolor.js') }}"></script>
<div class="widget-list">
    <div class="row no-gutters">
        <div class="col mail-inbox">
            <div class="row">
                <div class="col-12">
                    <label for="contentTitle">Content Title</label>
                    <div class="form-group d-flex">
                        <input type="text" id="contentTitle" name="contentTitle" value="{{@$option->title}}" class="form-control">
                        <button type="button" class="btn btn-md btn-success" id="save_page" style="padding: 0.46rem 0.5em;">Save</button>
                    </div>
                </div>
                <div class="col-12 mb-2">
                    <label for="pageContent">Content Information</label>
                    <textarea id="pageContent">{{@$option->info}}</textarea>
                    <input name="image" type="file" id="upload" style="display: none;">
                    <input type="hidden" name="site_id" id="site_id" value="{{$microsite->id}}">
                    <input type="hidden" name="site_template" id="site_template" value="{{$microsite->template_id}}">
                </div>
                @if ($microsite->template_id == 3)
                    <div class="col-12">
                        <label for="contentTitle2">Content Title 2</label>
                        <div class="form-group d-flex">
                            <input type="text" id="contentTitle2" name="contentTitle2" value="{{@$option->title2}}" class="form-control">
                        </div>
                    </div>
                @else
                    @if ($microsite->template_id != 4 && $microsite->template_id != 5)
                        <div class="col-12">
                            <label for="contentSubtitle">Content Subtitle</label>
                            <div class="form-group">
                                <input type="text" id="contentSubtitle" name="contentSubtitle" value="{{@$option->subtitle}}" class="form-control">
                            </div>
                        </div>
                    @elseif ($microsite->template_id == 5)
                        <div class="col-12">
                            <label for="contentFooter">Content Footer</label>
                            <div class="form-group d-flex">
                                <input type="text" id="contentFooter" name="contentFooter" value="{{@$option->Footer}}" class="form-control">
                            </div>
                        </div>
                    @endif
                @endif
                @if ($microsite->template_id == 6)
                    <div class="col-12">
                        <label for="apiUrl">API URL TO FETCH LINKS</label>
                        <br/>
                        <div class="form-group">
                           <input type="text" name="apiUrl" id="apiUrl" value="{{@$option->api_link}}" class="form-control">
                        </div>
                    </div>
                @endif
                @if ($microsite->template_id != 2 && $microsite->template_id != 4)
                <div class="col-12">
                    <label for="contentTitle">Color Scheme</label>
                    <div class="form-group">
                        <input type="text" class="form-control jscolor" id="colorscheme" value="{{@$option->colorscheme ?: $default_color}}">
                    </div>
                </div>
                @endif
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
                @if ($microsite->template_id == 1 && $microsite->game->name != 'dewabet')
                    <div class="col-12">
                        <div class="form-group mb-3">
                            <div class="checkbox checkbox-primary">
                                <label class="">
                                    <input type="checkbox" name="display_play_reg_btn" value="1" id="display_play_reg_btn" {{@$option->display_play_reg_btn == 0 && !is_null(@$option->display_play_reg_btn) ? '' : 'checked' }}> <span class="label-text">Display Play Now / Register Button</span>
                                  </label>
                                </div>
                                <!-- /.checkbox -->
                              </div>
                            </div>
                @endif
                @if ($microsite->template_id == 2)
                    <div class="col-12">
                        <label for="home_image">Home Image</label>
                        <br/>
                        <img src="{{@$option->home_image}}" id="home_image_image" alt="" height="150" class="img img-thumbnail" style="height: 150px; width: auto; margin-bottom: 15px; @if(strlen(@$option->home_image) == 0) display: none; @endif">
                        <div class="form-group">
                            <input type="file" id="home_image" name="home_image" class="form-control">
                            <input type="hidden" id="home_image_url" name="home_image_url" value="{{@$option->home_image}}">
                        </div>
                    </div>
                    <div class="col-12">
                        <label for="home_logo">Home Logo</label>
                        <br/>
                        <img src="{{@$option->home_logo}}" id="home_logo_image" alt="" height="150" class="img img-thumbnail" style="height: 150px; width: auto; margin-bottom: 15px; @if(strlen(@$option->home_logo) == 0) display: none; @endif">
                        <div class="form-group">
                            <input type="file" id="home_logo" name="home_logo" class="form-control">
                            <input type="hidden" id="home_logo_url" name="home_logo_url" value="{{@$option->home_logo}}">
                        </div>
                    </div>
                    <div class="col-12">
                        <label for="footerText">Footer Text</label>
                        <div class="form-group">
                            <textarea id="footerText" name="footerText" class="form-control">{!! @$option->footer_text !!}</textarea>
                        </div>
                    </div>
                @endif
                @if ($microsite->template_id == 3)
                    <div class="col-12">
                        <label for="videoTutorial">Video Tutorial URL</label>
                        <div class="form-group">
                            <input type="text" id="videoTutorial" name="videoTutorial" value="{{@$option->video_url}}" class="form-control">
                        </div>
                    </div>
                    <div class="col-12">
                        <label for="pageDescription">Content Description</label>
                        <div class="form-group">
                            <textarea id="pageDescription" name="pageDescription" class="form-control">{!! @$option->description !!}</textarea>
                        </div>
                    </div>
                @endif
                @if ($microsite->template_id == 4)
                    <div class="col-12">
                        <label for="home_logo">Home Logo</label>
                        <br/>
                        <img src="{{@$option->home_logo}}" id="home_logo_image" alt="" height="150" class="img img-thumbnail" style="height: 150px; width: auto; margin-bottom: 15px; @if(strlen(@$option->home_logo) == 0) display: none; @endif">
                        <div class="form-group">
                            <input type="file" id="home_logo" name="home_logo" class="form-control">
                            <input type="hidden" id="home_logo_url" name="home_logo_url" value="{{@$option->home_logo}}">
                        </div>
                    </div>
                @endif
                @if ($microsite->template_id == 4)
                    <div class="col-12">
                        <label for="contentTitleBottom">Content Title (Bottom)</label>
                        <div class="form-group d-flex">
                            <input type="text" id="contentTitleBottom" name="contentTitleBottom" value="{{@$option->titleBottom}}" class="form-control">
                        </div>
                    </div>
                    <div class="col-12">
                        <label for="pageDescriptionBottom">Content Description (Bottom)</label>
                        <div class="form-group">
                            <textarea id="pageDescriptionBottom" name="pageDescriptionBottom" class="form-control">{!! @$option->descriptionBottom !!}</textarea>
                        </div>
                    </div>
                @endif
                @if ($microsite->template_id == 5)
                <div class="col-12">
                    <label for="home_logo">Image Conte</label>
                    <br/>
                    <img src="{{@$option->home_logo}}" id="home_logo_image" alt="" height="150" class="img img-thumbnail" style="height: 150px; width: auto; margin-bottom: 15px; @if(strlen(@$option->home_logo) == 0) display: none; @endif">
                    <div class="form-group">
                        <input type="file" id="home_logo" name="home_logo" class="form-control">
                        <input type="hidden" id="home_logo_url" name="home_logo_url" value="{{@$option->home_logo}}">
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group mb-3">
                        <div class="checkbox checkbox-primary">
                            <label class="">
                                <input type="checkbox" name="display_play_reg_btn" value="1" id="display_play_reg_btn" {{@$option->display_play_reg_btn == 0 && !is_null(@$option->display_play_reg_btn) ? '' : 'checked' }}> <span class="label-text">Display Play Now / Register Button</span>
                              </label>
                            </div>
                          </div>
                        </div>
                @endif
            </div>
        </div>
    </div>
	<!-- /.row -->
</div>
<!-- /.widget-list -->
@endsection
@push('scripts')
<script>
    var hostname = "{{$microsite->hostname}}";
    var uploadImageRoute = "{{route('uploadimage')}}";
    var updateHomeContentRoute = "{{route('updateHomeContent', [$microsite->hostname])}}";
    var imagelist = [
        @foreach($microsite->images()->get() as $image)
            {
                title: '{{ substr($image->url, strrpos($image->url, '/') + 1) }}',
                value: '{{ $image->url }}'
            }@if(!$loop->last) , @endif
        @endforeach
    ]
</script>
<script src="{{ url('assets/js/edit-homecontent.js?v=0.6') }}"></script>
@endpush
