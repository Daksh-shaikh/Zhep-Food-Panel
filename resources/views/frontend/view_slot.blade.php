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

                        @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif


								<h6>Add Restaurant</h6>
								<hr>
								<form class="row g-2" action="{{route('restroStore')}}" method="post" enctype="multipart/form-data">
                                    @csrf
									<div class="col-lg-2">



                            <h6>Delivery Slots & Timing</h6>
<hr>
<div class="row">
    @foreach ($days as $day)
        <div class="col-lg-2">
            <label class="form-label">{{ $day->days }}</label>
            <input type="hidden" name="days[]" value="{{ $day->id }}">

            <div>
                <input type="checkbox" name="is_close_{{ $day->id }}" id="is_close_{{ $day->id }}" style="width: 15px; height: 15px; border: 2px solid #333;" onchange="toggleTimeFields('{{ $day->id }}')">
                <label class="form-check-label" for="flexCheckDefault1" style="margin-left: 10px">Closed</label>
            </div>
        </div>

        <div class="col-lg-2">
            <div style="position: relative; margin-top:15px">
                <label for="open_at_{{ $day->id }}" style="position: absolute; top: -10px; left: 5px; background-color: white; padding: 0 5px;">Open at</label>
                <input type="time" name="open_at_{{ $day->id }}" id="open_at_{{ $day->id }}" class="form-control" style="height: 50px;" value="10:00">
            </div>
        </div>

        <div class="col-lg-2">
            <div style="position: relative; margin-left: 10px; margin-top:15px">
                <label for="close_at_{{ $day->id }}" style="position: absolute; top: -10px; left: 5px; background-color: white; padding: 0 5px;">Close at</label>
                <input type="time" name="close_at_{{ $day->id }}" id="close_at_{{ $day->id }}" class="form-control" style="height: 50px;" value="22:00">
            </div>
        </div>
        <div></div>
    @endforeach
</div>


                            </div>


                            <div></div>
                            <div></div>


									<div class=""  align="center" style="margin-top: 20px">
										<button type="submit" class="btn btn-success">
                                            <i
											class="lni lni-circle-plus"></i>
                                            Submit</button>
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
                                            <th>City</th>
											<th>Restaurant Name</th>
                                            <th>Address</th>
											<th>Contact Person</th>
											<th>Mobile</th>
											<th>Email / Username</th>
                                            {{-- <th>Password</th> --}}
                                            <th>Average Cooking Time</th>
											<th>Banner</th>
											<th>Category</th>
											<th>Veg/Non-Veg</th>
                                            <th>Latitude</th>
											<th>Longitude</th>
											{{-- <th>GST</th> --}}
											<th>Restaurant Details</th>
                                            <th>Delivery Slots & Timing</th>
                                            <th>Login</th>

											<th style="background-color: #ffffff;">Action</th>
										</tr>
									</thead>
									<tbody>

										@foreach ($restro as $restro)


										<tr>
											<td>{{$loop->index+1}}</td>

                                            <td>{{$restro->city}}</td>
											<td>{{$restro->restaurant}}</td>
                                            <td>{{$restro->address}}</td>
											<td>{{$restro->contact_person}}</td>
											<td>{{$restro->mobilenumber}}</td>
											<td>{{$restro->email}}</td>
                                            {{-- <td>{{$restro->password}}</td> --}}
                                            <td>{{$restro->avg_cooking_time}}</td>
											<td>
                                                <a href="{{asset('banner/'. $restro->banner)}}"></a>
                                                <img height="50px" width="50px"  src="{{asset('banner/'. $restro->banner)}}" alt="" />


                                            </td>

                                            <td>
                                                @forelse ($restro->category_name as $category)
                                                    {{ $category->category }}
                                                    @if (!$loop->last)
                                                        ,
                                                    @endif
                                                @empty
                                                    No categories
                                                @endforelse
                                            </td>

                                                <td>
                                                    @if($restro->food)
                                                        @php
                                                            $decodedFood = json_decode($restro->food, true);
                                                        @endphp

                                                        @if(is_array($decodedFood))
                                                            {{ implode(', ', $decodedFood) }}
                                                        @else
                                                            {{ $restro->food }}
                                                        @endif
                                                    @endif
                                                </td>

                                            </td>

                                            <td>{{$restro->latitude}}</td>
											<td>{{$restro->longitude}}</td>
											<td>{{$restro->details}}</td>
                                            <td style="background-color: #ffffff;">

                                                <a href="{{ route('view') }}">View</a>
                                            </td>

                                            <td style="background-color: #ffffff;">

                                                <a href="{{ route('login', ['email' => $restro->email]) }}">Login</a>
                                            </td>



											<td style="background-color: #ffffff;">

                                                <a href="{{route('restroEdit', $restro->id)}}">
                                                    <button type="button" class="btn1 btn-outline-success"><i
														class='bx bx-edit-alt me-0'></i></button>
                                                    </a>


                                                        <a href="{{route('restroDestroy', $restro->id)}}">
                                                            <button
                                                        type="button" class="btn1 btn-outline-danger" title="button"
                                                        onclick="confirmDelete({{ $restro->id }})"><i
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



<script>
    // Load the Google Maps API with the Places library
    function initAutocomplete() {
        const autocomplete = new google.maps.places.Autocomplete(document.getElementById('city'));

        autocomplete.addListener('place_changed', function () {
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
    $(document).ready(function () {
        // Your jQuery code goes here
    });
</script>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC1Cz13aBYAbBYJL0oABZ8KZnd7imiWwA4&libraries=places&callback=initAutocomplete" async defer></script>


@endsection


    {{-- to show confirmation alert message while delete --}}
    <script>
        function confirmDelete(restaurantId) {
            var result = confirm('Are you sure you want to delete this Restaurant?');
            if (!result) {
                event.preventDefault(); // Prevent the default action (deletion) if user clicks "Cancel"
            } else {
                window.location.href = '{{ url("restroDestroy") }}/' + restaurantId;
            }
        }
    </script>

<!-- jQuery library -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

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




