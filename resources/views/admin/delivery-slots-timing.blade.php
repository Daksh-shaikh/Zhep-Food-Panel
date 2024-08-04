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
								<form class="row g-2" method="post" action="{{route('deliverySlotStore')}}">
                                    @csrf
									<div class="col-lg-2">
											<label class="form-label">Select Day</label>
											<select class="single-select" name="day">
                                                <option value="">--select--</option>
                                                {{-- <option >--Select--</option> --}}
												<option >Monday</option>
												<option>Tuesday</option>
												<option>Wednesday</option>
												<option>Thursday</option>
												<option>Friday</option>
												<option>Saturday </option>
												<option>Sunday </option>
											</select>
									</div>
									<div class="col-lg-2">
										<label class="form-label">Select Shift</label>
										<select class="single-select" name="shift">

                                            <option value="">--select--</option>
											<option >Morning</option>
											<option>Evening</option>
											<option>All Day</option>
										</select>
								</div>

									<div class="col-lg-2">
										<label class="form-label">Start Time</label>
										<input type="time" class="form-control timepicker" name="start_time"/>


									</div>

									<div class="col-lg-2">
										<label class="form-label">End Time</label>
										<input type="time" class="form-control timepicker" name="end_time"/>


									</div>



									<div class="col-lg-2"  style="margin-top: 35px;">
										<button type="submit" class="btn btn-success"><i
											class="lni lni-circle-plus"></i>Submit</button>
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
                                        @foreach ($slot as $slot)
										<tr>
											<td>{{$loop->index+1}}</td>
											<td>{{$slot->day}}</td>
											<td>{{$slot->shift}}</td>
											<td>{{$slot->start_time}}</td>
											<td>{{$slot->end_time}}</td>
											<td style="background-color: #ffffff;">


                                                <a href="{{route('deliverySlotEdit', $slot->id)}}">
                                                <button type="button" class="btn1 btn-outline-success"><i
														class='bx bx-edit-alt me-0'></i></button>
                                                    </a>

                                                        {{-- <button type="button"
													class="btn1 btn-outline-danger"><i
														class='bx bx-trash me-0'></i></button> --}}

                                                        <a href="{{route('deliverySlotDestroy', $slot->id)}}">
                                                            <button type="button"
                                                        class="btn1 btn-outline-danger"
                                                        onclick="confirmDelete({{ $slot->id }})"><i
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

