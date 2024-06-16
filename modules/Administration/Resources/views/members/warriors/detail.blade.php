@extends('administration::layouts.default')

@section('title', $warriors[0]['user']['profile']['name'].' - ')

@section('content')
	<div class="text-center mb-4">
		<h3 class="mb-1">Informasi Pendekar</h3>
	</div>
	<div class="row">
		<div class="col-sm-4">
			<div class="card mb-4">
				<div class="card-body text-center">
					<div class="py-4">
						@if(!empty($warriors[0]['user']['profile']['avatar']))
							<img class="rounded-circle" src={{ $warriors[0]['user']['profile']['avatar_path'] }} alt="{{ $warriors[0]['user']['profile']['avatar'] }}" width="128">
						@else
							<img class="rounded-circle" src="{{ asset('img/default-avatar.svg') }}" alt="" width="128">
						@endif	
					</div>
					<h5 class="mb-1"><strong>{{ $warriors[0]['user']['profile']['name'] }}</strong></h5>
					<p>@ {{ $warriors[0]['user']['username'] }}</p>
					<h4 class="mb-0">
						@if($warriors[0]['user']['phone']['whatsapp'])
							<a class="text-success px-1" href="https://wa.me/{{ $warriors[0]['user']['phone']['number'] }}" target="_blank"><i class="fa fa-comment"></i></a>
						@endif
						@if($warriors[0]['user']['email']['verified_at'])
							<a class="text-danger px-1" href="mailto:{{ $warriors[0]['user']['email']['address'] }}"><i class="fa fa-envelope"></i></a>
						@endif
						@if(auth()->user()->isManagerCenters())
							@if($warriors[0]['nbts'])
								<a target="_blank" class="text-primary px-1" href="{{ route('administration::members.warriors.card', ['warrior' => $warriors[0]['id']]) }}"><i class="fa fa-credit-card"></i></a>
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
						'Bergabung pada' => $warriors[0]['user']['created_at'] ? $warriors[0]['created_at']->diffForHumans() : '-',
					] as $k => $v)
						<div class="list-group-item border-0">
							{{ $k }} <br>
							<span class="{{ $v ? 'font-weight-bold' : 'text-muted' }}">
								{{ $v ?? 'Belum diisi' }}
							</span>
						</div>
					@endforeach
					<div class="list-group-item border-0 text-muted">
						<i class="fas fa-student-circle"></i> User ID : {{ $warriors[0]['user']['id'] }}
					</div>
				</div>
			</div>
			<div class="card mb-4">
				<div class="card-body">
					<h4 class="mb-1">Info Ketingkatan</h4>
					<p class="mb-2 text-muted">Informasi tentang riwayat tingkat keanggotaan</p>
				</div>
				<div class="list-group list-group-flush">	
					@if(!empty($warriors[0]['levels']))
						@foreach($warriors[0]['levels'] as $level)
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
					@if(!empty($warriors[0]['user']['achievements']))
						@foreach($warriors[0]['user']['achievements'] as $achievement)
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
						<a class="dropdown-item" href="{{ route('administration::members.warriors.avatar',['warrior' => $warriors[0]['id']]) }}"><i class="fas fa-edit"></i> Ubah foto</a>
						@if(auth()->user()->isManagerCenters())
						<a class="dropdown-item" href="{{ route('administration::members.warriors.level',['warrior' => $warriors[0]['id']]) }}"><i class="fas fa-edit"></i> Ubah Tingkat</a>
						@endif
					</div>
				</div>
				<div class="card-body">
					<h4 class="mb-1">Profil</h4>
					<p class="mb-2 text-muted">Beberapa info mungkin terlihat oleh orang lain</p>
				</div>
				<div class="list-group list-group-flush">
					@foreach([
						'Nama lengkap' => [$warriors[0]['user']['profile']['full_name'], route('administration::members.warriors.profile',['warrior' => $warriors[0]['id']])],
						'Tempat lahir' => [$warriors[0]['user']['profile']['pob'], route('administration::members.warriors.profile',['warrior' => $warriors[0]['id']])],
						'Tanggal lahir' => [$warriors[0]['user']['profile']['dob_name'], route('administration::members.warriors.profile',['warrior' => $warriors[0]['id']])],
						'Jenis kelamin' => [$warriors[0]['user']['profile']['sex_name'], route('administration::members.warriors.profile',['warrior' => $warriors[0]['id']])],
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
						'Alamat e-mail' => [$warriors[0]['user']['email']['address'], ($warriors[0]['user']['email']['verified_at'] ? ' <span class="badge badge-pill badge-success font-weight-normal">Terverifikasi</span>' : ' <span class="badge badge-pill badge-danger font-weight-normal">Belum verifikasi</span>'), route('administration::members.warriors.email',['warrior' => $warriors[0]['id']])],
						'Nomor HP' => [$warriors[0]['user']['phone']['number'], ($warriors[0]['user']['phone']['whatsapp'] ? ' <i class="fas fa-whatsapp text-success"></i>' : null), route('administration::members.warriors.phone',['warrior' => $warriors[0]['id']])],
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
						'Alamat' => [$warriors[0]['user']['address']['address'], route('administration::members.warriors.address',['warrior' => $warriors[0]['id']])],
					] as $k => $v)
						<a class="list-group-item list-group-item-action border-0" href="{{ route('administration::members.warriors.address',['warrior' => $warriors[0]['id']]) }}">
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
						<a class="list-group-item list-group-item-action border-0" href="{{ route('administration::members.warriors.organizations',['warrior' => $warriors[0]['id']]) }}">
						@else
						<a class="list-group-item list-group-item-action border-0" href="#">
						@endif	
							<div class="row">
								<div class="col-10">
									<div class="row mb-3">
										<div class="col-sm-4">
											Pimda
										</div>
										<div class="col-sm-8">
											@if(!empty($warriors[0]['regency']['name']))
												{{ $warriors[0]['regency']['name'] }}
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
						<a class="list-group-item list-group-item-action border-0" href="{{ route('administration::members.warriors.nbts',['warrior' => $warriors[0]['id']]) }}">
						@else
						<a class="list-group-item list-group-item-action border-0" href="#">
						@endif
							<div class="row">
								<div class="col-10">
									<div class="row mb-3">
										<div class="col-sm-4">
											NBTS
										</div>
										<div class="col-sm-8">
											@if(!empty($warriors[0]['nbts']))
												{{ $warriors[0]['nbts'] }}
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
						<a class="list-group-item list-group-item-action border-0" href="{{ route('administration::members.warriors.nbm',['warrior' => $warriors[0]['id']]) }}">
						@else
						<a class="list-group-item list-group-item-action border-0" href="#">
						@endif
							<div class="row">
								<div class="col-10">
									<div class="row mb-3">
										<div class="col-sm-4">
											NBM
										</div>
										<div class="col-sm-8">
											@if(!empty($warriors[0]['nbm']))
												{{ $warriors[0]['nbm'] }}
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
						<a class="list-group-item list-group-item-action border-0" href="{{ route('administration::members.warriors.joined',['warrior' => $warriors[0]['id']]) }}">
						@else
						<a class="list-group-item list-group-item-action border-0" href="#">
						@endif
							<div class="row">
								<div class="col-10">
									<div class="row mb-3">
										<div class="col-sm-4">
											Tahun bergabung
										</div>
										<div class="col-sm-8">
											{{ !empty($warriors[0]['joined_at']) ? $warriors[0]['joined_at'] : 'Belum diisi' }}
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