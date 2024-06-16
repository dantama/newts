@extends('administration::layouts.default')

@section('title', $cadres['user']['profile']['name'].' - ')

@section('content')
	<div class="text-center mb-4">
		<h3 class="mb-1">Cadre Profile</h3>
	</div>
	<div class="row">
		<div class="col-sm-4">
			<div class="card mb-4 shadow">
				<div class="card-body text-center">
					<div class="py-4">
						@if(!empty($cadres['user']['profile']['avatar']))
							<img class="rounded-circle" src={{ $cadres['user']['profile']['avatar_path'] }} alt="{{ $cadres['user']['profile']['avatar'] }}" width="128">
						@else
							<img class="rounded-circle" src="{{ asset('img/default-avatar.svg') }}" alt="" width="128">
						@endif	
					</div>
					<h5 class="mb-1"><strong>{{ $cadres['user']['profile']['name'] }}</strong></h5>
					<p>@ {{ $cadres['user']['username'] }}</p>
					<h4 class="mb-0">
						@if($cadres['user']['phone']['whatsapp'])
							<a class="text-success px-1" href="https://wa.me/{{ $cadres['user']['phone']['number'] }}" target="_blank"><i class="fa fa-comment"></i></a>
						@endif
						@if($cadres['user']['email']['verified_at'])
							<a class="text-danger px-1" href="mailto:{{ $cadres['user']['email']['address'] }}"><i class="fa fa-envelope"></i></a>
						@endif
						@if(auth()->user()->isManagerCenters())
							@if($cadres['nbts'])
								<a target="_blank" class="text-primary px-1" href="{{ route('administration::members.perwil-cadres.card', ['perwil_cadre' => $cadres['id']]) }}"><i class="fa fa-credit-card"></i></a>
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
						'join at' => $cadres['user']['created_at'] ? $cadres['created_at']->diffForHumans() : '-',
					] as $k => $v)
						<div class="list-group-item border-0">
							{{ $k }} <br>
							<span class="{{ $v ? 'font-weight-bold' : 'text-muted' }}">
								{{ $v ?? 'empty data' }}
							</span>
						</div>
					@endforeach
					<div class="list-group-item border-0 text-muted">
						<i class="fas fa-student-circle"></i> User ID : {{ $cadres['user']['id'] }}
					</div>
				</div>
			</div>
			<div class="card mb-4 shadow">
				<div class="card-body">
					<h4 class="mb-1">Levels information</h4>
					<p class="mb-2 text-muted">About your levels</p>
				</div>
				<div class="list-group list-group-flush">	
					@if(!empty($cadres['levels']))
						@foreach($cadres['levels'] as $level)
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
					@if(!empty($cadres['user']['achievements']))
						@foreach($cadres['user']['achievements'] as $achievement)
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
						<a class="dropdown-item" href="{{ route('administration::members.perwil-cadres.avatar',['perwil_cadre' => $cadres['id']]) }}"><i class="fas fa-edit"></i> Change avatar</a>
						@if(auth()->user()->isManagerCenters())
						<a class="dropdown-item" href="{{ route('administration::members.perwil-cadres.level',['perwil_cadre' => $cadres['id']]) }}"><i class="fas fa-edit"></i> Change levels</a>
						@endif
					</div>
				</div>
				<div class="card-body">
					<h4 class="mb-1">Profile</h4>
					<p class="mb-2 text-muted">some information may see by another</p>
				</div>
				<div class="list-group list-group-flush">
					@foreach([
						'Fullname' => [$cadres['user']['profile']['full_name'], route('administration::members.perwil-cadres.profile',['perwil_cadre' => $cadres['id']])],
						'Place of birth' => [$cadres['user']['profile']['pob'], route('administration::members.perwil-cadres.profile',['perwil_cadre' => $cadres['id']])],
						'date of birth' => [$cadres['user']['profile']['dob_name'], route('administration::members.perwil-cadres.profile',['perwil_cadre' => $cadres['id']])],
						'Sex' => [$cadres['user']['profile']['sex_name'], route('administration::members.perwil-cadres.profile',['perwil_cadre' => $cadres['id']])],
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
						'E-mail address' => [$cadres['user']['email']['address'], ($cadres['user']['email']['verified_at'] ? ' <span class="badge badge-pill badge-success font-weight-normal">Terverifikasi</span>' : ' <span class="badge badge-pill badge-danger font-weight-normal">Belum verifikasi</span>'), route('administration::members.perwil-cadres.email',['perwil_cadre' => $cadres['id']])],
						'Phone number' => [$cadres['user']['phone']['number'], ($cadres['user']['phone']['whatsapp'] ? ' <i class="fas fa-whatsapp text-success"></i>' : null), route('administration::members.perwil-cadres.phone',['perwil_cadre' => $cadres['id']])],
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
						'Address' => [$cadres['user']['address']['address'], route('administration::members.perwil-cadres.address',['perwil_cadre' => $cadres['id']])],
					] as $k => $v)
						<a class="list-group-item list-group-item-action border-0" href="{{ route('administration::members.perwil-cadres.address',['perwil_cadre' => $cadres['id']]) }}">
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
						<a class="list-group-item list-group-item-action border-0" href="{{ route('administration::members.perwil-cadres.organizations',['perwil_cadre' => $cadres['id']]) }}">
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
											@if(!empty($cadres['perwildata']['name']))
												{{ $cadres['perwildata']['name'] }}
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
						@if(!empty($cadres['user']['profile']['avatar']))
							<a class="list-group-item list-group-item-action border-0" href="{{ auth()->user()->isManagerCenters() ? route('administration::members.perwil-cadres.nbts',['perwil_cadre' => $cadres['id']]) : 'javascript:;' }}">
								<div class="row">
									<div class="col-10">
										<div class="row mb-3">
											<div class="col-sm-4">
												NBTS
											</div>
											<div class="col-sm-8">
												@if(!empty($cadres['nbts']))
													{{ $cadres['nbts'] }}
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
						<a class="list-group-item list-group-item-action border-0" href="{{ auth()->user()->isManagerCenters() ? route('administration::members.perwil-cadres.nbm',['perwil_cadre' => $cadres['id']]) : 'javascript:;' }}">
							<div class="row">
								<div class="col-10">
									<div class="row mb-3">
										<div class="col-sm-4">
											NBM
										</div>
										<div class="col-sm-8">
											@if(!empty($cadres['nbm']))
												{{ $cadres['nbm'] }}
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
						<a class="list-group-item list-group-item-action border-0" href="{{ auth()->user()->isManagerCenters() ? route('administration::members.perwil-cadres.joined',['perwil_cadre' => $cadres['id']]) : 'javascript:;' }}">
							<div class="row">
								<div class="col-10">
									<div class="row mb-3">
										<div class="col-sm-4">
											Join at
										</div>
										<div class="col-sm-8">
											{{ !empty($cadres['joined_at']) ? $cadres['joined_at'] : 'empty data' }}
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