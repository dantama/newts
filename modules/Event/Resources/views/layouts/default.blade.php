@extends('layouts.default')

@section('titleTemplate', ' - Admin Tapaksuci')

@section('main')

<div id="wrapper">
	@include('event::layouts.components.sidebar')

	<div id="content-wrapper" class="d-flex flex-column">

		<div id="content">
			@include('event::layouts.components.navbar')
			<div class="container-fluid">
				@yield('content-header')
				@if(session('success'))
					<div class="alert alert-success bg-success alert-dismissible fade show" role="alert">
						<button type="button" class="close" data-dismiss="alert"> <span aria-hidden="true">&times;</span> </button>
						{!! session('success') !!}
					</div>
				@endif
				@if(session('danger'))
					<div class="alert alert-danger bg-danger text-white alert-dismissible fade show" role="alert">
						<button type="button" class="close" data-dismiss="alert"> <span aria-hidden="true">&times;</span> </button>
						{!! session('danger') !!}
					</div>
				@endif
		    	@yield('content')
			</div>
		</div>

		<footer class="sticky-footer bg-white">
			<div class="container my-auto">
				<div class="copyright text-center my-auto">
					<span>Copyright &copy; Your Website 2019</span>
				</div>
			</div>
		</footer>
	</div>
</div>
@include('account::auth.includes.logout')

@endsection