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


								<h6>Edit Banner</h6>
								<hr>
								<form class="row g-2" method='post' action="{{route('bannerUpdate')}}" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="id" value="{{$bannerEdit->id}}"/>
									<div class="col-md-3"></div>
									<div class="col-lg-4">
										<label class="form-label">Upload Banner<span style="color: red; font-size:12px;">(Size 900px*400px)</span></label>
										<input type="file" class="form-control" id="exampleInputEmail1"
											aria-describedby="emailHelp" placeholder="" name="banner" value="{{$bannerEdit->banner}}">

									</div>
									<div class="col-md-2" style="margin-top:35px;">
										{{-- <button type="submit" class="btn btn-success"><i
											class="lni lni-circle-plus"></i>Add</button> --}}

                                            <button style="background-color:#17a00e; font-size: 15px;  color:white; border:none; max-height:35px; margin-top: 3px; "
                                            type="submit" class="btn btn-info" data-toggle="tooltip" data-placement="top" data-original-title="" title=""><i class="fa fa-edit" style="color: white"></i>Update</button>

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
											<th>Action</th>
										</tr>
									</thead>
									<tbody>

                                        @foreach ($banners as $banner)


										<tr>
											<td>{{$loop->index+1}}</td>
											<td>
                                                <a href="{{asset('banner/'. $banner->banner)}}"></a>
                                                <img height="50px" width="50px"  src="{{asset('banner/'. $banner->banner)}}" alt="" />
                                            </td>
											<td>
                                                {{-- <button type="button" class="btn1 btn-outline-success"><i
														class='bx bx-edit-alt me-0'></i></button> --}}

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
