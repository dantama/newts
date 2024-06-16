@extends('administration::layouts.default')

@section('title', $warriors['user']['profile']['name'].' - ')

@section('content')
	<div class="text-center mb-4">
		<h3 class="mb-1">Warrior Profile</h3>
	</div>
	<div class="row">
		<div class="col-sm-4">
			<div class="card mb-4 shadow">
				<div class="card-body text-center">
					<div class="py-4">
						@if(!empty($warriors['user']['profile']['avatar']))
							<img class="rounded-circle" src={{ $warriors['user']['profile']['avatar_path'] }} alt="{{ $warriors['user']['profile']['avatar'] }}" width="128">
						@else
							<img class="rounded-circle" src="{{ asset('img/default-avatar.svg') }}" alt="" width="128">
						@endif	
					</div>
					<h5 class="mb-1"><strong>{{ $warriors['user']['profile']['name'] }}</strong></h5>
					<p>@ {{ $warriors['user']['username'] }}</p>
					<h4 class="mb-0">
						@if($warriors['user']['phone']['whatsapp'])
							<a class="text-success px-1" href="https://wa.me/{{ $warriors['user']['phone']['number'] }}" target="_blank"><i class="fa fa-comment"></i></a>
						@endif
						@if($warriors['user']['email']['verified_at'])
							<a class="text-danger px-1" href="mailto:{{ $warriors['user']['email']['address'] }}"><i class="fa fa-envelope"></i></a>
						@endif
						@if(auth()->user()->isManagerCenters())
							@if($warriors['nbts'])
								<a target="_blank" class="text-primary px-1" href="{{ route('administration::members.perwil-warriors.card', ['perwil_warrior' => $warriors['id']]) }}"><i class="fa fa-credit-card"></i></a>
							@endif
						@endif
					</h4>
				</div>
			</div>
			<div class="card mb-4 shadow">
				<div class="card-body">
					<h4 class="mb-1">Account information</h4>
					<p class="mb-2 text-muted">About your account, only you can see this</p>
				</div>
				<div class="list-group list-group-flush">
					@foreach([
						'join at' => $warriors['user']['created_at'] ? $warriors['created_at']->diffForHumans() : '-',
					] as $k => $v)
						<div class="list-group-item border-0">
							{{ $k }} <br>
							<span class="{{ $v ? 'font-weight-bold' : 'text-muted' }}">
								{{ $v ?? 'empty data' }}
							</span>
						</div>
					@endforeach
					<div class="list-group-item border-0 text-muted">
						<i class="fas fa-student-circle"></i> User ID : {{ $warriors['user']['id'] }}
					</div>
				</div>
			</div>
			<div class="card mb-4 shadow">
				<div class="card-body">
					<h4 class="mb-1">Levels information</h4>
					<p class="mb-2 text-muted">About your levels</p>
				</div>
				<div class="list-group list-group-flush">	
					@if(!empty($warriors['levels']))
						@foreach($warriors['levels'] as $level)
							@if($loop->last)
								<div class="list-group-item border-0 text-muted">
									<i class="fas fa-student-circle"></i> <b>{{ $level['detail']->name }}</b> year : {{ $level->year }} 
								</div>
							@endif
						@endforeach
					@else
					<div class="list-group-item border-0 text-muted">
						<i class="fas fa-student-circle"></i> empty data
					</div>
					@endif	
				</div>
			</div>
			<div class="card mb-4 shadow">
				<div class="card-body">
					<h4 class="mb-1">Achievements information</h4>
					<p class="mb-2 text-muted">About your achievement</p>	
				</div>
				<div class="list-group list-group-flush">	
					@if(!empty($warriors['user']['achievements']))
						@foreach($warriors['user']['achievements'] as $achievement)
						<div class="list-group-item border-0 text-muted">
							<i class="fas fa-student-circle"></i> <b>{{ $achievement->name }}</b> year : {{ $achievement->year }} 
						</div>
						@endforeach
					@else
					<div class="list-group-item border-0 text-muted">
						<i class="fas fa-student-circle"></i> empty data
					</div>
					@endif	
				</div>
			</div>
		</div>
		<div class="col-sm-8">
			<div class="card mb-4 shadow">
				<div class="dropdown position-absolute" style="top: .3em; right: 0;">
					<a class="btn btn-link text-secondary" href="javascript:;" id="dropdown" data-toggle="dropdown"><i class="fas fa-ellipsis-v"></i></a>
					<div class="dropdown-menu dropdown-menu-right border-0 shadow">
						<a class="dropdown-item" href="{{ route('administration::members.perwil-warriors.avatar',['perwil_warrior' => $warriors['id']]) }}"><i class="fas fa-edit"></i> Change avatar</a>
						@if(auth()->user()->isManagerCenters())
						<a class="dropdown-item" href="{{ route('administration::members.perwil-warriors.level',['perwil_warrior' => $warriors['id']]) }}"><i class="fas fa-edit"></i> Change levels</a>
						@endif
					</div>
				</div>
				<div class="card-body">
					<h4 class="mb-1">Profile</h4>
					<p class="mb-2 text-muted">some information may see by another</p>
				</div>
				<div class="list-group list-group-flush">
					@foreach([
						'Fullname' => [$warriors['user']['profile']['full_name'], route('administration::members.perwil-warriors.profile',['perwil_warrior' => $warriors['id']])],
						'Place of birth' => [$warriors['user']['profile']['pob'], route('administration::members.perwil-warriors.profile',['perwil_warrior' => $warriors['id']])],
						'date of birth' => [$warriors['user']['profile']['dob_name'], route('administration::members.perwil-warriors.profile',['perwil_warrior' => $warriors['id']])],
						'Sex' => [$warriors['user']['profile']['sex_name'], route('administration::members.perwil-warriors.profile',['perwil_warrior' => $warriors['id']])],
					] as $k => $v)
						<a class="list-group-item list-group-item-action border-0" href="{{ $v[1] }}">
							<div class="row">
								<div class="col-10">
									<div class="row">
										<div class="col-sm-4">
											<small>{{ $k }}</small>
										</div>
										<div class="col-sm-8">
											<span class="{{ $v ? 'font-weight-bold' : 'text-muted' }}">
												{{ $v[0] ?? 'empty data' }}
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
			<div class="card mb-4 shadow">
				<div class="card-body">
					<h4 class="mb-1">Contact information</h4>
				</div>
				<div class="list-group list-group-flush">
					@foreach([
						'E-mail address' => [$warriors['user']['email']['address'], ($warriors['user']['email']['verified_at'] ? ' <span class="badge badge-pill badge-success font-weight-normal">Terverifikasi</span>' : ' <span class="badge badge-pill badge-danger font-weight-normal">Belum verifikasi</span>'), route('administration::members.perwil-warriors.email',['perwil_warrior' => $warriors['id']])],
						'Phone number' => [$warriors['user']['phone']['number'], ($warriors['user']['phone']['whatsapp'] ? ' <i class="fas fa-whatsapp text-success"></i>' : null), route('administration::members.perwil-warriors.phone',['perwil_warrior' => $warriors['id']])],
					] as $k => $v)
						<a class="list-group-item list-group-item-action border-0" href="{{ $v[2] }}">
							<div class="row">
								<div class="col-10">
									<div class="row">
										<div class="col-sm-4">
											<small>{{ $k }}</small>
										</div>
										<div class="col-sm-8">
											<span class="{{ $v ? 'font-weight-bold' : 'text-muted' }}">
												{!! $v[0] ? $v[0].$v[1] : 'empty data' !!}
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
			<div class="card mb-4 shadow">
				<div class="card-body">
					<h4 class="mb-1">Address information</h4>
				</div>
				<div class="list-group list-group-flush">
					@foreach([
						'Address' => [$warriors['user']['address']['address'], route('administration::members.perwil-warriors.address',['perwil_warrior' => $warriors['id']])],
					] as $k => $v)
						<a class="list-group-item list-group-item-action border-0" href="{{ route('administration::members.perwil-warriors.address',['perwil_warrior' => $warriors['id']]) }}">
							<div class="row">
								<div class="col-10">
									<div class="row">
										<div class="col-sm-4">
											<small>{{ $k }}</small>
										</div>
										<div class="col-sm-8">
											<span class="{{ $v ? 'font-weight-bold' : 'text-muted' }}">
												{!! $v[0] ?? 'empty data' !!}
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
			<div class="card mb-4 shadow">
				<div class="card-body">
					<h4 class="mb-1">Organization</h4>
				</div>
				<div class="list-group list-group-flush">
						@if(auth()->user()->isManagerCenters())
						<a class="list-group-item list-group-item-action border-0" href="{{ route('administration::members.perwil-warriors.organizations',['perwil_warrior' => $warriors['id']]) }}">
						@else
						<a class="list-group-item list-group-item-action border-0" href="#">
						@endif	
							<div class="row">
								<div class="col-10">
									<div class="row mb-3">
										<div class="col-sm-4">
											Perwil
										</div>
										<div class="col-sm-8">
											@if(!empty($warriors['perwildata']['name']))
												{{ $warriors['perwildata']['name'] }}
											@else
												empty data
											@endif
										</div>
									</div>
								</div>
								<div class="col-2 text-right align-self-center">
									<i class="fas fa-chevron-right"></i>
								</div>
							</div>
						</a>
						@if(!empty($warriors['user']['profile']['avatar']))
							<a class="list-group-item list-group-item-action border-0" href="{{ auth()->user()->isManagerCenters() ? route('administration::members.perwil-warriors.nbts',['perwil_warrior' => $warriors['id']]) : 'javascript:;' }}">
								<div class="row">
									<div class="col-10">
										<div class="row mb-3">
											<div class="col-sm-4">
												NBTS
											</div>
											<div class="col-sm-8">
												@if(!empty($warriors['nbts']))
													{{ $warriors['nbts'] }}
												@else
													empty data
												@endif
											</div>
										</div>
									</div>
									<div class="col-2 text-right align-self-center">
										<i class="fas fa-chevron-right"></i>
									</div>
								</div>
							</a>
						@else
						@endif
						<a class="list-group-item list-group-item-action border-0" href="{{ auth()->user()->isManagerCenters() ? route('administration::members.perwil-warriors.nbm',['perwil_warrior' => $warriors['id']]) : 'javascript:;' }}">
							<div class="row">
								<div class="col-10">
									<div class="row mb-3">
										<div class="col-sm-4">
											NBM
										</div>
										<div class="col-sm-8">
											@if(!empty($warriors['nbm']))
												{{ $warriors['nbm'] }}
											@else
												empty data
											@endif
										</div>
									</div>
								</div>
								<div class="col-2 text-right align-self-center">
									<i class="fas fa-chevron-right"></i>
								</div>
							</div>
						</a>
						<a class="list-group-item list-group-item-action border-0" href="{{ auth()->user()->isManagerCenters() ? route('administration::members.perwil-warriors.joined',['perwil_warrior' => $warriors['id']]) : 'javascript:;' }}">
							<div class="row">
								<div class="col-10">
									<div class="row mb-3">
										<div class="col-sm-4">
											Join at
										</div>
										<div class="col-sm-8">
											{{ !empty($warriors['joined_at']) ? $warriors['joined_at'] : 'empty data' }}
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
	{{-- <p class="text-center text-secondary mt-4 mb-0">Only you can access this page, we are committed to maintaining your privacy.</p> --}}
@endsection