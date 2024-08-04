
@extends('frontend.layout.header')

@section('main-container')

		<!--start page wrapper -->
		<div class="page-wrapper">
			<div class="page-content">
				<div class="row">
					<div class="col-md-12 mx-auto">


						<div class="card">
							<div class="card-body">

								<h6>Add Delivery Boy</h6>
								<hr>
								<form class="row g-2" action="{{route('store-delivery-boy')}}" method="post" enctype="multipart/form-data">
                                    @csrf

                                    <div class="col-lg-2">
										<label class="form-label">First Name</label>
										<input type="text" class="form-control" id="first_name" name="first_name"
											aria-describedby="emailHelp" placeholder="">

									</div>

                                    <div class="col-lg-2">
										<label class="form-label">Last Name</label>
										<input type="text" class="form-control" id="last_name" name="last_name"
											aria-describedby="emailHelp" placeholder="">

									</div>

                                    <div class="col-lg-2">
										<label class="form-label">Primary Mobile Number</label>
										<input type="text" class="form-control" id="name" name="primary_contact"
											aria-describedby="emailHelp" placeholder="">

									</div>

                                    <div class="col-lg-3">
										<label class="form-label">Secondary Mobile Number</label>
										<input type="text" class="form-control" id="name" name="secondary_contact"
											aria-describedby="emailHelp" placeholder="">

									</div>

                                    <div class="col-lg-2">
										<label class="form-label">Email</label>
										<input type="email" class="form-control" id="email"
											aria-describedby="emailHelp" name="email" placeholder="">

									</div>

                                    <div class="col-lg-2">
										<label class="form-label">Password</label>
										<input type="password" class="form-control" id="password"
											aria-describedby="emailHelp" name="password" placeholder="">

									</div>
                                    <div class="col-lg-2">
										<label class="form-label">Residential City</label>
										<input type="text" class="form-control" id="exampleInputEmail1"
											aria-describedby="emailHelp" name="residential_city" placeholder="">

									</div>



									{{-- <div class="col-lg-2">
										<label class="form-label">Restaurant Name</label>
                                        <select class="single-select" name="restaurant">

                                            <option value="">--Select--</option>
                                            @foreach ($restro as $restro_name)
                                            <option value="{{$restro_name->id}}">{{$restro_name->restaurant}}</option>

                                            @endforeach

                                        </select>
									</div> --}}

                                    <div class="col-lg-2">
										<label class="form-label">Address</label>
										<input type="text" class="form-control" id="exampleInputEmail1"
											aria-describedby="emailHelp" name="address" placeholder="">

									</div>

                                    <div class="col-lg-3">
                                        <label class="form-label">Select Working City</label>
                                        {{-- <select class="single-select">
                                            <option value="United States">Amravati</option>
                                            <option value="United Kingdom">Akola</option>
                                            <option value="Afghanistan">Nagpur</option>

                                        </select> --}}
                                        <select class="single-select" name="city">

                                            <option value="">--Select--</option>
                                            @foreach ($city as $city_name)
                                            <option value="{{$city_name->id}}">{{$city_name->city}}</option>

                                            @endforeach

                                        </select>
                                </div>
                                    {{-- <div class="col-lg-2">
                                        <label class="form-label">Latitude</label>
                                    <input type="text" class="form-control" id="latitude" name="latitude"
                                    aria-describedby="emailHelp" placeholder="">

                                    </div>

                                    <div class="col-lg-2">
                                        <label class="form-label">Longitude</label>
                                               <input type="text" class="form-control" id="longitude" name="longitude"
                                               aria-describedby="emailHelp" placeholder="">
                                    </div> --}}

                                    {{-- <div class="col-lg-3">
										<label class="form-label">Bank Account Number</label>
										<input type="text" class="form-control" id="account_number" name="account_number"
											aria-describedby="emailHelp" placeholder="">

									</div> --}}

                                    <div class="col-lg-2">
										<label class="form-label">Aadhar Card Number</label>
										<input type="text" class="form-control" id="aadhar_number"
											aria-describedby="emailHelp" placeholder="" name="aadhar_number">

									</div>

                                    <div class="col-lg-2">
										<label class="form-label">Driving License Number</label>
										<input type="text" class="form-control" id="driving_license_number"
											aria-describedby="emailHelp" placeholder="" name="driving_license_number" required>

									</div>

                                    {{-- <div class="col-lg-2">
										<label class="form-label">Upload Documents</label>
										<input type="file" class="form-control" id="documents"
											aria-describedby="emailHelp" placeholder="" name="documents" required>

									</div> --}}



{{-- ============================= --}}


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
                                <input type="file" class="form-control" id="layout_image" placeholder="" />
                            </td>
                            <td>
                                <a> <button id="on" type="button" class="btn mjks add-row-image"
                                        style="color:#FFFFFF; height:35px; width:auto;background-color: #006699;">
                                        <i class="fa fa-plus " aria-hidden="true" ></i></button></a>
                            </td>
                        </tr>
                    </table>

<div></div>

                    <table width="100%" border="1" style="margin-top: 5px; border-radius: 10px; ">
                        <tr style="background-color:#f0f0f0; height:30px;">
                            <th width="3%" style="text-align:center; border-radius: 10px 0 0 0;">Sr.No</th>
                            <th width="10%" style="text-align:center; border-radius: 10px 0 0 0;">Added Documents</th>

                            <th width="5%" style="text-align:center; border-radius: 10px 0 0 0;">Action</th>
                        </tr>

                        <tbody class="add_more_image">
                            <tr>




                            </tr>
                        </tbody>
                    </table>
                </div>

{{-- ---------------------------------------------------- --}}


									<div class=""  align="center">
										<button type="submit" class="btn btn-success" style="margin-top: 20px"><i
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
                                            <th>First Name</th>
                                            <th>Last Name</th>
                                            <th>Primary Mobile Number</th>
                                            <th>Secondary Mobile Number</th>
                                            <th>Email</th>
											<th>City</th>
											{{-- <th>Restaurant Name</th> --}}
                                            <th>Address</th>
											{{-- <th>Latitude</th>
											<th>Longitude</th> --}}
											{{-- <th>Bank Account Number</th> --}}
                                            <th>Aadhar Card Number</th>
                                            <th>Driving License Number</th>
											{{-- <th>Documents</th> --}}
                                            <th>Status</th>
											<th style="background-color: #ffffff;">Action</th>
										</tr>
									</thead>
									<tbody>
                                        @foreach ($delivery as $delivery)

										<tr>
											<td>{{$loop->index+1}}</td>
											<td>{{$delivery->first_name}}</td>
                                            <td>{{$delivery->last_name}}</td>
                                            <td>{{$delivery->primary_contact}}</td>
                                            <td>{{$delivery->secondary_contact}}</td>
                                            <td>{{$delivery->email}}</td>
                                            <td>
                                                @if($delivery->city_name)
                                                {{ $delivery->city_name->city}}
                                            @else
                                                null
                                            @endif</td>

                                            {{-- <td>
                                                @if($delivery->restro_name)
                                                {{ $delivery->restro_name->restaurant}}
                                            @else
                                                null
                                            @endif</td> --}}


											<td>{{$delivery->address}}</td>
											{{-- <td>{{$delivery->latitude}}</td>
											<td>{{$delivery->longitude}}</td> --}}
											{{-- <td>{{$delivery->account_number}}</td> --}}
											<td>{{$delivery->aadhar_number}}</td>
                                            <td>{{$delivery->driving_license_number}}</td>
											{{-- <td>
                                                <a href="{{asset('documents/'. $delivery->documents)}}"></a>
                                                <img height="50px" width="50px"  src="{{asset('documents/'. $delivery->documents)}}" alt="" />

                                            </td> --}}

                                            {{-- active inactive button --}}
                                                <td style="background-color: #ffffff;">
                                                    <div class="d-flex align-items-center">

                                                               <?php if ($delivery->status=='1'){?>

                                                                <a href="{{url('/update_delivery_boy_status', $delivery->id)}}"
                                                                    class="btn btn-success"> Active</a>

                                                                    <?php } else {?>
                                                                    <a href="{{url('/update_delivery_boy_status', $delivery->id)}}"
                                                                        class="btn btn-danger">Inactive</a>
                                                                        <?php
                                                                }?>
                                                                </td>

                                            {{--active inactive button end  --}}



                                            <td style="background-color: #ffffff;">
                                            <a href="{{route('edit_delivery_boy', $delivery->id)}}">
											<button type="button" class="btn1 btn-outline-success"><i
														class='bx bx-edit-alt me-0'></i></button>
                                                    </a>
{{--
                                                        <button type="button"
													class="btn1 btn-outline-danger"><i
														class='bx bx-trash me-0'></i></button> --}}
											</td>
                                            @endforeach
										</tr>
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

        <!--

    {{-- to show confirmation alert message while delete --}}
    <script>
        function confirmDelete(menuId) {
            var result = confirm('Are you sure you want to delete this Menu?');
            if (!result) {
                event.preventDefault(); // Prevent the default action (deletion) if user clicks "Cancel"
            } else {
                window.location.href = '{{ url("menuDestroy") }}/' + menuId;
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




    <script>
        // Fetch restaurants based on the selected city
        document.getElementById('selectCity').addEventListener('change', function () {
            var selectedCityId = this.value;

            // Make an Ajax request to fetch related restaurants
            fetch('/getRestaurants/' + selectedCityId)
                .then(response => response.json())
                .then(data => {
                    // Clear existing options
                    document.getElementById('selectRestaurant').innerHTML = '<option value="">--Select--</option>';

                    // Populate options with fetched data
                    data.forEach(restaurant => {
                        var option = document.createElement('option');
                        option.value = restaurant.id;
                        option.text = restaurant.restaurant;
                        document.getElementById('selectRestaurant').appendChild(option);
                    });
                });
        });
    </script>



 -->

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
