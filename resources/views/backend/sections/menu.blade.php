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
			      <a class="navbar-brand" href="{{ route('admin') }}">@lang('kit::kit.title')</a>
			    </div>

			    <!-- Collect the nav links, forms, and other content for toggling -->
			    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			      <ul class="nav navbar-nav">
			        	<li{{ (Request::is('admin') ? ' class="active"' : '') }}><a href="{{ URL::to('admin') }}"><i class="icon-home icon-white"></i> Dashboard</a></li>
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