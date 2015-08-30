<!DOCTYPE html>
<html lang="en">
	<head>
		@include('kit::backend.sections.head')
	</head>

	<body>
		<!-- Container -->
		<div class="container">
			@include('kit::backend.sections.menu')

			<!-- Notifications -->
			@include('kit::frontend.notifications')

			<!-- Content -->
			@yield('content')
		</div>

		@include('kit::backend.sections.footer')
	</body>
</html>
