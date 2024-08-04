@extends('admin.layout.header')

@section('main-container')

@auth
<?php $authenticatedUser = auth()->user(); ?>
@endauth
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
								<form class="row g-2" action="{{route('kitchen-registration')}}" method="post" >
                                    @csrf
									<div class="col-lg-2">
										<label class="form-label">Name</label>
										<input type="text" class="form-control" id="exampleInputEmail1"
											aria-describedby="emailHelp" placeholder="" name="name">

									</div>

									<div class="col-lg-2">
										<label class="form-label">Contact</label>
										<input type="text" class="form-control" id="exampleInputEmail1"
											aria-describedby="emailHelp" placeholder="" name="contact">

									</div>
									<div class="col-lg-2">
										<label class="form-label">email</label>
										<input type="text" class="form-control" id="exampleInputEmail1"
											aria-describedby="emailHelp" placeholder="" name="email">

									</div>

                                    <div class="col-lg-2">
										<label class="form-label">password</label>
										<input type="password" class="form-control" id="exampleInputEmail1"
											aria-describedby="emailHelp" placeholder="" name="password">

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
											<th>Name</th>
											<th>Contact</th>
											<th>Email Id</th>
                                            <th>Status</th>
											<th style="background-color: #ffffff;">Action</th>
										</tr>
									</thead>
									<tbody>



                                    <!-- Modify the loop to show recipes only for the authenticated user -->
                                    @if ($authenticatedUser->kitchen)

                                    @foreach ($authenticatedUser->kitchen->sortByDesc('created_at') as $data)

                                    {{-- @foreach ($data as $data) --}}

										<tr>
											<td>{{$loop->index+1}}</td>

                                            <td>{{$data->name}}</td>
                                            <td>{{$data->contact}}</td>
                                            <td>{{$data->email}}</td>


                                        {{-- active inactive button --}}
                                        <td style="background-color: #ffffff;">
                                            <div class="d-flex align-items-center">

                                                    <?php if ($data->status=='1'){?>

                                                        <a href="{{url('/update-kitchen-status', $data->id)}}"
                                                            class="btn btn-success"> Active</a>

                                                            <?php } else {?>
                                                            <a href="{{url('/update-kitchen-status', $data->id)}}"
                                                                class="btn btn-danger">Inactive</a>
                                                                <?php
                                                        }?>
                                                        </td>
                                        {{--active inactive button end  --}}

											<td style="background-color: #ffffff;">

                                                <a href="{{route('kitchen-edit', $data->id)}}">
                                                    <button type="submit" class="btn1 btn-outline-success"><i
														class='bx bx-edit-alt me-0'></i></button></a>


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
        function confirmDelete(recipeId) {
            var result = confirm('Are you sure you want to delete this Recipe?');
            if (!result) {
                event.preventDefault(); // Prevent the default action (deletion) if user clicks "Cancel"
            } else {
                window.location.href = '{{ url("recipeDestroy") }}/' + recipeId;
            }
        }
    </script>
