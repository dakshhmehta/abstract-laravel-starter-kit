@extends('kit::frontend.layouts.default')

{{-- Page title --}}
@section('title')
Account Sign in ::
@parent
@stop

{{-- Page content --}}
@section('content')
<div class="row">
	<div class="col-md-4 col-md-offset-4">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h4>Sign In</h4>
			</div>
			<div class="panel-body">
				<form method="post" action="{{ route('signin') }}" class="form-horizontal">
					<!-- CSRF Token -->
					<input type="hidden" name="_token" value="{{ csrf_token() }}" />

					<!-- Email -->
					<div class="form-group{{ $errors->first('email', ' error') }}">
						<label class="col-md-3" for="email">Email</label>
						<div class="col-md-9">
							<input type="text" name="email" id="email" value="{{ Input::old('email') }}" class="form-control" />
							{{ $errors->first('email', '<span class="help-block">:message</span>') }}
						</div>
					</div>

					<!-- Password -->
					<div class="form-group{{ $errors->first('password', ' error') }}">
						<label class="col-md-3" for="password">Password</label>
						<div class="col-md-9">
							<input type="password" name="password" id="password" value="" class="form-control" />
							{{ $errors->first('password', '<span class="help-block">:message</span>') }}
						</div>
					</div>

					<!-- Remember me -->
					<div class="form-group">
							<div class="col-md-offset-1">
							<label class="checkbox">
								<input type="checkbox" name="remember-me" id="remember-me" value="1" /> Remember me
							</label>
						</div>
					</div>

					<!-- Form actions -->
					<div class="control-group">
						<div class="controls">
							<button type="submit" class="btn btn-success col-md-12">Sign in</button>
						</div>
					</div>
					<div class="control-group">
						<div class="controls text-center">
							<a href="{{ route('forgot-password') }}" class="btn btn-link">I forgot my password</a>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
@stop
