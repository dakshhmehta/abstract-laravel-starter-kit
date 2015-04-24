@extends('frontend/layouts/account')

{{-- Page title --}}
@section('title')
Your Profile
@stop

{{-- Account page content --}}
@section('account-content')
<div class="panel panel-default">
	<div class="panel-heading">
		<h4>Update your Profile</h4>
	</div>
	<div class="panel-body">

		<form method="post" action="" class="form-horizontal" autocomplete="off">
			<!-- CSRF Token -->
			<input type="hidden" name="_token" value="{{ csrf_token() }}" />

			<!-- First Name -->
			<div class="form-group{{ $errors->first('first_name', ' has-error') }}">
				<label class="col-md-4" for="first_name">First Name</label>
				<div class="col-md-8">
					<input class="form-control" type="text" name="first_name" id="first_name" value="{{ Input::old('first_name', $user->first_name) }}" />
					{{ $errors->first('first_name', '<span class="help-block">:message</span>') }}
				</div>
			</div>

			<!-- Last Name -->
			<div class="form-group{{ $errors->first('last_name', ' has-error') }}">
				<label class="col-md-4" for="last_name">Last Name</label>
				<div class="col-md-8">
					<input class="form-control" type="text" name="last_name" id="last_name" value="{{ Input::old('last_name', $user->last_name) }}" />
					{{ $errors->first('last_name', '<span class="help-block">:message</span>') }}
				</div>
			</div>

			<!-- Website URL -->
			<div class="form-group{{ $errors->first('website', ' has-error') }}">
				<label class="col-md-4" for="website">Website URL</label>
				<div class="col-md-8">
					<input class="form-control" type="text" name="website" id="website" value="{{ Input::old('website', $user->website) }}" />
					{{ $errors->first('website', '<span class="help-block">:message</span>') }}
				</div>
			</div>

			<!-- Country -->
			<div class="form-group{{ $errors->first('country', ' has-error') }}">
				<label class="col-md-4" for="country">Country</label>
				<div class="col-md-8">
					<input class="form-control" type="text" name="country" id="country" value="{{ Input::old('country', $user->country) }}" />
					{{ $errors->first('country', '<span class="help-block">:message</span>') }}
				</div>
			</div>

			<!-- Gravatar Email -->
			<div class="form-group{{ $errors->first('gravatar', ' has-error') }}">
				<label class="col-md-4" for="gravatar">Gravatar Email <small>(Private)</small></label>
				<div class="col-md-8">
					<input class="form-control" type="text" name="gravatar" id="gravatar" value="{{ Input::old('gravatar', $user->gravatar) }}" />
					{{ $errors->first('gravatar', '<span class="help-block">:message</span>') }}
				</div>

				<p class="col-md-12 text-center" style="margin-top: 15px;">
					<img src="//secure.gravatar.com/avatar/{{ md5(strtolower(trim($user->gravatar))) }}" width="30" height="30" />
					<a href="http://gravatar.com">Change your avatar at Gravatar.com</a>.
				</p>
			</div>

			<hr>

			<!-- Form actions -->
			<div class="control-group">
				<div class="controls">
					<button type="submit" class="btn btn-success">Update your Profile</button>
				</div>
			</div>
		</form>
	</div>
</div>
@stop
