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

                            @if (session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif


                            <h6>Edit Restaurant</h6>
                            <hr>
                            <form class="row g-2" action="{{ route('restroUpdate') }}" method="post"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="col-lg-2">
                                    @if ($errors->any())
                                        <div class="alert alert-danger">
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif

                                    <input type="hidden" name="id" value="{{ $restroEdit->id }}" />


                                    {{-- <div class="col-lg-2"> --}}

                                    <label class="form-label">Select City</label>
                                    {{-- <input type="text" class="form-control" id="city"
											aria-describedby="emailHelp" placeholder="" name="city" value="{{$restroEdit->city}}"> --}}

                                    <select class="single-select" name="city">
                                        @foreach ($city as $city_name)
                                            <option value="{{ $city_name->id }}">{{ $city_name->city }}</option>
                                        @endforeach

                                    </select>
                                </div>

                                {{-- <div class="col-lg-2">
										<label class="form-label">City Alias</label>
										<input type="text" class="form-control" id="city_alias"
											aria-describedby="emailHelp" placeholder="" name="city_alias"  value="{{$restroEdit->city_alias}}">

									</div> --}}
                                <div class="col-lg-2">
                                    <label class="form-label">Restaurant Name</label>
                                    <input type="text" class="form-control" id="exampleInputEmail1"
                                        aria-describedby="emailHelp" placeholder="" name="restaurant"
                                        value="{{ $restroEdit->restaurant }}">

                                </div>

                                <div class="col-lg-2">
                                    <label class="form-label">Address</label>
                                    <input type="text" class="form-control" id="address" aria-describedby="emailHelp"
                                        placeholder="" name="address" autocomplete="on" value="{{ $restroEdit->address }}">

                                </div>

                                <div class="col-lg-2">
                                    <label class="form-label">Latitude</label>
                                    {{-- <input type="text" class="form-control"
											aria-describedby="emailHelp" placeholder="" id="latitude" name="latitude" > --}}
                                    <input type="text" class="form-control" id="latitude" name="latitude" readonly
                                        required value="{{ $restroEdit->latitude }}">

                                </div>

                                <div class="col-lg-2">
                                    <label class="form-label">Longitude</label>
                                    <input type="text" class="form-control" id="longitude" name="longitude" readonly
                                        required value="{{ $restroEdit->longitude }}">
                                </div>

                                <div class="col-lg-2">
                                    <label class="form-label">Contact Person</label>
                                    <input type="text" class="form-control" id="exampleInputEmail1"
                                        aria-describedby="emailHelp" placeholder="" name="contact_person"
                                        value="{{ $restroEdit->contact_person }}">

                                </div>

                                <div class="col-lg-2">
                                    <label class="form-label">Mobile No</label>
                                    <input type="text" class="form-control" id="exampleInputEmail1"
                                        aria-describedby="emailHelp" placeholder="" name="mobilenumber"
                                        value="{{ $restroEdit->mobilenumber }}">

                                </div>

                                <div class="col-lg-2">
                                    <label class="form-label">Email / Username</label>
                                    <input type="text" class="form-control" id="exampleInputEmail1"
                                        aria-describedby="emailHelp" placeholder="" name="email"
                                        value="{{ $restroEdit->email }}">

                                </div>
                                <div class="col-lg-2">
                                    <label class="form-label">Password</label>
                                    <input type="text" class="form-control" id="exampleInputEmail1"
                                        aria-describedby="emailHelp" placeholder="***************" name="password">
                                    {{-- value="{{$restroEdit->password}}"> --}}

                                </div>

                                <div class="col-lg-2">
                                    <label class="form-label">Avg Cooking Time</label>
                                    <input type="text" class="form-control" id="exampleInputEmail1"
                                        aria-describedby="emailHelp" placeholder="" name="avg_cooking_time"
                                        value="{{ $restroEdit->avg_cooking_time }}">

                                </div>


                                <?php
                                $decodedType = json_decode($restroEdit->type, true);

                                // If it's not an array, convert it to an array
                                if (!is_array($decodedType)) {
                                    $decodedType = [$restroEdit->type];
                                }

                                // Debug to check the values
                                // var_dump($restroEdit->food, $decodedFood);

                                ?>
                                {{-- <pre>{{ var_dump($restroEdit->food, $decodedFood) }}</pre> --}}



                                <div class="col-lg-1" style="margin-top: 35px;">
                                    <input class="form-check-input" type="checkbox" value="Dine In" name="type[]"
                                        id="flexCheckDefault" @if (in_array('Dine In', explode(',', $restroEdit->type))) checked @endif>
                                    <label class="form-check-label" for="flexCheckDefault">Dine In</label>

                                </div>

                                <div class="col-lg-1" style="margin-top: 35px;">
                                    <input class="form-check-input" type="checkbox" value="Delivery" name="type[]"
                                        id="flexCheckDefault1" @if (in_array('Delivery', explode(',', $restroEdit->type))) checked @endif>
                                    <label class="form-check-label" for="flexCheckDefault1">Delivery</label>

                                </div>

                                <div class="col-lg-2">
                                    <label class="form-label">Upload Banner</label>
                                    <input type="file" class="form-control" id="exampleInputEmail1"
                                        aria-describedby="emailHelp" placeholder="" name="banner"
                                        value="{{ $restroEdit->banner }}">

                                </div>

                                <div class="col-lg-1" style="margin-top: 35px;">
                                    <input class="form-check-input" type="checkbox" value="Veg" name="food[]"
                                        id="flexCheckDefault" @if (in_array('Veg', explode(',', $restroEdit->food))) checked @endif>
                                    <label class="form-check-label" for="flexCheckDefault">Veg</label>
                                </div>

                                <div class="col-lg-1" style="margin-top: 35px;">
                                    <input class="form-check-input" type="checkbox" value="Non-Veg" name="food[]"
                                        id="flexCheckDefault1" @if (in_array('Non-Veg', explode(',', $restroEdit->food))) checked @endif>
                                    <label class="form-check-label" for="flexCheckDefault1">Non-Veg</label>
                                </div>


                                <div class="col-lg-2">
                                    <label class="form-label">Select Category</label>
                                    <select class="multiple-select" multiple="multiple" name="category[]">
                                        @foreach ($category as $category_name)
                                            <option value="{{ $category_name->id }}"
                                                {{ in_array($category_name->id, $restroEdit->category ?? []) ? 'selected' : '' }}>
                                                {{ $category_name->category }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>


                                <?php
                                $decodedFood = json_decode($restroEdit->food, true);

                                // If it's not an array, convert it to an array
                                if (!is_array($decodedFood)) {
                                    $decodedFood = [$restroEdit->food];
                                }

                                // Debug to check the values
                                // var_dump($restroEdit->food, $decodedFood);

                                ?>
                                {{-- <pre>{{ var_dump($restroEdit->food, $decodedFood) }}</pre> --}}





                                <div class="col-lg-2" style="margin-top: 35px;">
                                    <label class="form-check-label" for="service-charges">Service Charges</label>
                                    <input class="form-check-input" type="checkbox" value="service-charges"
                                        name="service-charges" id="service-charges"
                                        {{ !is_null($restroEdit->service_charges_type) ? 'checked' : '' }}>


                                </div>


                                <div class="col-lg-2" id="type-field">
                                    <label class="form-label">Type</label>
                                    <select class="single-select" name="service_charges_type">
                                        <option value="">--select--</option>
                                        <option value="Rupee"
                                            {{ old('service_charges_type', $restroEdit->service_charges_type) == 'Rupee' ? 'selected' : '' }}>
                                            ₹</option>
                                        <option value="Percent"
                                            {{ old('service_charges_type', $restroEdit->service_charges_type) == 'Percent' ? 'selected' : '' }}>
                                            %</option>
                                    </select>
                                </div>
                                <div class="col-lg-1" id="value-field">
                                    <label class="form-label">Value</label>
                                    <input type="text" class="form-control" id=""
                                        aria-describedby="emailHelp" placeholder="" name="service_charges_value"
                                        value="{{ $restroEdit->service_charges_value }}">

                                </div>

                                <div class="col-lg-3">
                                    <label for="inputAddress2" class="form-label">Restaurant Details</label>
                                    <textarea class="form-control" id="inputAddress2" placeholder="" rows="3" name="details">{{ $restroEdit->details }}</textarea>
                                </div>


                                <h6>Add Delivery Slots & Timing</h6>
                                <hr>
                                <div class="row">
                                    @foreach ($days as $day)
                                        <div class="col-lg-2">
                                            <label class="form-label">{{ $day->days }}</label>
                                            <input type="hidden" name="days[]" value="{{ $day->id }}">

                                            <div>
                                                <input type="checkbox" name="is_close_{{ $day->id }}"
                                                    id="is_close_{{ $day->id }}"
                                                    style="width: 15px; height: 15px; border: 2px solid #333;"
                                                    onchange="toggleTimeFields('{{ $day->id }}')"
                                                    @if ($timeSlots[$day->id]->is_close) checked @endif>
                                                <label class="form-check-label" for="flexCheckDefault1"
                                                    style="margin-left: 10px">Closed</label>
                                            </div>
                                        </div>

                                        <div class="col-lg-2">
                                            <div style="position: relative; margin-top:15px">
                                                <label for="open_at_{{ $day->id }}"
                                                    style="position: absolute; top: -10px; left: 5px; background-color: white; padding: 0 5px;">Open
                                                    at</label>
                                                <input type="time" name="open_at_{{ $day->id }}"
                                                    id="open_at_{{ $day->id }}" class="form-control"
                                                    style="height: 50px;" value="{{ $timeSlots[$day->id]->open_at }}">
                                            </div>
                                        </div>

                                        <div class="col-lg-2">
                                            <div style="position: relative; margin-left: 10px; margin-top:15px">
                                                <label for="close_at_{{ $day->id }}"
                                                    style="position: absolute; top: -10px; left: 5px; background-color: white; padding: 0 5px;">Close
                                                    at</label>
                                                <input type="time" name="close_at_{{ $day->id }}"
                                                    id="close_at_{{ $day->id }}" class="form-control"
                                                    style="height: 50px;" value="{{ $timeSlots[$day->id]->close_at }}">
                                            </div>
                                        </div>
                                        <div></div>
                                    @endforeach
                                </div>


                        </div>
                        <div class="" align="center">
                            {{-- <button type="submit" class="btn btn-success"><i
											class="lni lni-circle-plus"></i>Update</button> --}}
                            <button
                                style="background-color:#17a00e; color:white; border:none; max-height:35px; margin-top: 3px; "
                                type="submit" class="btn btn-success" data-toggle="tooltip" data-placement="top"
                                data-original-title="" title=""><i class="fa fa-edit"
                                    style="color: white"></i>Update</button>

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
				<div class="col-md-12 mx-auto">
					<div class="card">
						<div class="card-body">
							<div class="table-responsive">
								<table id="example" class="table table-striped table-bordered">
									<thead>
										<tr>
											<th>Sr No</th>
											<th>City</th>
											<th>Restaurant Name</th>
                                            <th>Address</th>
											<th>Latitude</th>
											<th>Longitude</th>
											<th>Contact Person</th>
											<th>Mobile</th>
											<th>Email</th>
											<th>Banner</th>
											<th>Category</th>
											<th>Veg/Non-Veg</th>
											<th>Restaurant Details</th>
											<th style="background-color: #ffffff;">Action</th>
										</tr>
									</thead>
									<tbody>

										@foreach ($restroCollection as $item)


										<tr>
											<td>{{$loop->index+1}}</td>

                                            <td>{{$item->city}}</td>

											<td>{{$item->restaurant}}</td>
                                            <td>{{$item->address}}</td>
											<td>{{$item->latitude}}</td>
											<td>{{$item->longitude}}</td>
											<td>{{$item->contact_person}}</td>
											<td>{{$item->mobilenumber}}</td>
											<td>{{$item->email}}</td>
											<td>{{$item->banner}}</td>

                                            <td>
                                                @forelse ($item->category_name as $category)
                                                    {{ $category->category }}
                                                    @if (!$loop->last)
                                                        ,
                                                    @endif
                                                @empty
                                                    No categories
                                                @endforelse
                                            </td>
                                            <td>
                                                @if ($item->food)
                                                    @php
                                                        $decodedFood = json_decode($item->food, true);
                                                    @endphp

                                                    @if (is_array($decodedFood))
                                                        {{ implode(', ', $decodedFood) }}
                                                    @else
                                                        {{ $item->food }}
                                                    @endif
                                                @endif
                                            </td>

											<td>{{$item->details}}</td>
											<td style="background-color: #ffffff;">

                                                        <a href="{{route('restroDestroy', $item->id)}}">
                                                            <button
                                                        type="button" class="btn1 btn-outline-danger" title="button"
                                                        onclick="confirmDelete({{ $item->id }})"><i
                                                            class='bx bx-trash me-0'></i>
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

    @section('js')

        <script>
            // Load the Google Maps API with the Places library
            function initAutocomplete() {
                const autocomplete = new google.maps.places.Autocomplete(document.getElementById('address'));

                autocomplete.addListener('place_changed', function() {
                    const place = autocomplete.getPlace();

                    if (!place.geometry) {
                        console.error('Place not found: ', place);
                        return;
                    }

                    document.getElementById('latitude').value = place.geometry.location.lat();
                    document.getElementById('longitude').value = place.geometry.location.lng();
                });
            }

            // jQuery document ready function
            $(document).ready(function() {
                // Your jQuery code goes here
            });
        </script>

        <script
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC1Cz13aBYAbBYJL0oABZ8KZnd7imiWwA4&libraries=places&callback=initAutocomplete"
            async defer></script>




        {{-- to show confirmation alert message while delete --}}
        <script>
            function confirmDelete(restaurantId) {
                var result = confirm('Are you sure you want to delete this Restaurant?');
                if (!result) {
                    event.preventDefault(); // Prevent the default action (deletion) if user clicks "Cancel"
                } else {
                    window.location.href = '{{ url('restroDestroy') }}/' + restaurantId;
                }
            }
        </script>



        <!-- jQuery library -->
        {{-- <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script> --}}

        <!-- Your script containing toggleTimeFields function -->
        <script>
            function toggleTimeFields(dayId) {
                console.log("Toggling time fields for day ID: " + dayId);

                var checkbox = $('#is_close_' + dayId);
                var openCloseFields = $('#openCloseFields_' + dayId);
                var closeAtFields = $('#closeAtFields_' + dayId);

                if (checkbox.prop('checked')) {
                    console.log("Checkbox is checked");
                    openCloseFields.hide();
                    closeAtFields.hide();
                } else {
                    console.log("Checkbox is not checked");
                    openCloseFields.show();
                    closeAtFields.show();
                }
            }
        </script>


        {{-- to show or hide type and value fields of service charges --}}
        <script>
            $(document).ready(function() {
                $('#service-charges').change(function() {
                    if ($(this).is(':checked')) {
                        $('#type-field').show();
                        $('#value-field').show();
                    } else {
                        $('#type-field').hide();
                        $('#value-field').hide();
                    }
                });
            });
        </script>
    @stop
