@extends('administration::layouts.default')

@section('title', 'Edit Pendekar')

@section('content')
<div class="row justify-content-center">
	<div class="col-md-8">
		<h4 class="font-weight-bold mb-4">
			<a class="text-decoration-none small" href="{{ route('administration::members.perwil-warriors.show',['perwil_warrior' => $members['id']]) }}"> <i class="fa fa-arrow-circle-left"></i></a> Warrior Profile
		</h4>
		<div class="card border-0 shadow mb-4">
			<div class="card-body m-3">
				<form class="form-block" action="{{ route('administration::members.perwil-warriors.email-update', ['perwil_warrior' => $members['user']['id']]) }}" method="POST"> @csrf @method('PUT')
					<div class="form-row">
						<div class="form-group col-md-12">
							<label for="inputEmail4">Email</label>
							<div class="input-group mb-3">
								<div class="input-group-prepend">
									<span class="input-group-text"><i class="fas fa-envelope"></i></span>
								</div>
								<input type="email" id="email" name="email" class="form-control" placeholder="Email" required>
							</div> 
						</div>
					</div>
					<button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-paper-plane"></i> Update email</button>
				</form>
			</div>
		</div>
	</div>
</div>
@stop