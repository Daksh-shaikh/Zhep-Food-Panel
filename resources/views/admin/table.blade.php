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

								<h6>Add Table</h6>
								<hr>
								<form class="row g-4" action="{{route('tableStore')}}" method="post" >
                                    @csrf
                                    <div class="col-md-1"></div>

                                    <div class="col-lg-3">
                                        <label class="form-label">Select Area</label>
                                        <select class="single-select" name="area">
                                            <option value="">--Select--</option>
                                            @foreach ($area as $area_name)
                                            <option value="{{$area_name->id}}">{{$area_name->area}}</option>

                                            @endforeach
                                        </select>
                                </div>
									<div class="col-lg-4">
										<label class="form-label">Table No. / Name </label>
										<input type="text" class="form-control" id="exampleInputEmail1"
											aria-describedby="emailHelp" placeholder="" name="table">

									</div>

									<div class="col-lg-3"  style="margin-top: 52px;">
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
                                            <th>Area Name</th>
											<th>Table Number / Name</th>
											{{-- <th>Contact</th>
											<th>Email Id</th> --}}
                                            {{-- <th>Status</th> --}}
											<th style="background-color: #ffffff;">Action</th>
                                            <th style="background-color: #ffffff;">Generate QR</th>
										</tr>
									</thead>
									<tbody>



                                    <!-- Modify the loop to show recipes only for the authenticated user -->
                                    @if ($authenticatedUser->table)

                                    @foreach ($authenticatedUser->table->sortByDesc('created_at') as $data)

										<tr>
											<td>{{$loop->index+1}}</td>

                                            <td>
                                                {{$data->area_name ? $data->area_name->area : 'null'}}
                                            </td>

                                            <td>{{$data->table}}</td>


                                        {{-- active inactive button --}}
                                        <td style="background-color: #ffffff;">
                                            <div class="d-flex align-items-center">

                                                    <?php if ($data->status=='1'){?>

                                                        <a href="{{url('/update-table-status', $data->id)}}"
                                                            class="btn btn-success"> Active</a>

                                                            <?php } else {?>
                                                            <a href="{{url('/update-table-status', $data->id)}}"
                                                                class="btn btn-danger">Inactive</a>
                                                                <?php
                                                        }?>
                                                        </td>


                                        <td><a href="{{ route('downloadQrCode', ['restaurant_id' => $data->restro_id, 'table_number' => $data->table]) }}" class="btn btn-primary" target="blank">Generate</a>
                                        </td>
                                        {{--active inactive button end  --}}

											{{-- <td style="background-color: #ffffff;">

                                                <a href="{{route('kitchen-edit', $data->id)}}">
                                                    <button type="submit" class="btn1 btn-outline-success"><i
														class='bx bx-edit-alt me-0'></i></button></a>


											</td> --}}
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
