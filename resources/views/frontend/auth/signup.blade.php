@extends('kit::frontend.layouts.default')

{{-- Page title --}}
@section('title')
Account Sign up ::
@parent
@stop

{{-- Page content --}}
@section('content')
<div class="page-header">
	<h3>Sign up</h3>
</div>
<div class="row">
	<div class="col-md-12">
		<form method="post" action="{{ route('signup') }}" class="form-horizontal" autocomplete="off">
			<!-- CSRF Token -->
			<input type="hidden" name="_token" value="{{ csrf_token() }}" />

			<!-- First Name -->
			<div class="form-group{{ $errors->first('first_name', ' has-error') }}">
			<label class="form-label col-md-2" for="first_name">First Name</label>
				<div class="col-md-4">
					<input class="form-control" type="text" name="first_name" id="first_name" value="{{ Input::old('first_name') }}" />
					{{ $errors->first('first_name') }}
				</div>
			</div>

			<!-- Last Name -->
			<div class="form-group{{ $errors->first('last_name', ' has-error') }}">
				<label class="form-label col-md-2" for="last_name">Last Name</label>
				<div class="col-md-4">
					<input class="form-control" type="text" name="last_name" id="last_name" value="{{ Input::old('last_name') }}" />
					{{ $errors->first('last_name') }}
				</div>
			</div>

			<!-- Email -->
			<div class="form-group{{ $errors->first('email', ' has-error') }}">
				<label class="form-label col-md-2" for="email">Email</label>
				<div class="col-md-4">
					<input class="form-control" type="text" name="email" id="email" value="{{ Input::old('email') }}" />
					{{ $errors->first('email') }}
				</div>
			</div>

			<!-- Email Confirm -->
			<div class="form-group{{ $errors->first('email_confirm', ' has-error') }}">
				<label class="form-label col-md-2" for="email_confirm">Confirm Email</label>
				<div class="col-md-4">
					<input class="form-control" type="text" name="email_confirm" id="email_confirm" value="{{ Input::old('email_confirm') }}" />
					{{ $errors->first('email_confirm') }}
				</div>
			</div>

			<!-- Password -->
			<div class="form-group{{ $errors->first('password', ' has-error') }}">
				<label class="form-label col-md-2" for="password">Password</label>
				<div class="col-md-4">
					<input class="form-control" type="password" name="password" id="password" value="" />
					{{ $errors->first('password') }}
				</div>
			</div>

			<!-- Password Confirm -->
			<div class="form-group{{ $errors->first('password_confirm', ' has-error') }}">
				<label class="form-label col-md-2" for="password_confirm">Confirm Password</label>
				<div class="col-md-4">
					<input class="form-control" type="password" name="password_confirm" id="password_confirm" value="" />
					{{ $errors->first('password_confirm') }}
				</div>
			</div>

			<hr>

			<!-- Form actions -->
			<div class="form-group">
				<div class="col-md-4">
					<a class="btn" href="{{ url('/') }}">Cancel</a>

					<button type="submit" class="btn">Sign up</button>
				</div>
			</div>
		</form>
	</div>
</div>
@stop
