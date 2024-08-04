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



								<h6>Add Coupon</h6>
								<hr>
								<form class="row g-2" method="post" action="{{route('couponUpdate')}}" enctype="multipart/form-data">
                                    @csrf

                                    @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    @endif

                                    <input type="hidden" name="id" value="{{$couponEdit->id}}"/>

                                    <div class="col-lg-3">
                                        <label class="form-label">Select City</label>
											<select class="single-select" name="city" id="selectCity">
                                                <option value="">--Select--</option>
                                                @foreach ($city as $city_name)
                                                <option value="{{$city_name->id}}"
                                                {{ old('city', $couponEdit->city_id) == $city_name->id ? 'selected' : '' }}>
                                                {{ $city_name->city}}</option>
                                                @endforeach
											</select>
									</div>


									{{-- <div class="col-lg-2">

											<label class="form-label">Select Restaurant</label>
											<select class="multi-select" multiple="multiple" name="restaurant[]" id="selectRestaurant" >
                                                <option value="">--select--</option>
                                                @foreach ($restro as $restro_name)
                                                    <option value="{{ $restro_name->id }}"
                                                        {{ in_array($restro_name->id, $restroEdit->restaurant_id ?? []) ? 'selected' : '' }}>

                                                        {{ $restro_name->restaurant}}</option>
                                                @endforeach
                                                    </select>
									</div> --}}

                                    <div class="col-lg-2">
                                        <label class="form-label">Select Restaurant</label>
                                        <select class="multiple-select" name="restaurant[]" id="selectRestaurant" multiple>
                                            <option value="">--select--</option>
                                            @foreach ($restro as $restro_name)
                                                <option value="{{ $restro_name->id }}"
                                                    {{ in_array($restro_name->id, old('restaurant', $couponEdit->restaurant_id) ?? []) ? 'selected' : '' }}>
                                                    {{ $restro_name->restaurant }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>


                                    {{-- <div class="col-lg-2">
                                        <label class="form-label">Select Category</label>
                                        <select class="multiple-select" multiple="multiple" name="category[]">
                                            @foreach ($category as $category_name)
                                                <option value="{{ $category_name->id }}"
                                                    {{ in_array($category_name->id, $restroEdit->category ?? []) ? 'selected' : '' }}>
                                                    {{ $category_name->category }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div> --}}

									<div class="col-lg-2">
										<label class="form-label">Coupon Code</label>
										<input type="text" class="form-control" id="exampleInputEmail1"
											aria-describedby="emailHelp" placeholder="" name="code"  value="{{$couponEdit->code}}">

									</div>

									<div class="col-lg-1">
										<label class="form-label">DS Type</label>
										<select class="single-select" name="dstype">
											<option value="Percent" {{ old('dstype', $couponEdit->dstype) == 'Percent' ? 'selected' : '' }}>%</option>
											<option value="Rupee" {{ old('dstype', $couponEdit->dstype) == 'Rupee' ? 'selected' : '' }}>₹</option>
										</select>
								</div>
									<div class="col-lg-2">
										<label class="form-label">Value</label>
										<input type="text" class="form-control" id="exampleInputEmail1"
											aria-describedby="emailHelp" placeholder="" name="value"  value="{{$couponEdit->value}}">

									</div>

									<div class="col-lg-2">
										<label class="form-label">Start From</label>
										<input type="date" class="form-control" id="exampleInputEmail1"
											aria-describedby="emailHelp" placeholder="" name="start_from"  value="{{$couponEdit->start_from}}">

									</div>

									<div class="col-lg-2">
										<label class="form-label">Up To</label>
										<input type="date" class="form-control" id="exampleInputEmail1"
											aria-describedby="emailHelp" placeholder="" name="upto"  value="{{$couponEdit->upto}}">

									</div>

									<div class="col-lg-2">
										<label class="form-label">Min. Cost</label>
										<input type="text" class="form-control" id="exampleInputEmail1"
											aria-describedby="emailHelp" placeholder="" name="min_cost"  value="{{$couponEdit->min_cost}}">

									</div>

                                    <div class="col-lg-2">
										<label class="form-label">Add Coupon Image</label>
										<input type="file" class="form-control" id="exampleInputEmail1"
											aria-describedby="emailHelp" placeholder="" name="image">
                                            @if($couponEdit->image)
                                            <p>{{ $couponEdit->image }}</p>
                                          @else
                                            <p>No image uploaded</p>
                                          @endif
									</div>
                                    <div class="col-lg-3">
                                        <label for="inputAddress2" class="form-label">Coupon Description</label>
                                        <textarea class="form-control" id="inputAddress2" placeholder="" rows="3" name="description"  >{{$couponEdit->description}}</textarea>
                                    </div>


									<div class="col-lg-2"  style="margin-top: 35px;">

                                            <button style="background-color:#17a00e; color:white; border:none; max-height:35px; margin-top: 3px; "
                                            type="submit" class="btn btn-success" data-toggle="tooltip" data-placement="top" data-original-title="" title=""><i class="fa fa-edit" style="color: white"></i>Update</button>

									</div>
								</form>

							</div>

						</div>
					</div>
				</div>



		<!--end page wrapper -->


		@endsection

@section('js')
    {{-- to show confirmation alert message while delete --}}

   {{-- <script>
    function confirmDelete(couponId) {
        var result = confirm('Are you sure you want to delete this Coupon?');
        if (!result) {
            event.preventDefault(); // Prevent the default action (deletion) if user clicks "Cancel"
        } else {
            window.location.href = '{{ url("couponDestroy") }}/' + couponId;
        }
    }
</script> --}}


{{-- <script>
    $(document).ready(function() {
        $('#selectCity').on('change', function() {
            var cityId = $(this).val();
            if (cityId) {
                $.ajax({
                    url: '{{ route("getRestaurantsByCity") }}',
                    type: 'GET',
                    data: { city_id: cityId },
                    success: function(data) {
                        $('#selectRestaurant').empty();
                        $('#selectRestaurant').append('<option value="">--select--</option>');
                        $.each(data, function(key, restaurant) {
                            $('#selectRestaurant').append('<option value="' + restaurant.id + '">' + restaurant.restaurant + '</option>');
                        });
                    }
                });
            } else {
                $('#selectRestaurant').empty();
                $('#selectRestaurant').append('<option value="">--select--</option>');
            }
        });
    });
</script> --}}


<script>
    $(document).ready(function() {
        function loadRestaurants(cityId) {
            $.ajax({
                url: '{{ route("getRestaurantsByCity") }}',
                type: 'GET',
                data: { city_id: cityId },
                success: function(data) {
                    $('#selectRestaurant').empty();
                    $('#selectRestaurant').append('<option value="">--select--</option>');
                    $('#selectRestaurant').append('<option value="All">All</option>'); // Ensure "All" is always present

                    $.each(data, function(key, restaurant) {
                        $('#selectRestaurant').append('<option value="' + restaurant.id + '">' + restaurant.restaurant + '</option>');
                    });
                }
            });
        }

        $('#selectCity').on('change', function() {
            var cityId = $(this).val();

            if (cityId === 'All') {
                // Fetch all restaurants if "All" is selected
                $.ajax({
                    url: '{{ route("getAllRestaurants") }}', // Make sure to create a route and method for this
                    type: 'GET',
                    success: function(data) {
                        $('#selectRestaurant').empty();
                        $('#selectRestaurant').append('<option value="">--select--</option>');
                        $('#selectRestaurant').append('<option value="All">All</option>'); // Ensure "All" is always present

                        $.each(data, function(key, restaurant) {
                            $('#selectRestaurant').append('<option value="' + restaurant.id + '">' + restaurant.restaurant + '</option>');
                        });
                    }
                });
            } else {
                // Fetch restaurants for the selected city
                loadRestaurants(cityId);
            }
        });

        // Initial load of restaurants for empty city selection (optional)
        loadRestaurants('');
    });
    </script>

@endsection
