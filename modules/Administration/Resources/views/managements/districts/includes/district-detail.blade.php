@php
	$__regency = $regency ? $regency->loadCount('managers', 'students', 'members') : null;
	$__list = [
		'Nama Cabang'	=> $__regency->name ?? 'Belum ada data',
		'Nama Pimda'	=> $__regency->management->name ?? 'Belum ada data',
		'Alamat Cabang'	=> $__regency->full_address ?? 'Belum ada data',
		'Jumlah pengurus'	=> $__regency->managers_count ?? 'Belum ada data' .' pengurus',
		'Jumlah anggota'	=> $__regency->members_count ?? 'Belum ada data'.' anggota',
		'Jumlah siswa'	=> $__regency->students_count ?? 'Belum ada data'.' siswa',
	];
@endphp

<div class="card border-left-danger border-0 shadow mb-4">
	<div class="card-header"><i class="fas fa-list fa-fw"></i><strong>Detail Cabang</strong></div>
	<div class="list-group list-group-flush">
		@if($__regency)
			@foreach($__list as $__k => $__v)
				<div class="list-group-item @if($loop->last) mb-0 @endif">
					{{ $__k }} <br>
					<strong>{!! $__v !!}</strong>
				</div>
			@endforeach
		@else
			<div class="list-group-item">
				Tidak ada detail Cabang
			</div>
		@endif
	</div>
</div>