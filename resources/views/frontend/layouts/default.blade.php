<!DOCTYPE html>
<html lang="en">
	<head>
		@include('kit::frontend.sections.head')		
	</head>

	<body>
		<!-- Container -->
		<div class="container">
			@include('kit::frontend.sections.menu')

			<!-- Notifications -->
			@include('kit::frontend.notifications')

			<!-- Content -->
			@yield('content')

			<hr />

		</div>

		@include('kit::frontend.sections.footer')
	</body>
</html>
