
@extends('frontend.layout.header')

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

								<h6>Add Notification</h6>
								<hr>
								<form class="row g-2" action="{{route('notification-store')}}" method="post" enctype="multipart/form-data">
                                    @csrf

                                    <div class="col-lg-3">
										<label class="form-label">Sent Type</label>
										<select class="single-select" name="sent_type">
											<option value="Restaurant" >Restaurant</option>
											<option value="Driver"  >Driver</option>
                                            <option value="Customer"  >Customer</option>
										</select>
								</div>

                                    <div class="col-lg-3">
										<label class="form-label">Notification Title</label>
										<input type="text" class="form-control" id="title" name="title"
											aria-describedby="emailHelp" placeholder="">

									</div>

                                    <div class="col-lg-3">
										<label class="form-label">Image</label>
										<input type="file" class="form-control" id="image"
											aria-describedby="emailHelp" placeholder="" name="image" required>

									</div>
                                    <div class="col-lg-3">
										<label class="form-label">Message</label>
                                        <textarea class="form-control" id="inputAddress2" placeholder="" rows="3" name="message"></textarea>

									</div>

									<div class=""  align="left">
										<button type="submit" class="btn btn-success" ><i
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
                                            <th>Sent Type</th>
                                            <th>Notification Title</th>
                                            <th>Image</th>
                                            <th>Message</th>


											<th style="background-color: #ffffff;">Action</th>
										</tr>
									</thead>
                                    <tbody>

                                        @foreach ($notice->sortByDesc('created_at') as $notice)


										<tr>
											<td>{{$loop->index+1}}</td>
											{{-- <td>{{$notice->restaurant_name->restaurant}}</td> --}}


											<td>{{$notice->sent_type}}</td>
											<td>{{$notice->title}}</td>

                                            <td>
                                                <a href="{{asset('notification/'. $notice->image)}}"></a>
                                                <img height="50px" width="50px"  src="{{asset('notification/'. $notice->image)}}" alt="" />
                                            </td>
											<td>{{$notice->message}}</td>



											<td style="background-color: #ffffff;">

                                                <a href="{{route('notice-edit', $notice->id)}}">
                                                <button type="button" class="btn1 btn-outline-success"><i
														class='bx bx-edit-alt me-0'></i></button>
                                                    </a>

                                                        <a href="{{route('notice-destroy', $notice->id)}}">
                                                        <button type="button"
													class="btn1 btn-outline-danger"
                                                    onclick="confirmDelete({{ $notice->id }})"><i
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


        @stop

		<!--end page wrapper -->

 @section('js')


 <script>
    $(document).ready(function() {
        $(".add-row-image").click(function()  {
            // Get the input file element
            var inputElement = document.getElementById('layout_image');

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
                       '<td><input type="hidden" name="layout_image[]" value="' + imageSrc + '"><img src="' + imageSrc + '" style="max-width: 100px; max-height: 100px;"></td>' +
                        '<td style="text-align:center; color:red"><button class="delete-row-image"><i class="fa fa-trash-o"></i></button></td>' +
                    '</tr>';

                $(".add_more_image").append(markup);
            };

            // Read the selected file as Data URL
            fileReader.readAsDataURL(inputElement.files[0]);

            // Clear the input file
            $('#layout_image').val('');
        });

        // Find and remove selected table rows
        $("tbody").delegate(".delete-row-image", "click", function() {
            $(this).parents("tr").remove();
        });
    });



</script>
@stop
