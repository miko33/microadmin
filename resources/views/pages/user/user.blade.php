@extends('layouts.app')

@section('widget-body')
<div class="widget-list">
	<div class="row">
		<div class="widget-holder col-lg-8 col-md-12 col-sm-12 col-xs-12">
			<div class="widget-bg">
				<div class="widget-heading widget-heading-border">

					<h5 class="widget-title">User</h5>
					@if (App\General::page_access(Auth::user()->group_id, 'user', 'create'))
					<div class="widget-actions">
						<a class="create btn btn-sm btn-primary ml-1" href="javascript:void(0);" data-callback="dataTable" data-type="post" data-url="{{ url('users') }}">Create New</a>
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

							<div class="row">
								<div class="col-lg-6">
									<div class="col-lg-6">
										<div class="form-group">
											<label for="inputName">Name</label>
											<input type="text" id="inputName" name="name" class="form-control" placeholder="Name" required />
										</div>
									</div>

									<div class="col-lg-12 row">
										<div class="col-lg-6">
											<div class="form-group">
												<label for="inputEmail">Email</label>
												<input type="email" id="inputEmail" name="email" class="form-control" placeholder="Email" required />
											</div>
										</div>

										<div class="col-lg-6">
											<div class="form-group">
												<label for="inputUsername">Username</label>
												<input type="text" id="inputUsername" name="username" class="form-control" placeholder="Username" required />
											</div>
										</div>
									</div>

									<div class="col-lg-12 row">
										<div class="col-lg-6">
											<div class="form-group">
												<label for="inputPassword">Password</label>
												<input type="password" id="inputPassword" name="password" class="form-control" placeholder="Password" required />
											</div>
										</div>

										<div class="col-lg-6">
											<div class="form-group">
												<label for="inputConfirmPassword">Confirm Password</label>
												<input type="password" id="inputConfirmPassword" name="password_confirmation" class="form-control" placeholder="Confirm Password" required />
											</div>
										</div>
									</div>

									<div class="col-lg-6">
										<div class="form-group">
											<label for="inputPasscode">Passcode</label>
											<input type="password" id="inputPasscode" name="passcode" class="form-control" placeholder="Passcode" required />
										</div>
									</div>
								</div>

								<div class="col-lg-6">
									<div class="col-lg-6">
										<div class="form-group">
											<label for="selectDivision" class="form-control-label">Division</label>
											<select class="selectpicker form-control" id="selectDivision" name="division[]" multiple="multiple" data-live-search="true" data-style="btn btn-default">
												@foreach ($divisions as $division)
													<option value="{{ $division->id }}" />{{ ucfirst($division->name) }}
												@endforeach
											</select>
										</div>
									</div>

									<div class="col-lg-6">
										<div class="form-group">
											<label for="selectUserGroup" class="form-control-label">User Group</label>
											<select class="selectpicker form-control" id="selectUserGroup" name="group_id" data-live-search="true" data-style="btn btn-default">
												<option selected disabled></option>
												@foreach ($user_groups as $user_group)
													<option value="{{ $user_group->id }}" />{{ ucwords($user_group->name) }}
												@endforeach
											</select>
										</div>
									</div>
								</div>
							</div>

							<div class="form-actions btn-list">
								<button class="btn btn-success" type="submit">Submit</button>
								<button class="cancel btn btn-outline-default" type="button">Cancel</button>
							</div>
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

@endpush