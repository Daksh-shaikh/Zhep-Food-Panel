@extends('frontend.layout.header')

@section('main-container')

		<!--end header -->
		<!--start page wrapper -->
		<div class="page-wrapper">
			<div class="page-content">
				<div class="row">
					<div class="col-md-8 mx-auto">


						<div class="card">
							<div class="card-body">
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


								<h6>Add Banner </h6>
								<hr>
								<form class="row g-2" method='post' action="{{route('bannerStore')}}" enctype="multipart/form-data">
                                    @csrf
									<div class="col-md-1"></div>

                                    <div class="col-lg-3">

                                        <label class="form-label">Select City</label>
											<select class="single-select" name="city" data-live-search="true">

                                                <option value="">--Select--</option>
                                                @foreach ($city as $city_name)
                                                <option value="{{$city_name->id}}">{{$city_name->city}}</option>

                                                @endforeach

											</select>
									</div>

									<div class="col-lg-5">
										<label class="form-label">Upload Banner <span style="color: red; font-size:12px;">(Size 900px*400px)</span></label>
										<input type="file" class="form-control" id="exampleInputEmail1"
											aria-describedby="emailHelp" placeholder="" name="banner">

									</div>
									<div class="col-md-3" style="margin-top:35px;">
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
				<div class="col-md-8 mx-auto">
					<div class="card">
						<div class="card-body">
							<div class="table-responsive">
								<table id="example" class="table table-striped table-bordered">
									<thead>
										<tr>
											<th>Sr No</th>
											<th>Banner</th>
                                            <th>City</th>
                                            {{-- <th>Status</th> --}}
											<th>Action</th>
										</tr>
									</thead>
									<tbody>

                                        @foreach ($banner->sortByDesc('created_at') as $banner)


										<tr>
											<td>{{$loop->index+1}}</td>
											<td>
                                                <a href="{{asset('banner/'. $banner->banner)}}"></a>
                                                <img height="50px" width="50px"  src="{{asset('banner/'. $banner->banner)}}" alt="" />
                                            </td>

                                            <td>
                                                @if($banner->city_name)
                                                    {{$banner->city_name->city}}
                                                @else
                                                    null

                                                @endif

                                            </td>

                                            {{-- <td style="background-color: #ffffff;">
                                                <div class="d-flex align-items-center">

                                                           <?php if ($banner->status=='1'){?>

                                                            <a href="{{url('/update_banner_status', $banner->id)}}"
                                                                class="btn btn-success"> Active</a>

                                                                <?php } else {?>
                                                                <a href="{{url('/update_banner_status', $banner->id)}}"
                                                                    class="btn btn-danger">Inactive</a>
                                                                    <?php
                                                            }?>
                                                            </td> --}}




											<td>
                                                {{-- <a href="{{route('bannerEdit', $banner->id)}}">
                                                <button type="button" class="btn1 btn-outline-success"><i
														class='bx bx-edit-alt me-0'></i></button>
                                                    </a> --}}

                                                        <a href="{{route('bannerDestroy', $banner->id)}}">
                                                        <button type="button"
													class="btn1 btn-outline-danger"
                                                    onclick="confirmDelete({{ $banner->id }})"><i
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



@endsection

@section('js')

    {{-- to show confirmation alert message while delete --}}
    <script>
        function confirmDelete(bannerId) {
            var result = confirm('Are you sure you want to delete this Banner?');
            if (!result) {
                event.preventDefault(); // Prevent the default action (deletion) if user clicks "Cancel"
            } else {
                window.location.href = '{{ url("bannerDestroy") }}/' + bannerId;
            }
        }
    </script>

<script>
    const toggleButton = document.getElementById('toggleButton');
toggleButton.addEventListener('click', function() {
    const currentStatus = toggleButton.getAttribute('data-status');
    const newStatus = currentStatus === 'active' ? 'inactive' : 'active';
    toggleButton.setAttribute('data-status', newStatus);
    toggleButton.classList.toggle('toggled', newStatus === 'active');
});
</script>

@stop

