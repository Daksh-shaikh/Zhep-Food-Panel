
@extends('frontend.layout.header')

@section('main-container')

		<!--start page wrapper -->
		<div class="page-wrapper">
			<div class="page-content">
				<div class="row">
					<div class="col-md-12 mx-auto">


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

								<h6>Add Delivery Boy</h6>
								<hr>
								<form class="row g-2" action="{{route('update_delivery_boy')}}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="id" value="{{$deliveryEdit->id}}"/>

                                    <div class="col-lg-2">
										<label class="form-label">First Name</label>
										<input type="text" class="form-control" id="first_name" name="first_name"
											aria-describedby="emailHelp" placeholder="" value="{{$deliveryEdit->first_name}}">

									</div>

                                    <div class="col-lg-2">
										<label class="form-label">Last Name</label>
										<input type="text" class="form-control" id="last_name" name="last_name"
											aria-describedby="emailHelp" placeholder="" value="{{$deliveryEdit->last_name}}">

									</div>

                                    <div class="col-lg-2">
										<label class="form-label">Primary Mobile Number</label>
										<input type="text" class="form-control" id="name" name="primary_contact"
											aria-describedby="emailHelp" placeholder="" value="{{$deliveryEdit->primary_contact}}">

									</div>

                                    <div class="col-lg-3">
										<label class="form-label">Secondary Mobile Number</label>
										<input type="text" class="form-control" id="name" name="secondary_contact"
											aria-describedby="emailHelp" placeholder="" value="{{$deliveryEdit->secondary_contact}}">

									</div>

                                    <div class="col-lg-2">
										<label class="form-label">Email</label>
										<input type="email" class="form-control" id="email"
											aria-describedby="emailHelp" name="email" placeholder="" value="{{$deliveryEdit->email}}">

									</div>

                                    <div class="col-lg-2">
										<label class="form-label">Password</label>
										<input type="password" class="form-control" id="password"
											aria-describedby="emailHelp" name="password" placeholder=""  >

									</div>
                                    <div class="col-lg-2">
										<label class="form-label">Residential City</label>
										<input type="text" class="form-control" id="email"
											aria-describedby="emailHelp" name="residential_city" placeholder="" value="{{$deliveryEdit->residential_city}}">

									</div>



                                    <div class="col-lg-2">
										<label class="form-label">Address</label>
										<input type="text" class="form-control" id="exampleInputEmail1"
											aria-describedby="emailHelp" name="address" placeholder="" value="{{$deliveryEdit->address}}">

									</div>

                                    <div class="col-lg-3">
                                        <label class="form-label">Select Working City</label>
                                        <select class="single-select" name="city">

                                            <option value="">--Select--</option>
                                            @foreach ($city as $city_name)
                                            <option value="{{$city_name->id}}" @if($city_name->id ==$deliveryEdit->city_id) selected @endif >{{$city_name->city}}</option>

                                            @endforeach

                                        </select>
                                </div>


                                    {{-- <div class="col-lg-2">
                                        <label class="form-label">Latitude</label>

                                    <input type="text" class="form-control" id="latitude" name="latitude"
                                    aria-describedby="emailHelp" placeholder="" value="{{$deliveryEdit->latitude}}">

                                    </div>

                                    <div class="col-lg-2">
                                        <label class="form-label">Longitude</label>
                                               <input type="text" class="form-control" id="longitude" name="longitude"
                                               aria-describedby="emailHelp" placeholder="" value="{{$deliveryEdit->longitude}}">
                                    </div> --}}

                                    {{-- <div class="col-lg-3">
										<label class="form-label">Bank Account Number</label>
										<input type="text" class="form-control" id="account_number" name="account_number"
											aria-describedby="emailHelp" placeholder="" value="{{$deliveryEdit->account_number}}">

									</div> --}}

                                    <div class="col-lg-2">
										<label class="form-label">Aadhar Card Number</label>
										<input type="text" class="form-control" id="aadhar_number"
											aria-describedby="emailHelp" placeholder="" name="aadhar_number" value="{{$deliveryEdit->aadhar_number}}">

									</div>

                                    <div class="col-lg-2">
										<label class="form-label">Driving License Number</label>
										<input type="text" class="form-control" id="driving_license_number"
											aria-describedby="emailHelp" placeholder="" name="driving_license_number"
                                            value="{{$deliveryEdit->driving_license_number}}" required>

									</div>

                                    {{-- <div class="col-lg-2">
										<label class="form-label">Upload Documents</label>
										<input type="file" class="form-control" id="documents"
											aria-describedby="emailHelp" placeholder="" name="documents" >

									</div> --}}


{{--====================================================================================================================  --}}

                                    {{-- <div class="col-md-6" style="margin-top:2vh;">
                                        <div class="row"> --}}

                                         <!-- layout image section  -->

                                         <div class="col-md-12" style="margin-top: 1px;">

                                            <div class="col-md-6">
                                                <table width="100%">

                                          {{-- layout image section --}}
                                        <!-- layout Image -->
                                       {{-- <div class="col-md-12">
                                           <table width="80%"> --}}
                                               <tr style="height:30px;">
                                                   <th width="30%">Upload Documents<span style="color: red;">*</span></th>
                                               </tr>
                                               <tr>
                                                   <td style="padding: 2px;" width="20%">
                                                       <input type="file" class="form-control" id="layout_image" placeholder="" />
                                                   </td>
                                                   <td style="padding: 2px;" width="2%">
                                                       <a>
                                                           <button id="on" type="button" class="btn mjks add-row-image"
                                                               style="color:#FFFFFF; height:30px; width:auto;background-color: #006699; margin-left: 4px;">
                                                               <i class="fa fa-plus " aria-hidden="true"></i></button>
                                                       </a>
                                                   </td>
                                               </tr>
                                           </table>
                                           <table width="100%" border="1" style="margin-top: 5px; margin-bottom:20px">
                                               <tr style="background-color:#f0f0f0; height:30px;">
                                                   <th width="3%" style="text-align:center">Sr.No</th>
                                                   <th width="5%" style="text-align:center">Added Documents</th>
                                                   <th width="5%" style="text-align:center">Action</th>
                                               </tr>
                                               <tbody class="add_more_image">
                                                   @foreach ($layoutImages as $item)
                                                   <tr class="existing-row" data-image-id="{{ $item->id }}">
                                                       <td style="text-align:center;">{{ $loop->index + 1 }}</td>
                                                       <td>
                                                           <input type="hidden" name="existing_id[]" value="{{ $item->delivery_boy_id }}">
                                                           <input type="hidden" value="{{ $item->layout_image }}">
                                                           <img src="{{ asset('/' . $item->layout_image) }}"
                                                               style="max-width: 50px; max-height: 50px;">
                                                       </td>
                                                       <td style="text-align:center; color:#FF0000">
                                                           <button type="button" class="edit render delete-row-image"><i
                                                                   class="fa fa-trash-o"></i></button>
                                                       </td>
                                                   </tr>
                                                   @endforeach
                                               </tbody>
                                           </table>
                                       </div>
                                       <hr style="border-color: #ccc8c8; width: 100%; margin-bottom:5px"> <!-- Horizontal line -->
                                       <!-- END layout Image -->


{{-- ==================================================================================================================== --}}
									<div class=""  align="center">
										<button type="submit" class="btn btn-success"><i
											class="fa fa-edit"></i>Update</button>

									</div>
								</form>

							</div>

						</div>
					</div>
				</div>



				<!--end page wrapper -->


@stop

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
var srNo=$(".new-row").length;
            srNo= parseInt(srNo)+parseInt(1);


                var markup =
                    '<tr class="new-row">' +
                        '<td style="text-align:center;">' + srNo + '</td>' +
                       '<td><input type="hidden" name="layout_image[]" value="' + imageSrc + '"><img src="' + imageSrc + '" style="max-width: 50px; max-height: 50px;"></td>' +
                        '<td style="text-align:center; color:#FF0000"><button class="delete-row-image"><i class="fa fa-trash-o"></i></button></td>' +
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

<script>
    $("tbody").on("click", ".delete-row-image", function() {
    var row = $(this).closest("tr");

    var imageId = row.data('image-id');



    $.ajax({
    type: 'get',
   url: "{{url('project-delete-layout-image')}}/" + imageId, // Replace with your actual delete route

    success: function(response) {

    row.remove();
    },
    error: function(error) {
    console.error('Error deleting image:', error);

    }
    });
    });
</script>


@endsection

