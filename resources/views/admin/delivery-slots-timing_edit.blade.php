@extends('admin.layout.header')

@section('main-container')
		<!--start page wrapper -->
		<div class="page-wrapper">
			<div class="page-content">
				<div class="row">
					<div class="col-md-12 mx-auto">


                        @if ($errors->any())
                        <div class="alert alert-danger mt-2">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif



						<div class="card">
							<div class="card-body">

								<h6>Add Delivery Slots & Timing</h6>
								<hr>
								<form class="row g-2" method="post" action="{{route('deliverySlotUpdate')}}">
                                    @csrf
									<div class="col-lg-2">
                                        <input type="hidden" name="id" value="{{$deliveryEdit->id}}"/>
											<label class="form-label">Select Day</label>
											<select class="single-select" name="day">
                                                <option value="">--select--</option>
                                                <option value="Monday" {{ $deliveryEdit->day == 'Monday' ? 'selected' : '' }}>Monday</option>
                                                <option value="Tuesday" {{ $deliveryEdit->day == 'Tuesday' ? 'selected' : '' }}>Tuesday</option>
                                                <option value="Wednesday" {{ $deliveryEdit->day == 'Wednesday' ? 'selected' : '' }}>Wednesday</option>
                                                <option value="Thursday" {{ $deliveryEdit->day == 'Thursday' ? 'selected' : '' }}>Thursday</option>
                                                <option value="Friday" {{ $deliveryEdit->day == 'Friday' ? 'selected' : '' }}>Friday</option>
                                                <option value="Saturday" {{ $deliveryEdit->day == 'Saturday' ? 'selected' : '' }}>Saturday</option>
                                                <option value="Sunday" {{ $deliveryEdit->day == 'Sunday' ? 'selected' : '' }}>Sunday</option>

											</select>
									</div>
									<div class="col-lg-2">
										<label class="form-label">Select Shift</label>
										<select class="single-select" name="shift">
                                            <option value="">--select--</option>
											<option value="Morning" {{$deliveryEdit->shift == 'Morning' ? 'selected' : '' }}>Morning</option>
											<option value="Evening" {{$deliveryEdit->shift == 'Evening' ? 'selected' : '' }}>Evening</option>
											<option value="All Day" {{$deliveryEdit->shift == 'All Day' ? 'selected' : '' }}>All Day</option>
										</select>
								</div>

									<div class="col-lg-2">
										<label class="form-label">Start Time</label>
										<input type="text" class="form-control timepicker"
                                        name="start_time" value="{{$deliveryEdit->start_time}}"/>


									</div>

									<div class="col-lg-2">
										<label class="form-label">End Time</label>
										<input type="text" class="form-control timepicker"
                                        name="end_time" value="{{$deliveryEdit->end_time}}"/>


									</div>



									<div class="col-lg-2"  style="margin-top: 35px;">
										<button type="submit" class="btn btn-success"><i
											class="fa fa-edit"></i>Update</button>
									</div>
								</form>

							</div>

						</div>
					</div>
				</div>



				<!--end page wrapper -->
				<!--start overlay-->
				<div class="overlay toggle-icon"></div>
				<hr />
				<div class="col-md-12 mx-auto">
					<div class="card">
						<div class="card-body">
							<div class="table-responsive">
								<table id="example" class="table table-striped table-bordered">
									<thead>
										<tr>
											<th>Sr No</th>
											<th>Day</th>
											<th>Shift</th>
											<th>Start Time</th>
											<th>End Time</th>

											<th style="background-color: #ffffff;">Action</th>
										</tr>
									</thead>
									<tbody>
                                        @foreach ($delivery as $delivery)
										<tr>
											<td>{{$loop->index+1}}</td>
											<td>{{$delivery->day}}</td>
											<td>{{$delivery->shift}}</td>
											<td>{{$delivery->start_time}}</td>
											<td>{{$delivery->end_time}}</td>
											<td style="background-color: #ffffff;">

                                                        {{-- <button type="button"
													class="btn1 btn-outline-danger"><i
														class='bx bx-trash me-0'></i></button> --}}

                                                        <a href="{{route('deliverySlotDestroy', $delivery->id)}}">
                                                            <button type="button"
                                                        class="btn1 btn-outline-danger"
                                                        onclick="confirmDelete({{ $delivery->id }})"><i
                                                            class='bx bx-trash me-0'></i></button>
                                                        </a>
											</td>
										</tr>
                                        @endforeach
									</tbody>

								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>



		<!--end page wrapper -->

        @endsection

    {{-- to show confirmation alert message while delete --}}
    <script>
        function confirmDelete(slotId) {
            var result = confirm('Are you sure you want to delete this Delivery Slot?');
            if (!result) {
                event.preventDefault(); // Prevent the default action (deletion) if user clicks "Cancel"
            } else {
                window.location.href = '{{ url("deliverySlotDestroy") }}/' + slotId;
            }
        }
    </script>
