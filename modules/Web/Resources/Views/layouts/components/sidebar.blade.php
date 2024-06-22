<ul class="navbar-nav bg-gray-900 sidebar sidebar-dark accordion" id="acrdsdbr">
	<a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('administration::dashboard') }}">
		<div class="sidebar-brand-icon">
			<img src="{{ asset('img/logo/tapak-suci-png-5.png') }}" alt="" style="width: 32px;">
		</div>
		<div class="sidebar-brand-text mx-3">Tapaksuci</div>
	</a>
	<hr class="sidebar-divider my-0">
	@can('adminable')
		<li class="nav-item">
			<a class="nav-link" href="{{ route('administration::dashboard') }}">
				<i class="fas fa-fw fa-tachometer-alt"></i>  <span>Dashboard</span>
			</a>
		</li>
	@endcan
	<li class="nav-item">
		<a class="nav-link" href="{{ route('event::home') }}">
			<i class="fas fa-fw fa-edit"></i>  <span>Event</span>
		</a>
	</li>
	@if(auth()->user()->isManagerProvinces() || auth()->user()->isManagerRegencies())
	<hr class="sidebar-divider">
	<div class="sidebar-heading"> Event </div>
		<li class="nav-item">
			<a href="{{ route('event::submissions.index') }}" class="nav-link">
				<i class="fas fa-paper-plane"></i> <span>Pengajuan</span>
			</a>
		</li>
	@endif
	@if(auth()->user()->isManagerCenters() || auth()->user()->isManagerProvinces() || auth()->user()->isManagerRegencies())
	<li class="nav-item">
		<a class="nav-link" data-target="#sidebar_events" data-toggle="collapse" href="#" href="javascript:;">
			<i class="fas fa-newspaper"> </i> <span> Kelola event </span>
		</a>
		<div class="collapse" data-parent="#sidebar_events" id="sidebar_events">
			<div class="bg-white py-2 collapse-inner rounded">
				@if(auth()->user()->isManagerCenters())
					<a class="collapse-item" href="{{ route('event::manage.center.index') }}">
						<span>Pusat</span>
					</a>
				@endif
				@if(auth()->user()->isManagerCenters() || auth()->user()->isManagerProvinces())
					<a class="collapse-item" href="{{ route('event::manage.province.index') }}">
						<span>Wilayah</span>
					</a>
				@endif
				@if(auth()->user()->isManagerCenters() || auth()->user()->isManagerProvinces() || auth()->user()->isManagerRegencies())
					<a class="collapse-item" href="{{ route('event::manage.regency.index') }}">
						<span>Daerah</span>
					</a>
				@endif
				@if(auth()->user()->isManagerCenters())
					<a class="collapse-item" href="{{ route('event::manage.category.index') }}">
						<span>Tambah Kategori</span>
					</a>
				@endif
			</div>
		</div>
	</li>
	@endif
	<hr class="sidebar-divider">
	<div class="sidebar-heading"> Akun </div>
	<li class="nav-item">
		<a class="nav-link" href="{{ route('account::index') }}">
			<i class="fas fa-fw fa-user"></i>  <span>Profil</span>
		</a>
	</li>
	<li class="nav-item">
		<a class="nav-link" href="{{ route('account::password', ['next' => url()->current()]) }}">
			<i class="fas fa-fw fa-lock"></i>  <span>Ubah sandi</span>
		</a>
	</li>
	<li class="nav-item">
		<a class="nav-link" href="{{ route('account::auth.logout') }}" onclick="event.preventDefault(); $('#logout-form').submit();">
			<i class="fas fa-fw fa-power-off"></i>  <span>Logout</span>
		</a>
	</li>
	<hr class="sidebar-divider">
	<div class="text-center d-none d-md-inline">
		<button class="rounded-circle border-0" id="sidebarToggle"></button>
	</div>
</ul>