@extends('administration::layouts.default')

@section('title', 'Edit NBM')

@section('content')
<div class="row justify-content-center">
	<div class="col-md-8">
		<h4 class="font-weight-bold mb-4">
			<a class="text-decoration-none small" href="{{ route('administration::members.perwil-warriors.show',['perwil_warrior' => $members['id']]) }}"> <i class="fa fa-arrow-circle-left"></i></a> Warrior Profile
		</h4>
		<div class="card border-0 shadow mb-4">
			<div class="card-body m-3">
				<form class="form-block" action="{{ route('administration::members.perwil-warriors.nbm-update',['perwil_warrior' => $members['user']['id']], ['next' => request('next', route('administration::members.perwil-warriors.index'))]) }}" method="POST"> @csrf @method('PUT')
					<div class="form-row">
						<div class="form-group col-md-12">
							<label for="inputState">NBM</label>
							<input type="text" name="nbm" id="nbm" class="form-control @error('nbm') is-invalid @enderror">
						</div>
					</div>
					@error('nbm')
					<div class="alert alert-danger">{{ $message }}</div>
					@enderror
					<button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-paper-plane"></i> Update NBM</button>
				</form>
			</div>
		</div>
	</div>
</div>
@stop