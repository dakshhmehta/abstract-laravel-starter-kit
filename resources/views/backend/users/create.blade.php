@extends('kit::backend.layouts.default')

{{-- Page title --}}
@section('title')
Create a User ::
@parent
@stop

{{-- Page content --}}
@section('content')
<div class="page-header">
	<h3>
		Create a New User

		<div class="pull-right">
			<a href="{{ route('users') }}" class="btn btn-small btn-inverse"><i class="icon-circle-arrow-left icon-white"></i> Back</a>
		</div>
	</h3>
</div>

<!-- Tabs -->
<ul class="nav nav-tabs">
	<li class="active"><a href="#tab-general" data-toggle="tab">General</a></li>
	<li><a href="#tab-permissions" data-toggle="tab">Permissions</a></li>
</ul>

<form class="form-horizontal" method="post" action="" autocomplete="off">
	<!-- CSRF Token -->
	<input type="hidden" name="_token" value="{{ csrf_token() }}" />

	<!-- Tabs Content -->
	<div class="tab-content">
		<!-- General tab -->
		<div class="tab-pane active" id="tab-general">
			<!-- First Name -->
			<div class="form-group {{ $errors->has('first_name') ? 'has-error' : '' }}">
				<label class="control-label col-md-3" for="first_name">First Name</label>
				<div class="col-md-9">
					<input class="form-control" type="text" name="first_name" id="first_name" value="{{ Input::old('first_name') }}" />
					{{ $errors->first('first_name') }}
				</div>
			</div>

			<!-- Last Name -->
			<div class="form-group {{ $errors->has('last_name') ? 'has-error' : '' }}">
				<label class="control-label col-md-3" for="last_name">Last Name</label>
				<div class="col-md-9">
					<input class="form-control" type="text" name="last_name" id="last_name" value="{{ Input::old('last_name') }}" />
					{{ $errors->first('last_name') }}
				</div>
			</div>

			<!-- Email -->
			<div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
				<label class="control-label col-md-3" for="email">Email</label>
				<div class="col-md-9">
					<input class="form-control" type="text" name="email" id="email" value="{{ Input::old('email') }}" />
					{{ $errors->first('email') }}
				</div>
			</div>

			<!-- Password -->
			<div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
				<label class="control-label col-md-3" for="password">Password</label>
				<div class="col-md-9">
					<input type="password" class="form-control" name="password" id="password" value="" />
					{{ $errors->first('password') }}
				</div>
			</div>

			<!-- Password Confirm -->
			<div class="form-group {{ $errors->has('password_confirm') ? 'has-error' : '' }}">
				<label class="control-label col-md-3" for="password_confirm">Confirm Password</label>
				<div class="col-md-9">
					<input type="password" class="form-control" name="password_confirm" id="password_confirm" value="" />
					{{ $errors->first('password_confirm') }}
				</div>
			</div>

			<!-- Activation Status -->
			<div class="form-group {{ $errors->has('activated') ? 'has-error' : '' }}">
				<label class="control-label col-md-3" for="activated">User Activated</label>
				<div class="col-md-9">
					<select name="activated" id="activated">
						<option value="1"{{ (Input::old('activated', 0) === 1 ? ' selected="selected"' : '') }}>@lang('kit::general.yes')</option>
						<option value="0"{{ (Input::old('activated', 0) === 0 ? ' selected="selected"' : '') }}>@lang('kit::general.no')</option>
					</select>
					{{ $errors->first('activated') }}
				</div>
			</div>

			<!-- Groups -->
			<div class="form-group {{ $errors->has('groups') ? 'has-error' : '' }}">
				<label class="control-label col-md-3" for="groups">Groups</label>
				<div class="col-md-9">
					<select class="form-control" name="groups[]" id="groups[]" multiple="multiple">
						@foreach ($groups as $group)
						<option value="{{ $group->id }}"{{ (in_array($group->id, $selectedGroups) ? ' selected="selected"' : '') }}>{{ $group->name }}</option>
						@endforeach
					</select>

					<span class="help-block">
						Select a group to assign to the user, remember that a user takes on the permissions of the group they are assigned.
					</span>
				</div>
			</div>
		</div>

		<!-- Permissions tab -->
		<div class="tab-pane" id="tab-permissions">
			<div class="form-group">
				<div class="col-md-9">

					@foreach ($permissions as $area => $permissions)
					<fieldset>
						<legend>{{ $area }}</legend>

						@foreach ($permissions as $permission)
						<div class="form-group">
							<label class="form-group">{{ $permission['label'] }}</label>

							<div class="radio inline">
								<label for="{{ $permission['permission'] }}_allow" onclick="">
									<input type="radio" value="1" id="{{ $permission['permission'] }}_allow" name="permissions[{{ $permission['permission'] }}]"{{ (array_get($selectedPermissions, $permission['permission']) === 1 ? ' checked="checked"' : '') }}>
									Allow
								</label>
							</div>

							<div class="radio inline">
								<label for="{{ $permission['permission'] }}_deny" onclick="">
									<input type="radio" value="-1" id="{{ $permission['permission'] }}_deny" name="permissions[{{ $permission['permission'] }}]"{{ (array_get($selectedPermissions, $permission['permission']) === -1 ? ' checked="checked"' : '') }}>
									Deny
								</label>
							</div>

							@if ($permission['can_inherit'])
							<div class="radio inline">
								<label for="{{ $permission['permission'] }}_inherit" onclick="">
									<input type="radio" value="0" id="{{ $permission['permission'] }}_inherit" name="permissions[{{ $permission['permission'] }}]"{{ ( ! array_get($selectedPermissions, $permission['permission']) ? ' checked="checked"' : '') }}>
									Inherit
								</label>
							</div>
							@endif
						</div>
						@endforeach

					</fieldset>
					@endforeach

				</div>
			</div>
		</div>
	</div>

	<!-- Form Actions -->
	<div class="form-group">
		<div class="col-md-9">
			<a class="btn btn-link" href="{{ route('users') }}">Cancel</a>

			<button type="reset" class="btn">Reset</button>

			<button type="submit" class="btn btn-success">Create User</button>
		</div>
	</div>
</form>
@stop
