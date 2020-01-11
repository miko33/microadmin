@extends('layouts.app')

@section('widget-body')
<div class="widget-list">
	<div class="row">
		<div class="widget-holder col-lg-6 col-md-12 col-sm-12 col-xs-12">
			<div class="widget-bg">
				<div class="widget-heading widget-heading-border">

				<h5 class="widget-title"><a href="{{route('linkAlternativeList')}}?game={{$game->id}}"><strong>{{$game->name}} </strong>Link Alternatives</a></h5>
				@if (App\General::page_access(Auth::user()->group_id, 'game', 'create'))
				<div class="widget-actions">
					<a class="create btn btn-sm btn-primary ml-1" href="javascript:void(0);" data-callback="dataTable" data-type="post" data-url="{{ url('games') }}">Create New Link Alternatiive</a>
				</div>
				@endif

					<!-- /.widget-actions -->
				</div>
				<!-- /.widget-heading -->
				<div class="widget-body">

					<content-index>
						

						<div class="col-lg-12">
							{!! $dataTable->table(['class' => 'table table-responsive w-100']) !!}
						</div>

					</content-index>

					<content-form style="display: none;">

						<form id="general-form">
							<div class="col-lg-6">
								<div class="form-group">
									<label for="inputHostname">Hostname</label>
									<input type="text" id="inputHostname" name="hostname" class="form-control">
								</div>
							</div>
							<div class="col-lg-6">
								<div class="form-group">
									<label for="inputTitle">Title</label>
									<input type="text" id="inputTitle" name="title" class="form-control">
								</div>
							</div>
							<div class="col-lg-6">
								<div class="form-group">
									<label for="inputKeyword">Meta Keyword</label>
									<input type="text" id="inputKeyword" name="keyword" class="form-control">
								</div>
							</div>
							<div class="col-lg-6">
								<div class="form-group">
									<label for="inputDescription">Meta Description</label>
									<input type="text" id="inputDescription" name="description" class="form-control" >
								</div>
							</div>
							<div class="col-lg-6">
								<div class="form-group">
									<label for="inputCustomTag">Custom Tags</label>
									<textarea id="inputCustomTag" name="custom_tag" class="form-control"></textarea>
								</div>
							</div>

							<div class="form-actions btn-list">
								<button class="btn btn-success" type="button" id="linkalternative_submit">Submit</button>
								<button class="cancel btn btn-outline-default" type="button">Cancel</button>
							</div>
							<input type="hidden" id="gameID" value="{{$game->id}}" />
						</form>

					</content-form>

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
@endsection

@push('scripts')

{!! $dataTable->scripts() !!}
<script src="{{ url('assets/js/linkalternative.js?v=0.1') }}"></script>
@endpush