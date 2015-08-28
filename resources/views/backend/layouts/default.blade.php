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
		<meta name="keywords" content="your, awesome, keywords, here" />
		<meta name="author" content="Jon Doe" />
		<meta name="description" content="Lorem ipsum dolor sit amet, nihil fabulas et sea, nam posse menandri scripserit no, mei." />

		<!-- Mobile Specific Metas
		================================================== -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<!-- CSS
		================================================== -->
		<link href="{{ asset('css/app.css') }}" rel="stylesheet">

		<style>
		@section('styles')
		body {
			padding: 20px 0;
		}
		@show
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
		<link rel="shortcut icon" href="{{ asset('assets/ico/favicon.png') }}">

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
			        	<li{{ (Request::is('admin') ? ' class="active"' : '') }}><a href="{{ URL::to('admin') }}"><i class="icon-home icon-white"></i> Home</a></li>
						<li{{ (Request::is('admin/blogs*') ? ' class="active"' : '') }}><a href="{{ URL::to('admin/blogs') }}"><i class="icon-list-alt icon-white"></i> Blogs</a></li>
						<li class="dropdown{{ (Request::is('admin/users*|admin/groups*') ? ' active' : '') }}">
							<a class="dropdown-toggle" data-toggle="dropdown" href="{{ URL::to('admin/users') }}">
								<i class="icon-user icon-white"></i> Users <span class="caret"></span>
							</a>
							<ul class="dropdown-menu">
								<li{{ (Request::is('admin/users*') ? ' class="active"' : '') }}><a href="{{ URL::to('admin/users') }}"><i class="icon-user"></i> Users</a></li>
								<li{{ (Request::is('admin/groups*') ? ' class="active"' : '') }}><a href="{{ URL::to('admin/groups') }}"><i class="icon-user"></i> Groups</a></li>
							</ul>
						</li>
			      </ul>
			      <ul class="nav navbar-nav navbar-right">
						<li><a href="{{ URL::to('/') }}" target="_blank">View Homepage</a></li>
						<li class="divider-vertical"></li>
						<li><a href="{{ route('logout') }}">Logout</a></li>
			      </ul>
			    </div><!-- /.navbar-collapse -->
			  </div><!-- /.container-fluid -->
			</nav>

			<!-- Notifications -->
			@include('kit::frontend.notifications')

			<!-- Content -->
			@yield('content')
		</div>

		<!-- Javascripts
		================================================== -->
		<script src="//code.jquery.com/jquery-1.11.2.min.js"></script>
		<script src="//maxcdn.bootstrapcdn.com/bootstrap/latest/js/bootstrap.min.js"></script>

		@yield('footer')
	</body>
</html>
