@extends('admin.layout.header')

@section('main-container')
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
								<form class="row g-2" method="post" action="{{route('leaveDateUpdate')}}">
                                    @csrf
                                    <input type="hidden" name="id" value="{{$leaveDateEdit->id}}"/>

									{{-- <div class="col-md-2"></div> --}}
									<div class="col-lg-3">
										<label class="form-label">Start Date</label>
										<input type="date" class="form-control" id="exampleInputEmail1"
											aria-describedby="emailHelp" placeholder="" name="start_date" value="{{$leaveDateEdit->start_date}}">

									</div>

                                    <div class="col-lg-3">
										<label class="form-label">End Date</label>
										<input type="date" class="form-control" id="exampleInputEmail1"
											aria-describedby="emailHelp" placeholder="" name="end_date" value="{{$leaveDateEdit->end_date}}">

									</div>
                                <div class="col-lg-2">
                                    <label class="form-label">Start Time</label>
                                    <input type="time" class="single-select" name="start_time" value="{{$leaveDateEdit->start_time}}">
                            </div>

                            <div class="col-lg-2">
                                <label class="form-label">End Time</label>
                                <input type="time" class="single-select" name="end_time" value="{{$leaveDateEdit->end_time}}">
                        </div>
									<div class="col-md-2" style="margin-top:35px;">
										<button type="submit" class="btn btn-success"><i
											class="lni lni-circle-plus"></i>Update</button>
									</div>
								</form>

							{{-- </div> --}}

						</div>
					</div>
				</div>



				<!--end page wrapper -->


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
