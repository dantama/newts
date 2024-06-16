@extends('administration::layouts.default')

@section('title', $members['user']['profile']['name'].' - ')

@section('content')
	<div class="text-center mb-4">
		<h3 class="mb-1">Informasi Anggota</h3>
	</div>
	<div class="row">
		<div class="col-sm-4">
			<div class="card mb-4">
				<div class="card-body text-center">
					<div class="py-4">
						@if(!empty($members['user']['profile']['avatar']))
							<img class="rounded-circle" src={{ $members['user']['profile']['avatar_path'] }} alt="{{ $members['user']['profile']['avatar'] }}" width="128">
						@else
							<img class="rounded-circle" src="{{ asset('img/default-avatar.svg') }}" alt="" width="128">
						@endif	
					</div>
					<h5 class="mb-1"><strong>{{ $members['user']['profile']['name'] }}</strong></h5>
					<p>@ {{ $members['user']['username'] }}</p>
					<h4 class="mb-0">
						@if($members['user']['phone']['whatsapp'])
							<a class="text-success px-1" href="https://wa.me/{{ $members['user']['phone']['number'] }}" target="_blank"><i class="fa fa-comment"></i></a>
						@endif
						@if($members['user']['email']['verified_at'])
							<a class="text-danger px-1" href="mailto:{{ $members['user']['email']['address'] }}"><i class="fa fa-envelope"></i></a>
						@endif
						@if(auth()->user()->isManagerCenters())
							@if($members['nbts'])
								<a target="_blank" class="text-primary px-1" href="javascript:;"><i class="fa fa-credit-card"></i></a>
							@endif
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
						'Bergabung pada' => $members['user']['created_at'] ? $members['created_at']->diffForHumans() : '-',
					] as $k => $v)
						<div class="list-group-item border-0">
							{{ $k }} <br>
							<span class="{{ $v ? 'font-weight-bold' : 'text-muted' }}">
								{{ $v ?? 'Belum diisi' }}
							</span>
						</div>
					@endforeach
					<div class="list-group-item border-0 text-muted">
						<i class="fas fa-student-circle"></i> User ID : {{ $members['user']['id'] }}
					</div>
				</div>
			</div>
			<div class="card mb-4">
				<div class="card-body">
					<h4 class="mb-1">Info Ketingkatan</h4>
					<p class="mb-2 text-muted">Informasi tentang riwayat tingkat keanggotaan</p>
				</div>
				<div class="list-group list-group-flush">	
					@if(!empty($members['levels']))
						@foreach($members['levels'] as $level)
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
					@if(!empty($members['user']['achievements']))
						@foreach($members['user']['achievements'] as $achievement)
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
						<a class="dropdown-item" href="{{ route('administration::members.account.avatar',['account' => $members['id']]) }}"><i class="fas fa-edit"></i> Ubah foto</a>
						{{-- @if(auth()->user()->isManagerCenters())
						<a class="dropdown-item" href="{{ route('administration::members.account.level',['account' => $members['id']]) }}"><i class="fas fa-edit"></i> Ubah Tingkat</a>
						@endif --}}
					</div>
				</div>
				<div class="card-body">
					<h4 class="mb-1">Profil</h4>
					<p class="mb-2 text-muted">Beberapa info mungkin terlihat oleh orang lain</p>
				</div>
				<div class="list-group list-group-flush">
					@foreach([
						'Nama lengkap' => [$members['user']['profile']['full_name'], route('administration::members.account.profile',['account' => $members['id']])],
						'Tempat lahir' => [$members['user']['profile']['pob'], route('administration::members.account.profile',['account' => $members['id']])],
						'Tanggal lahir' => [$members['user']['profile']['dob_name'], route('administration::members.account.profile',['account' => $members['id']])],
						'Jenis kelamin' => [$members['user']['profile']['sex_name'], route('administration::members.account.profile',['account' => $members['id']])],
					] as $k => $v)
						<a class="list-group-item list-group-item-action border-0" href="javascript:;">
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
						'Alamat e-mail' => [$members['user']['email']['address'], ($members['user']['email']['verified_at'] ? ' <span class="badge badge-pill badge-success font-weight-normal">Terverifikasi</span>' : ' <span class="badge badge-pill badge-danger font-weight-normal">Belum verifikasi</span>'), route('administration::members.account.email',['account' => $members['id']])],
						'Nomor HP' => [$members['user']['phone']['number'], ($members['user']['phone']['whatsapp'] ? ' <i class="fas fa-whatsapp text-success"></i>' : null), route('administration::members.account.phone',['account' => $members['id']])],
					] as $k => $v)
						<a class="list-group-item list-group-item-action border-0" href="javascript:;">
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
						'Alamat' => [$members['user']['address']['address'], route('administration::members.account.address',['account' => $members['id']])],
					] as $k => $v)
						<a class="list-group-item list-group-item-action border-0" href="javascript:;">
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
						@if(auth()->user()->isManagerCenters())
						<a class="list-group-item list-group-item-action border-0" href="javascript:;">
						@else
						<a class="list-group-item list-group-item-action border-0" href="javascript:;">
						@endif	
							<div class="row">
								<div class="col-10">
									<div class="row mb-3">
										<div class="col-sm-4">
											Pimda
										</div>
										<div class="col-sm-8">
											@if(!empty($members['regency']['name']))
												{{ $members['regency']['name'] }}
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
						@if(auth()->user()->isManagerCenters())
						<a class="list-group-item list-group-item-action border-0" href="javascript:;">
						@else
						<a class="list-group-item list-group-item-action border-0" href="javascript:;">
						@endif
							<div class="row">
								<div class="col-10">
									<div class="row mb-3">
										<div class="col-sm-4">
											NBTS
										</div>
										<div class="col-sm-8">
											@if(!empty($members['nbts']))
												{{ $members['nbts'] }}
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
						@if(auth()->user()->isManagerCenters())
						<a class="list-group-item list-group-item-action border-0" href="javascript:;">
						@else
						<a class="list-group-item list-group-item-action border-0" href="javascript:;">
						@endif
							<div class="row">
								<div class="col-10">
									<div class="row mb-3">
										<div class="col-sm-4">
											NBM
										</div>
										<div class="col-sm-8">
											@if(!empty($members['nbm']))
												{{ $members['nbm'] }}
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
						@if(auth()->user()->isManagerCenters())
						<a class="list-group-item list-group-item-action border-0" href="javascript:;">
						@else
						<a class="list-group-item list-group-item-action border-0" href="javascript:;">
						@endif
							<div class="row">
								<div class="col-10">
									<div class="row mb-3">
										<div class="col-sm-4">
											Tahun bergabung
										</div>
										<div class="col-sm-8">
											{{ !empty($members['joined_at']) ? $members['joined_at'] : 'Belum diisi' }}
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