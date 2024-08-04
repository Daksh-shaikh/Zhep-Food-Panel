@extends('admin.layout.header')

@section('main-container')

{{-- to get only the particular restro leave date --}}
@auth
<?php $authenticatedUser = auth()->user(); ?>
@endauth

<!--start page wrapper -->
		<div class="page-wrapper">
			<div class="page-content">
				<div class="row">
					<div class="col-md-8 mx-auto">


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

								<h6>Leave Management</h6>
								<hr>
								<form class="row g-2" method="post" action="{{route('dateStore')}}">
                                    @csrf
									{{-- <div class="col-md-2"></div> --}}
									<div class="col-lg-3">
										<label class="form-label">Start Date</label>
										<input type="date" class="form-control" id="exampleInputEmail1"
											aria-describedby="emailHelp" placeholder="" name="start_date">

									</div>

                                    <div class="col-lg-3">
										<label class="form-label">End Date</label>
										<input type="date" class="form-control" id="exampleInputEmail1"
											aria-describedby="emailHelp" placeholder="" name="end_date">

									</div>
                                <div class="col-lg-2">
                                    <label class="form-label">Start Time</label>
                                    <input type="time" class="single-select" name="start_time">
                            </div>

                            <div class="col-lg-2">
                                <label class="form-label">End Time</label>
                                <input type="time" class="single-select" name="end_time">
                        </div>
									<div class="col-md-3" style="margin-top:35px;">
										<button type="submit" class="btn btn-success"><i
											class="lni lni-circle-plus"></i>Submit</button>
									</div>
								</form>

							{{-- </div> --}}

						</div>
					</div>
				</div>



				<!--end page wrapper -->
				<!--start overlay-->
				<div class="overlay toggle-icon"></div>
				<hr />
				<div class="col-md-8 mx-auto">
					<div class="card">
						<div class="card-body">
							<div class="table-responsive">
								<table id="example" class="table table-striped table-bordered">
									<thead>
										<tr>
											<th>Sr No</th>
											<th>Start Date</th>
                                            <th>End Date</th>
                                            <th>Start Time</th>
                                            <th>End Time</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>

                                        @if ($authenticatedUser->leaves)

                                        @foreach ($authenticatedUser->leaves->sortByDesc('created_at') as $date)


										<tr>
											<td>{{$loop->index+1}}</td>
											<td>{{$date->start_date}}</td>
                                            <td>{{$date->end_date}}</td>
                                            <td>{{$date->start_time}}</td>
                                            <td>{{$date->end_time}}</td>
											{{-- <td>
                                                        <a href="{{route('leaveDateEdit', $date->id)}}">
                                                            <button type="button" class="btn1 btn-outline-success"><i
                                                                class='bx bx-edit-alt me-0'></i></button></a>



                                                        <a href="{{route('leaveDateDestroy', $date->id)}}">
                                                            <button type="button"
                                                        class="btn1 btn-outline-danger"
                                                        onclick="confirmDelete({{ $date->id }})"><i
                                                            class='bx bx-trash me-0'></i></button>
                                                        </a>
											</td> --}}
                                            <td>
                                                @if(now() > $date->end_date . ' ' . $date->end_time)
                                                    <button type="button" class="btn1 btn-outline-secondary" disabled>Inactive</button>
                                                @else
                                                    <a href="{{route('leaveDateEdit', $date->id)}}">
                                                        <button type="button" class="btn1 btn-outline-success"><i class='bx bx-edit-alt me-0'></i></button>
                                                    </a>

                                                    <a href="{{route('leaveDateDestroy', $date->id)}}">
                                                        <button type="button" class="btn1 btn-outline-danger"
                                                                onclick="confirmDelete({{ $date->id }})"><i class='bx bx-trash me-0'></i></button>
                                                    </a>
                                                @endif
                                            </td>
										</tr>
                                        @endforeach
                                        @endif
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
        function confirmDelete(leaveId) {
            var result = confirm('Are you sure you want to delete this Leave Date?');
            if (!result) {
                event.preventDefault(); // Prevent the default action (deletion) if user clicks "Cancel"
            } else {
                window.location.href = '{{ url("leaveDateDestroy") }}/' + leaveId;
            }
        }
    </script>
