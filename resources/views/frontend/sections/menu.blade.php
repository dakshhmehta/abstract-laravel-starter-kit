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
			      <a class="navbar-brand" href="{{ url('/') }}">@lang('kit::kit.title')</a>
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