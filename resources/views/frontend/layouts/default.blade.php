<!DOCTYPE html>
<html lang="en">
	<head>
		<!-- Basic Page Needs
		================================================== -->
		<meta charset="utf-8" />
		<title>
			@section('title')
			@show
			- @lang('kit::kit.title')
		</title>
		<meta name="keywords" content="laravel, kit, starter, package" />
		<meta name="author" content="Daksh Mehta" />
		<meta name="description" content="Laravel 5 Starter Kit to intialize the project" />

		<!-- Mobile Specific Metas
		================================================== -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<!-- CSS
		================================================== -->
		<link href="{{ asset('css/app.css') }}" rel="stylesheet">

		<style type="text/css">
		body {
			padding-top: 10px;
		}
		</style>

		<!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
		<!--[if lt IE 9]>
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->

		<!-- Favicons
		================================================== -->
		<link rel="apple-touch-icon-precomposed" sizes="144x144" href="{{ asset('assets/ico/apple-touch-icon-144-precomposed.png') }}">
		<link rel="apple-touch-icon-precomposed" sizes="114x114" href="{{ asset('assets/ico/apple-touch-icon-114-precomposed.png') }}">
		<link rel="apple-touch-icon-precomposed" sizes="72x72" href="{{ asset('assets/ico/apple-touch-icon-72-precomposed.png') }}">
		<link rel="apple-touch-icon-precomposed" href="{{ asset('assets/ico/apple-touch-icon-57-precomposed.png') }}">
		<link rel="shortcut icon" href="{{ asset('ico/favicon.png') }}">

		@yield('head')
	</head>

	<body>
		<!-- Container -->
		<div class="container">
			<!-- Navbar -->
			<nav class="navbar navbar-default">
			  <div class="container-fluid">
			    <!-- Brand and toggle get grouped for better mobile display -->
			    <div class="navbar-header">
			      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
			        <span class="sr-only">Toggle navigation</span>
			        <span class="icon-bar"></span>
			        <span class="icon-bar"></span>
			        <span class="icon-bar"></span>
			      </button>
			      <a class="navbar-brand" href="#">Starter App</a>
			    </div>

			    <!-- Collect the nav links, forms, and other content for toggling -->
			    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			      <ul class="nav navbar-nav">
			        	<li {{ (Request::is('/') ? 'class="active"' : '') }}><a href="{{ url('/') }}"><i class="icon-home icon-white"></i> Home</a></li>
						<li {{ (Request::is('about-us') ? 'class="active"' : '') }}><a href="{{ url('about-us') }}"><i class="icon-file icon-white"></i> About us</a></li>
						<li {{ (Request::is('contact-us') ? 'class="active"' : '') }}><a href="{{ url('contact-us') }}"><i class="icon-file icon-white"></i> Contact us</a></li>
			      </ul>
			      <ul class="nav navbar-nav navbar-right">
						@if (Sentinel::check())
							<li class="dropdown">
								<a class="dropdown-toggle" id="dLabel" role="button" data-toggle="dropdown" data-target="#" href="{{ route('account') }}">
									Welcome, {{ Sentinel::getUser()->first_name }}
									<b class="caret"></b>
								</a>
								<ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
									@if(Sentinel::getUser()->hasAccess('admin'))
									<li><a href="{{ route('admin') }}"><i class="icon-cog"></i> Administration</a></li>
									@endif
									<li{{ (Request::is('account/profile') ? ' class="active"' : '') }}><a href="{{ route('profile') }}"><i class="icon-user"></i> Your profile</a></li>
									<li class="divider"></li>
									<li><a href="{{ route('logout') }}"><i class="icon-off"></i> Logout</a></li>
								</ul>
							</li>
						@else
							<li {{ (Request::is('auth/signin') ? 'class="active"' : '') }}><a href="{{ route('signin') }}">Sign in</a></li>
							<li {{ (Request::is('auth/signup') ? 'class="active"' : '') }}><a href="{{ route('signup') }}">Sign up</a></li>
						@endif
			      </ul>
			    </div><!-- /.navbar-collapse -->
			  </div><!-- /.container-fluid -->
			</nav>

			<!-- Notifications -->
			@include('kit::frontend.notifications')

			<!-- Content -->
			@yield('content')

			<hr />

			<!-- Footer -->
			<footer>
				<p class="text-center">Developed with <a target="_blank" href="http://laravel.com">Laravel</a> and <a target="_blank" href="http://getbootstrap.com">Bootstrap</a> by <a target="_blank" href="http://twitter.com/dakshhmehta">@dakshhmehta</a></p>
			</footer>
		</div>

		<!-- Javascripts
		================================================== -->
		<script src="//code.jquery.com/jquery-1.11.2.min.js"></script>
		<script src="//maxcdn.bootstrapcdn.com/bootstrap/latest/js/bootstrap.min.js"></script>

		@yield('footer')
	</body>
</html>
