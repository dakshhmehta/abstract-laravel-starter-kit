@extends('frontend/layouts/account')

{{-- Page title --}}
@section('title')
Change your Email
@stop

{{-- Account page content --}}
@section('account-content')
<div class="panel panel-default">
	<div class="panel-heading">
		<h4>Change your Email</h4>
	</div>
	<div class="panel-body">
		<form method="post" action="" class="form-horizontal" autocomplete="off">
			<!-- CSRF Token -->
			<input type="hidden" name="_token" value="{{ csrf_token() }}" />

			<!-- Form type -->
			<input type="hidden" name="formType" value="change-email" />

			<!-- New Email -->
			<div class="form-group{{ $errors->first('email', ' has-error') }}">
				<label class="col-md-3" for="email">New Email</label>
				<div class="col-md-9">
					<input class="form-control" type="text" name="email" id="email" value="" />
					{{ $errors->first('email', '<span class="help-block">:message</span>') }}
				</div>
			</div>

			<!-- Confirm New Email -->
			<div class="form-group{{ $errors->first('email_confirm', ' has-error') }}">
				<label class="col-md-3" for="email_confirm">Confirm New Email</label>
				<div class="col-md-9">
					<input class="form-control" type="text" name="email_confirm" id="email_confirm" value="" />
					{{ $errors->first('email_confirm', '<span class="help-block">:message</span>') }}
				</div>
			</div>

			<!-- Current Password -->
			<div class="form-group{{ $errors->first('current_password', ' has-error') }}">
				<label class="col-md-3" for="current_password">Current Password</label>
				<div class="col-md-9">
					<input class="form-control" type="password" name="current_password" id="current_password" value="" />
					{{ $errors->first('current_password', '<span class="help-block">:message</span>') }}
				</div>
			</div>

			<hr>

			<!-- Form actions -->
			<div class="form-group">
				<div class="col-md-9">
					<button type="submit" class="btn btn-success">Update Email</button>

					<a href="{{ route('forgot-password') }}" class="btn btn-link">I forgot my password</a>
				</div>
			</div>
		</form>
	</div>
</div>
@stop
