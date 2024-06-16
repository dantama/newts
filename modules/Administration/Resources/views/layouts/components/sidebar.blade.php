<ul class="navbar-nav bg-gray-900 sidebar sidebar-dark accordion" id="acrdsdbr">
	<a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('administration::dashboard') }}">
		<div class="sidebar-brand-icon">
			<img src="{{ asset('img/logo/tapak-suci-png-5.png') }}" alt="" style="width: 32px;">
		</div>
		<div class="sidebar-brand-text mx-3">Tapaksuci</div>
	</a>
	<hr class="sidebar-divider my-0">
	<li class="nav-item">
		<a class="nav-link" href="{{ route('administration::dashboard') }}">
			<i class="fas fa-fw fa-tachometer-alt"></i>  <span>Dashboard</span>
		</a>
	</li>
	<li class="nav-item">
		<a href="{{ route('event::home') }}" class="nav-link">
			<i class="fas fa-edit"></i> <span> Event
		</a>
	</li>
	<hr class="sidebar-divider">
	@if(auth()->user()->isManagerCenters())
	<div class="sidebar-heading"> Statistik </div>
	<li class="nav-item">
		<a class="nav-link collapsed" href="javascript:;" data-toggle="collapse" data-target="#clpsStatistik">
			<i class="far fa-fw fa-user"></i><span>Statistik</span>
		</a>
		<div id="clpsStatistik" class="collapse" data-parent="#acrdsdbr">
			<div class="bg-white py-2 collapse-inner rounded">
				<a class="collapse-item" href="{{ route('administration::statistic') }}">Pendekar</a>
				<a class="collapse-item" href="{{ route('administration::cadre-statistic') }}">Kader</a>
				<a class="collapse-item" href="{{ route('administration::student-statistic') }}">Siswa</a>
			</div>
		</div>
	</li>
	@endif
	<div class="sidebar-heading"> Halaman depan </div>
	<li class="nav-item">
		<a class="nav-link" href="{{ route('web::index') }}">
			<i class="fas fa-fw fa-home"></i>  <span>Beranda</span>
		</a>
	</li>
	<li class="nav-item">
		<a class="nav-link collapsed" data-target="#clpsBlog" data-toggle="collapse" href="javascript:;">
			<i class="fas fa-sm fa-newspaper"> </i> <span> Postingan </span>
		</a>
		<div id="clpsBlog" class="collapse" data-parent="#acrdsdbr">
			<div class="bg-white py-2 collapse-inner rounded">
				<a class="collapse-item" href="{{ route('administration::blog.posts.index') }}"> Semua postingan </a>
				<a class="collapse-item" href="{{ route('administration::blog.categories.index') }}"> Kategori </a>
			</div>
		</div>
	</li>
	@if(auth()->user()->isManagerCenters() || auth()->user()->isManagerProvinces() || auth()->user()->isManagerRegencies())
	<hr class="sidebar-divider">
	<div class="sidebar-heading"> Kepengurusan </div>
	@endif
	@if(auth()->user()->isManagerCenters())
		<li class="nav-item">
			<a class="nav-link collapsed" href="javascript:;" data-toggle="collapse" data-target="#clpsCenters">
				<i class="far fa-fw fa-user"></i><span>Pusat</span>
			</a>
			<div id="clpsCenters" class="collapse" data-parent="#acrdsdbr">
				<div class="bg-white py-2 collapse-inner rounded">
					<a class="collapse-item" href="{{ route('administration::managements.centers.index') }}">Data pusat</a>
					<a class="collapse-item" href="{{ route('administration::managements.centers-managers.index') }}">Pengurus</a>
				</div>
			</div>
		</li>
	@endif
	@if(auth()->user()->isManagerCenters() || auth()->user()->isManagerProvinces())
		<li class="nav-item">
			<a class="nav-link collapsed" href="javascript:;" data-toggle="collapse" data-target="#clpsProvinces">
				<i class="far fa-fw fa-user"></i><span>Wilayah</span>
			</a>
			<div id="clpsProvinces" class="collapse" data-parent="#acrdsdbr">
				<div class="bg-white py-2 collapse-inner rounded">
					<a class="collapse-item" href="{{ route('administration::managements.provinces.index') }}">Data wilayah</a>
					<a class="collapse-item" href="{{ route('administration::managements.provinces-managers.index') }}">Pengurus</a>
				</div>
			</div>
		</li>
	@endif
	@if(auth()->user()->isManagerCenters() || auth()->user()->isManagerPerwil())
		<li class="nav-item">
			<a class="nav-link collapsed" href="javascript:;" data-toggle="collapse" data-target="#clpsPerwil">
				<i class="far fa-fw fa-user"></i><span>Perwil</span>
			</a>
			<div id="clpsPerwil" class="collapse" data-parent="#acrdsdbr">
				<div class="bg-white py-2 collapse-inner rounded">
					<a class="collapse-item" href="{{ route('administration::managements.perwil.index') }}">Data perwil</a>
					<a class="collapse-item" href="{{ route('administration::managements.perwil-managers.index') }}">Pengurus</a>
				</div>
			</div>
		</li>
	@endif
	@if(auth()->user()->isManagerCenters() || auth()->user()->isManagerProvinces() || auth()->user()->isManagerRegencies())
		<li class="nav-item">
			<a class="nav-link collapsed" href="javascript:;" data-toggle="collapse" data-target="#clpsRegencies">
				<i class="far fa-fw fa-user"></i><span>Daerah</span>
			</a>
			<div id="clpsRegencies" class="collapse" data-parent="#acrdsdbr">
				<div class="bg-white py-2 collapse-inner rounded">
					<a class="collapse-item" href="{{ route('administration::managements.regencies.index') }}">Data daerah</a>
					<a class="collapse-item" href="{{ route('administration::managements.regencies-managers.index') }}">Pengurus</a>
				</div>
			</div>
		</li>
		<li class="nav-item">
			<a class="nav-link collapsed" href="javascript:;" data-toggle="collapse" data-target="#clpsDisticts">
				<i class="far fa-fw fa-user"></i><span>Cabang</span>
			</a>
			<div id="clpsDisticts" class="collapse" data-parent="#acrdsdbr">
				<div class="bg-white py-2 collapse-inner rounded">
					<a class="collapse-item" href="{{ route('administration::managements.districts.index') }}">Data cabang</a>
					<a class="collapse-item" href="{{ route('administration::managements.districts-managers.index') }}">Pengurus</a>
				</div>
			</div>
		</li>
	@endif
	<hr class="sidebar-divider">
	<div class="sidebar-heading"> Anggota </div>
	@if(auth()->user()->isManagerCenters())
	<li class="nav-item">
		<a class="nav-link" href="{{ route('administration::members.account.index') }}">
			<i class="fas fa-fw fa-users"></i> <span>Akun Anggota</span>
		</a>
	</li>
	@endif
	<li class="nav-item">
		<a class="nav-link" href="{{ route('administration::members.warriors.index') }}">
			<i class="fas fa-fw fa-users"></i>  <span>Pendekar</span>
		</a>
	</li>
	<li class="nav-item">
		<a class="nav-link" href="{{ route('administration::members.cadres.index') }}">
			<i class="fas fa-fw fa-users"></i>  <span>Kader</span>
		</a>
	</li>
	<li class="nav-item">
		<a class="nav-link" href="{{ route('administration::members.students.index') }}">
			<i class="fas fa-fw fa-graduation-cap"></i>  <span>Siswa</span>
		</a>
	</li>
	@if(auth()->user()->isManagerPerwil() || auth()->user()->isManagerCenters())
	<hr class="sidebar-divider">
	<div class="sidebar-heading"> Perwil </div>
	<li class="nav-item">
		<a class="nav-link" href="{{ route('administration::members.perwil-warriors.index') }}">
			<i class="fas fa-fw fa-users"></i>  <span>Warriors</span>
		</a>
	</li>
	<li class="nav-item">
		<a class="nav-link" href="{{ route('administration::members.perwil-cadres.index') }}">
			<i class="fas fa-fw fa-users"></i>  <span>Cadres</span>
		</a>
	</li>
	<li class="nav-item">
		{{-- <a class="nav-link" href="{{ route('administration::members.perwil-students.index') }}"> --}}
		<a class="nav-link" href="javascript:;">
			<i class="fas fa-fw fa-graduation-cap"></i>  <span>Students</span>
		</a>
	</li>
	@endif
	@if(auth()->user()->isManagerCenters() || auth()->user()->isManagerProvinces() || auth()->user()->isManagerRegencies())
	<hr class="sidebar-divider">
	<div class="sidebar-heading"> Pelatih dan Wasit </div>
	@endif
	@if(auth()->user()->isManagerCenters())
		<li class="nav-item">
			<a class="nav-link collapsed" href="javascript:;" data-toggle="collapse" data-target="#clpsCoachCenters">
				<i class="far fa-fw fa-user"></i><span>Pusat</span>
			</a>
			<div id="clpsCoachCenters" class="collapse" data-parent="#acrdsdbr">
				<div class="bg-white py-2 collapse-inner rounded">
					<a class="collapse-item" href="{{ route('administration::technical.center-coachs.index') }}">Data Pelatih</a>
					<a class="collapse-item" href="{{ route('administration::technical.center-referees.index') }}">Data Wasit</a>
				</div>
			</div>
		</li>
	@endif
	@if(auth()->user()->isManagerCenters() || auth()->user()->isManagerProvinces())
		<li class="nav-item">
			<a class="nav-link collapsed" href="javascript:;" data-toggle="collapse" data-target="#clpsCoachProvinces">
				<i class="far fa-fw fa-user"></i><span>Wilayah</span>
			</a>
			<div id="clpsCoachProvinces" class="collapse" data-parent="#acrdsdbr">
				<div class="bg-white py-2 collapse-inner rounded">
					<a class="collapse-item" href="{{ route('administration::technical.province-coachs.index') }}">Data Pelatih</a>
					<a class="collapse-item" href="{{ route('administration::technical.province-referees.index') }}">Data Wasit</a>
				</div>
			</div>
		</li>
	@endif
	@if(auth()->user()->isManagerCenters() || auth()->user()->isManagerProvinces() || auth()->user()->isManagerRegencies())
		<li class="nav-item">
			<a class="nav-link collapsed" href="javascript:;" data-toggle="collapse" data-target="#clpsCoachRegencies">
				<i class="far fa-fw fa-user"></i><span>Daerah</span>
			</a>
			<div id="clpsCoachRegencies" class="collapse" data-parent="#acrdsdbr">
				<div class="bg-white py-2 collapse-inner rounded">
					<a class="collapse-item" href="{{ route('administration::technical.regency-coachs.index') }}">Data Pelatih</a>
					<a class="collapse-item" href="{{ route('administration::technical.regency-referees.index') }}">Data Wasit</a>
				</div>
			</div>
		</li>
	@endif
	@if(auth()->user()->isManagerCenters() || auth()->user()->isManagerProvinces() || auth()->user()->isManagerRegencies())
	<hr class="sidebar-divider">
	<div class="sidebar-heading"> Prestasi </div>
	<li class="nav-item">
		<a class="nav-link collapsed" href="javascript:;" data-toggle="collapse" data-target="#clpsAchievementInternal">
			<i class="far fa-fw fa-user"></i><span>Internal</span>
		</a>
		<div id="clpsAchievementInternal" class="collapse" data-parent="#acrdsdbr">
			<div class="bg-white py-2 collapse-inner rounded">
				@if(auth()->user()->isManagerCenters())
				<a class="collapse-item" href="{{ route('administration::achievement.center-achievements.index') }}">Prestasi Pusat</a>
				@endif
				@if(auth()->user()->isManagerCenters() || auth()->user()->isManagerProvinces())
				<a class="collapse-item" href="{{ route('administration::achievement.province-achievements.index') }}">Prestasi Wilayah</a>
				@endif
				@if(auth()->user()->isManagerCenters() || auth()->user()->isManagerProvinces() || auth()->user()->isManagerRegencies())
				<a class="collapse-item" href="{{ route('administration::achievement.regency-achievements.index') }}">Prestasi Daerah</a>
				@endif
			</div>
		</div>
	</li>
	<li class="nav-item">
		<a class="nav-link collapsed" href="javascript:;" data-toggle="collapse" data-target="#clpsAchievementEksternal">
			<i class="far fa-fw fa-user"></i><span>Eksternal</span>
		</a>
		<div id="clpsAchievementEksternal" class="collapse" data-parent="#acrdsdbr">
			<div class="bg-white py-2 collapse-inner rounded">
				<a class="collapse-item" href="#">Prestasi Eksternal</a>
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