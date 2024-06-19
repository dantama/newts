@extends('event::layouts.default')

@section('title', 'Pendaftaran event')

@section('content')
<div class="row">
	<div class="col-md-4 order-md-last">
		<div class="card shadow border-0 mb-4">
			<div class="card-header">
				<i class="fas fa-newspaper"></i> Detail event
			</div>
			<div class="card-body">
				<div class="mb-3">
					<span class="badge badge-pill badge-danger">{{ $event->type->name ?? 'Umum' }}</span>
				</div>
				<h3 class="font-weight-bold">{{ $event->name }}</h3>
				<div>{{ $event->timeRange() ?? 'Waktu tidak ditentukan' }}</div>
				<hr>
				<p>{{ $event->content }}</p>
				<hr>
				<div>
					@if($event->registrable && $event->price)
						<small>Biaya registrasi <strong>Rp {{ number_format($event->price, 0, ',', '.') }}</strong></small>
					@endif
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-8">
		@if($registered_users)
			<div class="card shadow border-0 mb-4">
				<div class="card-header">
					<i class="fas fa-newspaper"></i> Data pendaftaran
				</div>
				@error('file')
					<div class="alert alert-danger alert-dismissible fade show border-0 rounded-0 mb-0" role="alert">
						<button type="button" class="close">&times;</button>
					  	<strong>Gagal!</strong> {{ $message }}
					</div>
				@enderror
				<div class="table-responsive">
					<table class="table table-hover table-striped mb-0">
						<thead class="thead-dark">
							<tr>
								<th>No</th>
								<th>Ref ID</th>
								<th>Peserta</th>
								<th>Biaya</th>
								<th>Berkas</th>
							</tr>
						</thead>
						<tbody>
							@foreach($registered_users->groupBy('refid') as $refid => $registrants)
								@php($file = $registrants->first()->file)
								<tr>
									<td>{{ $loop->iteration }}</td>
									<td nowrap>{{ $refid }}</td>
									<td nowrap><a data-registrants="{{ $registrants }}" data-toggle="modal" data-target="#modal-registrants" href="#">{{ $registrants->count() }} peserta</a></td>
									<td nowrap>Rp {{ number_format($event->price * $registrants->count(), 0, ',', '.') }}</td>
									<td nowrap class="py-2">
										@if($file)
											<i class="fas fa-check-circle text-success"></i>
											<a class="text-success" href="{{ Storage::url($file) }}" target="_blank">Lihat file</a>
										@else
											<form action="{{ route('event::register.payment', ['refid' => $refid]) }}" method="post" enctype="multipart/form-data"> @csrf
												<div class="input-group">
													<div class="custom-file">
														<input type="file" class="custom-file-input" id="upload-input" name="file" accept="image/*">
														<label class="custom-file-label" for="upload-input">Choose file</label>
													</div>
													<div class="input-group-append">
														<button class="btn btn-danger btn-sm px-3"><i class="fas fa-paper-plane"></i></button>
													</div>
												</div>
											</form>
										@endif
									</td>
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		@endif
		<div class="card shadow border-0 mb-4">
			<div class="card-header">
				<i class="fas fa-newspaper"></i> Formulir registrasi
			</div>
			<div class="card-body">
				<form action="{{ route('event::register.store', ['event' => $event->id, 'next' => request('next')]) }}" method="POST"> @csrf
					<div class="row mb-4">
						@if($state == 0)
						<div class="col-md-12">
							<label>Siswa</label>
							<div class="pl-2">
								<div class="custom-control custom-checkbox">
									<input type="checkbox" class="custom-control-input" id="input-students">
									<label class="custom-control-label" for="input-students">Centang untuk semua</label>
								</div>
							</div>
							<div class="border rounded p-2" style="height: 300px; overflow-y: auto;">
								@foreach($students as $student)
									@if(!$registered_users->pluck('user_id')->contains($student->user->id))
										<div class="custom-control custom-checkbox">
											<input type="checkbox" class="custom-control-input input-students input-users" id="student-{{ $student->user->id }}" name="users[{{ $student->user->id }}]" value="{{ $student->levels->first()->level_id ?? null }}" @if(!$student->levels->first()) disabled @endif>
											<label class="custom-control-label" for="student-{{ $student->user->id }}">{{ $student->user->profile->name.' ('.($student->levels->first()->detail->name ?? 'Tidak ada tingkat').')' }}</label>
										</div>
									@endif
								@endforeach
							</div>
						</div>
						@elseif($state == 1)
						<div class="col-md-12">
							<label>Anggota</label>
							<div class="pl-2">
								<div class="custom-control custom-checkbox">
									<input type="checkbox" class="custom-control-input" id="input-members">
									<label class="custom-control-label" for="input-members">Centang untuk semua</label>
								</div>
							</div>
							<div class="border rounded p-2" style="height: 300px; overflow-y: auto;">
								@foreach($members as $member)
									@if(!$registered_users->pluck('user_id')->contains($member->user->id))
										<div class="custom-control custom-checkbox">
											<input type="checkbox" class="custom-control-input input-members input-users" id="member-{{ $member->user->id }}" name="users[{{ $member->user->id }}]" value="{{ $member->levels->first()->level_id ?? null }}" @if(!$member->levels->first()) disabled @endif>
											<label class="custom-control-label" for="member-{{ $member->user->id }}">{{ $member->user->profile->name.' ('.($member->levels->first()->detail->name ?? 'Tidak ada tingkat').')' }}</label>
										</div>
									@endif
								@endforeach
							</div>
						</div>
						@endif
					</div>
					<div class="form-group">
						<label>Biaya pendaftaran</label>
						<h5 class="mb-0"><span id="users-count">0</span> peserta &times; {{ number_format($event->price, 0, ',', '.') }} = Rp <span id="users-pay">0.00</span></h5>
					</div>
					<div class="form-group mb-0">
						<button class="btn btn-danger">Daftar sekarang!</button>
						<a class="btn btn-secondary" href="{{ request('next', route('event::home')) }}">Kembali</a>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
@stop

@push('script')
<div class="modal fade" id="modal-registrants" tabindex="-1">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Daftar peserta</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<ul class="pl-3" id="modal-registrants-lists"></ul>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
<script>
	$(() => {
		$('#modal-registrants').on('show.bs.modal', (e) => {
			$('#modal-registrants-lists').html('');
			$(e.relatedTarget).data('registrants').forEach((v, i) => {
				$('#modal-registrants-lists').append($('<li>', {
					text: `${v.user.profile.name} (${v.level.name})`
				}));
			})
		});
		$('#input-students').change((e) => {
			$('.input-students:not([disabled])').prop('checked', $(e.target).is(':checked'));
		});
		$('#input-members').change((e) => {
			$('.input-members:not([disabled])').prop('checked', $(e.target).is(':checked'));
		});
		$('.input-users, #input-students, #input-members').change((e) => {
			var len = $('.input-users:checked').length;
			$('#users-count').text(len);
			var total = {!! $event->price !!} * len;
			$('#users-pay').text(parseFloat(total, 10).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,").toString());
		});
		$("#upload-input").change(function(e) {
			if (this.files && this.files[0]) {
				$('[for="upload-input"]').html(this.files[0].name)
			}
		});
	})
</script>
@endpush