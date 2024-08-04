
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
								<form class="row g-2" action="{{route('notification-update')}}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="id" value="{{$noticeEdit->id}}"/>

                                    <div class="col-lg-3">
										<label class="form-label">Sent Type</label>
										<select class="single-select" name="sent_type">
                                            <option value="">--Select--</option>
                                            <option value="Restaurant" {{ $noticeType == 'Restaurant' ? 'selected' : '' }}>Restaurant</option>
                                            <option value="Driver" {{ $noticeType == 'Driver' ? 'selected' : '' }}>Driver</option>
                                            <option value="Customer" {{ $noticeType == 'Customer' ? 'selected' : '' }}>Customer</option>

										</select>
								</div>

                                    <div class="col-lg-3">
										<label class="form-label">Notification Title</label>
										<input type="text" class="form-control" id="title" name="title"
											aria-describedby="emailHelp" placeholder="" value="{{$noticeEdit->title}}" required>

									</div>

                                    <div class="col-lg-3">
										<label class="form-label">Image</label>
										<input type="file" class="form-control" id="image"
											aria-describedby="emailHelp" placeholder="" name="image" >
                                            @if($noticeEdit->image)
                                            <p>{{ $noticeEdit->image }}</p>
                                          @else
                                            <p>No image uploaded</p>
                                          @endif

									</div>
                                    <div class="col-lg-3">
										<label class="form-label">Message</label>
                                        <textarea class="form-control" id="inputAddress2" placeholder="" rows="3" name="message" required>{{$noticeEdit->message}}</textarea>

									</div>

									<div class=""  align="left">
										<button type="submit" class="btn btn-success" ><i
											class="lni lni-circle-plus"></i>Update</button>
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
