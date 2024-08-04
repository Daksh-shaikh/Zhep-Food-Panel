
@extends('frontend.layout.header')

@section('main-container')

		<!--end header -->
		<!--start page wrapper -->
		<div class="page-wrapper">
			<div class="page-content">
				<div class="row">
					<div class="col-md-8 mx-auto">


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

								<h6>Add City</h6>
								<hr>
								<form class="row g-2" method="POST" action="{{route('cityStore')}}">
                                    @csrf
									<div class="col-md-1"></div>
									<div class="col-lg-4">
										<label class="form-label">City</label>
                                            <input type="text" class="form-control" id="city" name="city"
                                             placeholder="" autocomplete="on" required>

									</div>
                                    <div class="col-lg-4">
										<label class="form-label">City Alias</label>
                                            <input type="text" class="form-control" id="" name="city_alias"
                                             placeholder=""  required>

									</div>

                                    {{-- <div > --}}
                                        {{-- <label class="form-label">Latitude</label> --}}

                                    <input type="hidden" class="form-control" id="latitude" name="latitude"
                                    readonly required>

                                    {{-- </div> --}}

                                    {{-- <div > --}}
                                        {{-- <label class="form-label">Longitude</label> --}}

                                               <input type="hidden" class="form-control" id="longitude" name="longitude"
                                               readonly required>
                                    {{-- </div> --}}

									<div class="col-md-3" style="margin-top:35px;">
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
											<th>City</th>
                                            <th>City Alias</th>
                                            <th>Status</th>
                                            <th>Action</th>
											{{-- <th>Action</th> --}}
										</tr>
									</thead>
									<tbody>

                                        @foreach ($city->sortByDesc('created_at') as $city)
										<tr>
											<td>{{$loop->index+1}}</td>
											<td>{{$city->city}}</td>
                                            <td>{{$city->city_alias}}</td>
                                              {{-- active inactive button --}}
                                              <td style="background-color: #ffffff;">
                                                <div class="d-flex align-items-center">

                                                           <?php if ($city->status=='1'){?>

                                                            <a href="{{url('/update_city_status', $city->id)}}"
                                                                class="btn btn-success"> Active</a>

                                                                <?php } else {?>
                                                                <a href="{{url('/update_city_status', $city->id)}}"
                                                                    class="btn btn-danger">Inactive</a>
                                                                    <?php
                                                            }?>
                                                            </td>

                                            <td>
                                                <a href="{{route('cityEdit', $city->id)}}">
                                                <button type="button" class="btn1 btn-outline-success"><i
														class='bx bx-edit-alt me-0'></i></button>
                                                    </a>

                                             {{-- <a href="{{route('cityDestroy', $city->id)}}">
                                                        <button type="button"
													class="btn1 btn-outline-danger"
                                                    onclick="confirmDelete({{ $city->id }})"><i
														class='bx bx-trash me-0'></i></button>
                                                    </a> --}}
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



@section('js')
    {{-- to show confirmation alert message while delete --}}

<script>
    function confirmDelete(cityId) {
        var result = confirm('Are you sure you want to delete this City?');
        if (!result) {
            event.preventDefault(); // Prevent the default action (deletion) if user clicks "Cancel"
        } else {
            window.location.href = '{{ url("cityDestroy") }}/' + cityId;
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

@stop
