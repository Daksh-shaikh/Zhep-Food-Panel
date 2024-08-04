
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


								<h6>Edit City Alias</h6>
								<hr>
								<form class="row g-2" method="POST" action="{{route('cityUpdate')}}">
                                    @csrf

                                    <input type="hidden" name="id" value="{{$cityEdit->id}}"/>

									<div class="col-md-3"></div>
									<div class="col-lg-4">
										<label class="form-label">City Alias</label>
										<input type="text" class="form-control"
											aria-describedby="emailHelp" placeholder="" name="city_alias" id="city_alias" value="{{$cityEdit->city_alias}}" required>

									</div>
									<div class="col-md-2" style="margin-top:35px;">
										{{-- <button type="submit" class="btn btn-success"><i
											class="fa fa-edit"></i>Update</button> --}}
                                            <button style="background-color:#17a00e; font-size: 15px;  color:white; border:none; max-height:35px; margin-top: 3px;"
                                            type="submit" class="btn btn-success" data-toggle="tooltip" data-placement="top" data-original-title="" title=""><i class="fa fa-edit" style="color: white"></i>Update</button>

                                        </div>
								</form>

							</div>

						</div>
					</div>
				</div>





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
    // Load the Google Maps API with the Places library
    function initAutocomplete() {
        const autocomplete = new google.maps.places.Autocomplete(document.getElementById('city'));

        autocomplete.addListener('place_changed', function () {
            const place = autocomplete.getPlace();

            if (!place.geometry) {
                console.error('Place not found: ', place);
                return;
            }

            // document.getElementById('latitude_of_city').value = place.geometry.location.lat();
            // document.getElementById('longitude_of_city').value = place.geometry.location.lng();
        });
    }

    // jQuery document ready function
    $(document).ready(function () {
        // Your jQuery code goes here
    });
</script>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC1Cz13aBYAbBYJL0oABZ8KZnd7imiWwA4&libraries=places&callback=initAutocomplete" async defer></script>

@endsection
