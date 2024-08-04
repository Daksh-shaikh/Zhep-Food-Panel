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

								<h6>Add Waiter</h6>
								<hr>
								<form class="row g-2" action="{{route('waiter-registration')}}" method="post" enctype="multipart/form-data">
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




                                      {{-- ---------------------------------------------------------- --}}
        {{-- layout image section --}}

            <div class="col-md-12" style="margin-top: 1px;">

                <div class="col-md-6">
                    <table width="100%">
                        <tr style="height:30px;">
                            <th width="30%">Upload Documents</th>
                            <th></th>
                        </tr>
                        <tr>
                            <td style="padding: 2px;" width="50%">
                                <input type="file" class="form-control" id="document" placeholder="" />
                            </td>
                            <td>
                                <a> <button id="on" type="button" class="btn mjks add-row-image"
                                        style="color:#FFFFFF; height:35px; width:auto;background-color: #006699;">
                                        <i class="fa fa-plus " aria-hidden="true" ></i></button></a>
                            </td>
                        </tr>
                    </table>

<div></div>

                    <table width="100%" border="1" style="margin-top: 5px;">
                        <tr style="background-color:#f0f0f0; height:30px;">
                            <th width="3%" style="text-align:center">Sr.No</th>
                            <th width="10%" style="text-align:center">Added Documents</th>

                            <th width="5%" style="text-align:center">Action</th>
                        </tr>

                        <tbody class="add_more_image">
                            <tr>




                            </tr>
                        </tbody>
                    </table>
                </div>

{{-- ---------------------------------------------------- --}}


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
                                    @if ($authenticatedUser->waiter)

                                    @foreach ($authenticatedUser->waiter->sortByDesc('created_at') as $data)

										<tr>
											<td>{{$loop->index+1}}</td>

                                            <td>{{$data->name}}</td>
                                            <td>{{$data->contact}}</td>
                                            <td>{{$data->email}}</td>


                                        {{-- active inactive button --}}
                                        <td style="background-color: #ffffff;">
                                            <div class="d-flex align-items-center">

                                                    <?php if ($data->status=='1'){?>

                                                        <a href="{{url('/update-waiter-status', $data->id)}}"
                                                            class="btn btn-success"> Active</a>

                                                            <?php } else {?>
                                                            <a href="{{url('/update-waiter-status', $data->id)}}"
                                                                class="btn btn-danger">Inactive</a>
                                                                <?php
                                                        }?>
                                                        </td>
                                        {{--active inactive button end  --}}

											<td style="background-color: #ffffff;">

                                                <a href="{{route('waiter-edit', $data->id)}}">
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


        @section('js')
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



<script>
    $(document).ready(function() {
        $(".add-row-image").click(function()  {
            // Get the input file element
            var inputElement = document.getElementById('document');

            // Check if a file is selected
            if (!inputElement.files || inputElement.files.length === 0) {
                alert('Please select an image file.');
                return;
            }

            // Use FileReader to display the selected image
            var fileReader = new FileReader();
            fileReader.onload = function(e) {
                var imageSrc = e.target.result;

                // Create a new row with the image
                var rowCount = $(".add_more_image tr").length;
                var srNo = rowCount;



                var markup =
                    '<tr>' +
                        '<td style="text-align:center;">' + srNo + '</td>' +
                       '<td><input type="hidden" name="document[]" value="' + imageSrc + '"><img src="' + imageSrc + '" style="max-width: 100px; max-height: 100px;"></td>' +
                        '<td style="text-align:center; color:#FF0000"><button class="delete-row-image"><i class="fa fa-trash-o"></i></button></td>' +
                    '</tr>';

                $(".add_more_image").append(markup);
            };

            // Read the selected file as Data URL
            fileReader.readAsDataURL(inputElement.files[0]);

            // Clear the input file
            $('#document').val('');
        });

        // Find and remove selected table rows
        $("tbody").delegate(".delete-row-image", "click", function() {
            $(this).parents("tr").remove();
        });
    });



</script>
    @endsection
