@extends('administration::layouts.default')

@section('title', $students[0]['user']['profile']['name'].' - ')

@section('content')
	<div class="text-center mb-4">
		<h3 class="mb-1">Informasi siswa</h3>
	</div>
	<div class="row">
		<div class="col-sm-4">
			<div class="card mb-4">
				<div class="card-body text-center">
					<div class="py-4">
						@if(!empty($students[0]['user']['profile']['avatar']))
							<img class="rounded-circle" src={{ $students[0]['user']['profile']['avatar_path'] }} alt="{{ $students[0]['user']['profile']['avatar'] }}" width="128">
						@else
							<img class="rounded-circle" src="{{ asset('img/default-avatar.svg') }}" alt="" width="128">
						@endif	
					</div>
					<h5 class="mb-1"><strong>{{ $students[0]['user']['profile']['name'] }}</strong></h5>
					<p>@ {{ $students[0]['user']['username'] }}</p>
					<h4 class="mb-0">
						@if($students[0]['user']['phone']['whatsapp'])
							<a class="text-success px-1" href="https://wa.me/{{ $students[0]['user']['phone']['number'] }}" target="_blank"><i class="fas fa-comment"></i></a>
						@endif
						@if($students[0]['user']['email']['verified_at'])
							<a class="text-danger px-1" href="mailto:{{ $students[0]['user']['email']['address'] }}"><i class="fas fa-envelope"></i></a>
						@endif
					</h4>
				</div>
			</div>
			<div class="card mb-4">
				<div class="card-body">
					<h4 class="mb-1">Info akun</h4>
					<p class="mb-2 text-muted">Informasi tentang akun Anda, hanya Anda yang dapat melihat ini</p>
				</div>
				<div class="list-group list-group-flush">
					@foreach([
						'Bergabung pada' => $students[0]['user']['created_at'] ? $students[0]['user']['created_at'] ->diffForHumans() : '-',
					] as $k => $v)
						<div class="list-group-item border-0">
							{{ $k }} <br>
							<span class="{{ $v ? 'font-weight-bold' : 'text-muted' }}">
								{{ $v ?? 'Belum diisi' }}
							</span>
						</div>
					@endforeach
					<div class="list-group-item border-0 text-muted">
						<i class="fas fa-student-circle"></i> User ID : {{ $students[0]['user']['id'] }}
					</div>
				</div>
			</div>
			<div class="card mb-4">
				<div class="card-body">
					<h4 class="mb-1">Info Ketingkatan</h4>
					<p class="mb-2 text-muted">Informasi tentang riwayat tingkat keanggotaan</p>
				</div>
				<div class="list-group list-group-flush">	
					@if(!empty($students[0]['levels']))
						@foreach($students[0]['levels'] as $level)
							@if($loop->last)
								<div class="list-group-item border-0 text-muted">
									<i class="fas fa-student-circle"></i> <b>{{ $level['detail']->name }}</b> Tahun : {{ $level->year }} 
								</div>
							@endif
						@endforeach
					@else
					<div class="list-group-item border-0 text-muted">
						<i class="fas fa-student-circle"></i> Belum ada data
					</div>
					@endif
				</div>
			</div>
			<div class="card mb-4">
				<div class="card-body">
					<h4 class="mb-1">Info Prestasi</h4>
					<p class="mb-2 text-muted">Informasi tentang prestasi anggota</p>					
				</div>
				<div class="list-group list-group-flush">	
					@if(!empty($students[0]['user']['achievements']))
						@foreach($students[0]['user']['achievements'] as $achievement)
						<div class="list-group-item border-0 text-muted">
							<i class="fas fa-student-circle"></i> <b>{{ $achievement->name }}</b> Tahun : {{ $achievement->year }} 
						</div>
						@endforeach
					@else
					<div class="list-group-item border-0 text-muted">
						<i class="fas fa-student-circle"></i> Belum ada data
					</div>
					@endif
				</div>
			</div>
		</div>
		<div class="col-sm-8">
			<div class="card mb-4">
				<div class="dropdown position-absolute" style="top: .3em; right: 0;">
					<a class="btn btn-link text-secondary" href="javascript:;" id="dropdown" data-toggle="dropdown"><i class="fas fa-ellipsis-v"></i></a>
					<div class="dropdown-menu dropdown-menu-right border-0 shadow">
						<a class="dropdown-item" href="{{ route('administration::members.students.avatar',['student' => $students[0]['id']]) }}"><i class="fas fa-edit"></i> Ubah foto</a>
						<a class="dropdown-item" href="{{ route('administration::members.students.level',['student' => $students[0]['id']]) }}"><i class="fas fa-edit"></i> Ubah Tingkat</a>
					</div>
				</div>
				<div class="card-body">
					<h4 class="mb-1">Profil</h4>
					<p class="mb-2 text-muted">Beberapa info mungkin terlihat oleh orang lain</p>
				</div>
				<div class="list-group list-group-flush">
					@foreach([
						'Nama lengkap' => [$students[0]['user']['profile']['full_name'], route('administration::members.students.profile',['student' => $students[0]['id']])],
						'Tempat lahir' => [$students[0]['user']['profile']['pob'], route('administration::members.students.profile',['student' => $students[0]['id']])],
						'Tanggal lahir' => [$students[0]['user']['profile']['dob_name'], route('administration::members.students.profile',['student' => $students[0]['id']])],
						'Jenis kelamin' => [$students[0]['user']['profile']['sex_name'], route('administration::members.students.profile',['student' => $students[0]['id']])],
					] as $k => $v)
						<a class="list-group-item list-group-item-action border-0" href="{{ $v[1] }}">
							<div class="row">
								<div class="col-10">
									<div class="row">
										<div class="col-sm-4">
											<small>{{ $k }}</small>
										</div>
										<div class="col-sm-8">
											<span class="{{ $v[0] ? 'font-weight-bold' : 'text-muted' }}">
												{{ $v[0] ?? 'Belum diisi' }}
											</span>
										</div>
									</div>
								</div>
								<div class="col-2 text-right align-self-center">
									<i class="fa fa-chevron-right"></i>
								</div>
							</div>
						</a>
					@endforeach
				</div>
			</div>
			<div class="card mb-4">
				<div class="card-body">
					<h4 class="mb-1">Info kontak</h4>
				</div>
				<div class="list-group list-group-flush">
					@foreach([
						'Alamat e-mail' => [$students[0]['user']['email']['address'], ($students[0]['user']['email']['verified_at'] ? ' <span class="badge badge-pill badge-success font-weight-normal">Terverifikasi</span>' : ' <span class="badge badge-pill badge-danger font-weight-normal">Belum verifikasi</span>'), route('administration::members.students.email',['student' => $students[0]['id']])],
						'Nomor HP' => [$students[0]['user']['phone']['number'], ($students[0]['user']['phone']['whatsapp'] ? ' <i class="fas fa-whatsapp text-success"></i>' : null), route('administration::members.students.phone',['student' => $students[0]['id']])],
					] as $k => $v)
						<a class="list-group-item list-group-item-action border-0" href="{{ $v[2] }}">
							<div class="row">
								<div class="col-10">
									<div class="row">
										<div class="col-sm-4">
											<small>{{ $k }}</small>
										</div>
										<div class="col-sm-8">
											<span class="{{ $v[0] ? 'font-weight-bold' : 'text-muted' }}">
												{!! $v[0] ? $v[0].$v[1] : 'Belum diisi' !!}
											</span>
										</div>
									</div>
								</div>
								<div class="col-2 text-right align-self-center">
									<i class="fas fa-chevron-right"></i>
								</div>
							</div>
						</a>
					@endforeach
				</div>
			</div>
			<div class="card mb-4">
				<div class="card-body">
					<h4 class="mb-1">Info Alamat</h4>
				</div>
				<div class="list-group list-group-flush">
					@foreach([
						'Alamat' => [$students[0]['user']['address']['address'], route('administration::members.students.address',['student' => $students[0]['id']])],
					] as $k => $v)
						<a class="list-group-item list-group-item-action border-0" href="{{ route('administration::members.students.address',['student' => $students[0]['id']]) }}">
							<div class="row">
								<div class="col-10">
									<div class="row">
										<div class="col-sm-4">
											<small>{{ $k }}</small>
										</div>
										<div class="col-sm-8">
											<span class="{{ $v[0] ? 'font-weight-bold' : 'text-muted' }}">
												{!! $v[0] ?? 'Belum diisi' !!}
											</span>
										</div>
									</div>
								</div>
								<div class="col-2 text-right align-self-center">
									<i class="fas fa-chevron-right"></i>
								</div>
							</div>
						</a>
					@endforeach
				</div>
			</div>
			<div class="card mb-4">
				<div class="card-body">
					<h4 class="mb-1">Organisasi</h4>
				</div>
				<div class="list-group list-group-flush">
					<a class="list-group-item list-group-item-action border-0" href="{{ route('administration::members.students.organizations',['student' => $students[0]['id']]) }}">
						<div class="row">
							<div class="col-10">
								<div class="row mb-3">
									<div class="col-sm-4">
										Pimda
									</div>
									<div class="col-sm-8">
										@if(!empty($students[0]['regency']['name']))
										{{ $students[0]['regency']['name'] }}
										@else
										Belum diisi
										@endif
									</div>
								</div>
							</div>
							<div class="col-2 text-right align-self-center">
								<i class="fas fa-chevron-right"></i>
							</div>
						</div>
					</a>
				</div>
				<div class="list-group list-group-flush">
					<a class="list-group-item list-group-item-action border-0" href="{{ route('administration::members.students.district',['student' => $students[0]['id']]) }}">
						<div class="row">
							<div class="col-10">
								<div class="row mb-3">
									<div class="col-sm-4">
										Cabang
									</div>
									<div class="col-sm-8">
										@if(!empty($students[0]['district']['name']))
										{{ $students[0]['district']['name'] }}
										@else
										Belum diisi
										@endif
									</div>
								</div>
							</div>
							<div class="col-2 text-right align-self-center">
								<i class="fas fa-chevron-right"></i>
							</div>
						</div>
					</a>
				</div>
			</div>
		</div>
	</div>
	<p class="text-center text-secondary mt-4 mb-0">Hanya Anda yang dapat mengakses halaman ini, kami berkomitmen untuk menjaga privasi Anda.</p>
@endsection