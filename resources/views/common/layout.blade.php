<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>@yield('title')</title>

	<!-- bootstrap -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">

	<!-- datatable -->
	<link rel="stylesheet" href="https://cdn.datatables.net/2.1.3/css/dataTables.dataTables.min.css">

	<!-- google icons -->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

	<!-- custom css -->
	<link rel="stylesheet" href="/css/style.css">

	<!-- jquery -->
	<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
</head>

<body>

	<nav class="navbar navbar-expand-lg navbar-light bg-light">
		<div class="container-fluid">
			<a class="navbar-brand" href="{{ route('index') }}">ToDo App</a>
		</div>
	</nav>

	<div id="alertMessage">
		@include('alert_message')
	</div>

	<div class="main">
		@section('main')
		@show
	</div>


	<footer>
		<div class="bg-secondary text-light p-2">
			<h6 class="text-center m-1">ToDo App</h6>
		</div>
	</footer>


	
	<!-- bootstrap -->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

	<!-- datatable -->
	<script src="https://cdn.datatables.net/2.1.3/js/dataTables.min.js"></script>

	<!-- custom js -->
	<script src="/js/custom.js"></script>
	
	@section('script')
	@show
	
</body>

</html>