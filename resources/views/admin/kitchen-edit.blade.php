@extends('admin.layout.header')

@section('main-container')


<!-- Add this at the top of your Blade file to get the authenticated user -->


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

								<h6>Add Kitchen</h6>
								<hr>
								<form class="row g-2" action="{{route('kitchen-update')}}" method="post">
                                    @csrf
                                    <input type="hidden" name="id" value="{{$kitchenEdit->id}}"/>

									<div class="col-lg-2">
										<label class="form-label">Name</label>
										<input type="text" class="form-control"
											  name="name" value="{{ $kitchenEdit ? $kitchenEdit->name : '' }}">

									</div>

									<div class="col-lg-2">
										<label class="form-label">Contact</label>
										<input type="text" class="form-control" id="exampleInputEmail1"
											aria-describedby="emailHelp" placeholder="" name="contact" value="{{$kitchenEdit->contact}}">

									</div>
									<div class="col-lg-2">
										<label class="form-label">email</label>
										<input type="text" class="form-control" id="exampleInputEmail1"
											aria-describedby="emailHelp" placeholder="" name="email"  value="{{$kitchenEdit->email}}">

									</div>

                                    <div class="col-lg-2">
										<label class="form-label">password</label>
										<input type="password" class="form-control" id="password"
											aria-describedby="emailHelp" placeholder="" name="password">

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




			</div>
		</div>



		<!--end page wrapper -->

        @endsection

    {{-- to show confirmation alert message while delete --}}
    <script>
        function confirmDelete(recipeId) {
            var result = confirm('Are you sure you want to delete this Recipe?');
            if (!result) {
                event.preventDefault(); // Prevent the default action (deletion) if user clicks "Cancel"
            } else {
                window.location.href = '{{ url("recipeDestroy") }}/' + recipeId;
            }
        }
    </script>
