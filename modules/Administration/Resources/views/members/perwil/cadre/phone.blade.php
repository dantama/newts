@extends('administration::layouts.default')

@section('title', 'Edit Pendekar')

@section('content')
<div class="row justify-content-center">
	<div class="col-md-8">
		<h4 class="font-weight-bold mb-4">
			<a class="text-decoration-none small" href="{{ route('administration::members.perwil-cadres.show',['perwil_cadre' => $members['id']]) }}"> <i class="fa fa-arrow-circle-left"></i></a> Cadre Profile
		</h4>
		<div class="card border-0 shadow mb-4">
			<div class="card-body m-3">
				<form class="form-block" action="{{ route('administration::members.perwil-cadres.phone-update', ['perwil_cadre' => $members['user']['id']]) }}" method="POST"> @csrf @method('PUT')
					<div class="form-row">
						<div class="form-group col-md-12">
							<label for="inputEmail4">Phone number</label>
							<div class="input-group">
								<div class="input-group-prepend">
									<span class="input-group-text"><i class="fas fa-phone"></i></span>
								</div>
								<input type="text" name="phone" class="form-control" data-inputmask="'mask': ['999-999-9999 [x99999]', '+099 99 99 9999[9]-9999']" data-mask="" im-insert="true" required>
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="form-check">
							<input class="form-check-input" type="checkbox" id="wa" name="wa" value="1">
							<label class="form-check-label" for="gridCheck">
								Whatsapp
							</label>
						</div>
					</div>
					<button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-paper-plane"></i> Update phone</button>
				</form>
			</div>
		</div>
	</div>
</div>
@stop