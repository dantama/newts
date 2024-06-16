@extends('layouts.default')

@section('titleTemplate', ' - Admin Tapaksuci')

@section('main')

<div id="wrapper">
	@include('administration::layouts.components.sidebar')

	<div id="content-wrapper" class="d-flex flex-column">

		<div id="content">
			@include('administration::layouts.components.navbar')
			<div class="container-fluid">
				@yield('content-header')
				@if(session('success'))
					<div class="alert alert-success bg-success alert-dismissible fade show" role="alert">
						{!! session('success') !!}
						<button type="button" class="close" data-dismiss="alert"> <span aria-hidden="true">&times;</span> </button>
					</div>
				@endif
				@if(session('danger'))
					<div class="alert alert-danger bg-danger alert-dismissible fade show" role="alert">
						{!! session('danger') !!}
						<button type="button" class="close" data-dismiss="alert"> <span aria-hidden="true">&times;</span> </button>
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