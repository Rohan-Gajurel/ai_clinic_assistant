@extends('frontend.layout')

@section('main')
<main id="main" class="py-5">
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-lg-10">
				<div class="card">
					<div class="card-header d-flex justify-content-between align-items-center">
						<h5 class="mb-0">My Appointments</h5>
						<a class="btn btn-primary btn-sm" href="{{ route('appointment') }}">Book Appointment</a>
					</div>
					<div class="card-body">
						@if(isset($appointments) && count($appointments))
							<div class="table-responsive">
								<table class="table table-striped">
									<thead>
										<tr>
											<th>Date</th>
											<th>Time</th>
											<th>Doctor</th>
											<th>Status</th>
											<th>Reason</th>
										</tr>
									</thead>
									<tbody>
										@foreach($appointments as $a)
											<tr>
												<td>{{ $a->appointment_date ? \Carbon\Carbon::parse($a->appointment_date)->format('Y-m-d') : 'N/A' }}</td>
												<td>
													{{ $a->start_time ? \Carbon\Carbon::parse($a->start_time)->format('H:i') : '--' }}
													- {{ $a->end_time ? \Carbon\Carbon::parse($a->end_time)->format('H:i') : '--' }}
												</td>
												<td>{{ optional($a->doctor->user)->name ?? 'Doctor #' . $a->doctor_id }}</td>
												<td>{{ ucfirst($a->status) }}</td>
												<td class="small text-muted">{{ Str::limit($a->reason ?? '-', 60) }}</td>
											</tr>
										@endforeach
									</tbody>
								</table>
							</div>
						@else
							<p class="text-center text-muted mb-0">You don't have any appointments yet.</p>
						@endif
					</div>
				</div>
			</div>
		</div>
	</div>
</main>
@endsection

