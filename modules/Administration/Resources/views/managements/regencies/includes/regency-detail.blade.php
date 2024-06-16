@php
	$__regency = $regency ? $regency->loadCount('managers', 'students', 'members') : null;
	$__list = [
		'Nama Pimda'	=> $__regency->name,
		'Nama Pimwil'	=> $__regency->management->name,
		'Alamat Pimda'	=> $__regency->full_address,
		'Jumlah pengurus'	=> $__regency->managers_count.' pengurus',
		'Jumlah anggota'	=> $__regency->members_count.' anggota',
		'Jumlah siswa'	=> $__regency->students_count.' siswa',
	];
@endphp

<div class="card border-left-danger border-0 shadow mb-4">
	<div class="card-header"><i class="fas fa-list fa-fw"></i><strong>Detail Pimda</strong></div>
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
				Tidak ada detail Pimda
			</div>
		@endif
	</div>
</div>