@extends('kit::frontend.layouts.account')

{{-- Page title --}}
@section('title')
Change your Password
@stop

{{-- Account page content --}}
@section('account-content')
<div class="panel panel-default">
	<div class="panel-heading">
		<h4>Change your Password</h4>
	</div>

	<div class="panel-body">
		<form method="post" action="" class="form-horizontal" autocomplete="off">
			<!-- CSRF Token -->
			<input type="hidden" name="_token" value="{{ csrf_token() }}" />

			<!-- Old Password -->
			<div class="form-group{{ $errors->first('old_password', ' has-error') }}">
				<label class="col-md-3" for="old_password">Old Password</label>
				<div class="col-md-9">
					<input type="password" name="old_password" id="old_password" value="" class="form-control" />
					{{ $errors->first('old_password', '<span class="help-block">:message</span>') }}
				</div>
			</div>

			<!-- New Password -->
			<div class="form-group{{ $errors->first('password', ' has-error') }}">
				<label class="col-md-3" for="password">New Password</label>
				<div class="col-md-9">
					<input type="password" name="password" id="password" value="" class="form-control" />
					{{ $errors->first('password', '<span class="help-block">:message</span>') }}
				</div>
			</div>

			<!-- Confirm New Password  -->
			<div class="form-group{{ $errors->first('password_confirm', ' has-error') }}">
				<label class="col-md-3" for="password_confirm">Confirm New Password</label>
				<div class="col-md-9">
					<input type="password" name="password_confirm" id="password_confirm" value="" class="form-control" />
					{{ $errors->first('password_confirm', '<span class="help-block">:message</span>') }}
				</div>
			</div>

			<hr>

			<!-- Form actions -->
			<div class="form-group">
				<div class="col-md-9">
					<button type="submit" class="btn btn-success">Update Password</button>

					<a href="{{ route('forgot-password') }}" class="btn btn-link">I forgot my password</a>
				</div>
			</div>
		</form>
	</div>
</div>
@stop
