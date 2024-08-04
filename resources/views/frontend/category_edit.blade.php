@extends('frontend.layout.header')

@section('main-container')
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


								<h6>Add Category</h6>
								<hr>
								<form class="row g-2" method="POST" action="{{route('categoryUpdate')}}">
                                    @csrf
                                    <input type="hidden" name="id" value="{{$categoryEdit->id}}"/>
									<div class="col-md-3"></div>
									<div class="col-lg-4">
										<label class="form-label">Category</label>
										<input type="text" class="form-control" id="exampleInputEmail1"
											aria-describedby="emailHelp" placeholder="" name="category" value="{{$categoryEdit->category}}">

									</div>





									<div class="col-md-2" style="margin-top:35px;">
                                        <button style="background-color:#17a00e; font-size: 15px;  color:white; border:none; max-height:35px; margin-top: 3px;"
                                        type="submit" class="btn btn-info" data-toggle="tooltip" data-placement="top" data-original-title="" title=""><i class="fa fa-edit" style="color: white"></i>Update</button>

									</div>
								</form>

							</div>

						</div>
					</div>
				</div>



				<!--end page wrapper -->
				<!--start overlay-->
				{{-- <div class="overlay toggle-icon"></div>
				<hr />
				<div class="col-md-8 mx-auto">
					<div class="card">
						<div class="card-body">
							<div class="table-responsive">
								<table id="example" class="table table-striped table-bordered">
									<thead>
										<tr>
											<th>Sr No</th>
											<th>Category</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
                                        @foreach ($categories as $category)


										<tr>
											<td>{{$loop->index+1}}</td>
											<td>{{$category->category}}</td>
											<td>

                                                        <a href="{{route('categoryDestroy', $category->id)}}">
                                                        <button type="button"
													class="btn1 btn-outline-danger"
                                                    onclick="confirmDelete({{ $category->id }})"><i
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
		</div> --}}



		<!--end page wrapper -->

        @endsection


    {{-- to show confirmation alert message while delete --}}

    <script>
        function confirmDelete(categoryId) {
            var result = confirm('Are you sure you want to delete this Category?');
            if (!result) {
                event.preventDefault(); // Prevent the default action (deletion) if user clicks "Cancel"
            } else {
                window.location.href = '{{ url("categoryDestroy") }}/' + categoryId;
            }
        }
    </script>

