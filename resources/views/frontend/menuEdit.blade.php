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


								<h6>Add Menu</h6>
								<hr>
								<form class="row g-2" action="{{route('menuUpdate')}}" method="post" enctype="multipart/form-data">
                                    @csrf
									{{-- <div class="col-lg-2"> --}}
                                        <input type="hidden" name="id" value="{{$menuEdit->id}}"/>


                                        <div class="col-lg-3">
                                        <label class="form-label">Select City</label>
											<select class="single-select" name="city" id="selectCity">
                                                <option value="">--Select--</option>
                                                @foreach ($city as $city_name)
                                                <option value="{{$city_name->id}}"
                                                {{ old('city', $menuEdit->city_id) == $city_name->id ? 'selected' : '' }}>
                                                {{ $city_name->city}}</option>
                                                @endforeach
											</select>
									</div>


                                        <div class="col-lg-2">

                                        <label class="form-label">Select Restaurant</label>
											<select class="single-select" name="restaurant" id="selectRestaurant">
                                                <option value="">--Select--</option>
                                                @foreach ($restro as $restro_name)
                                                <option value="{{$restro_name->id}}"
                                                {{ old('restaurant', $menuEdit->restaurant_id) == $restro_name->id ? 'selected' : '' }}>
                                                {{ $restro_name->restaurant}}</option>
                                                @endforeach


											</select>
									</div>
									<div class="col-lg-2">
                                        <label class="form-label">Select Category</label>
                                        <select class="single-select" name="category" id="selectCategory">
                                            <option value="">--Select--</option>
                                            @foreach ($category as $category_name)
                                            <option value="{{ $category_name->id }}"
                                                {{ old('category', $menuEdit->category_id) == $category_name->id ? 'selected' : '' }}>
                                                {{ $category_name->category }}
                                            </option>
                                            @endforeach
                                        </select>
									</div>


									<div class="col-lg-2">
										<label class="form-label">Recipe Name</label>
										<input type="text" class="form-control" id="exampleInputEmail1"
											aria-describedby="emailHelp" placeholder="" name="recipe" value="{{$menuEdit->recipe}}">

									</div>

									<div class="col-lg-2">
										<label class="form-label">Price</label>
										<input type="text" class="form-control" id="exampleInputEmail1"
											aria-describedby="emailHelp" placeholder="" name="price" value="{{$menuEdit->price}}">

									</div>



                                    <?php
                                    $decodedFood = json_decode($menuEdit->food, true);

                                    // If it's not an array, convert it to an array
                                    if (!is_array($decodedFood)) {
                                        $decodedFood = [$menuEdit->food];
                                    }

                                    // Debug to check the values
                                    // var_dump($menuEdit->food, $decodedFood);
                                    ?>
                                    {{-- <pre>{{ var_dump($menuEdit->food, $decodedFood) }}</pre> --}}



                                    <div class="col-lg-1" style="margin-top: 35px;">
                                        <input class="form-check-input" type="checkbox" value="Veg" name="food[]" id="flexCheckDefault"
                                            @if(in_array('Veg', explode(',', $menuEdit->food))) checked @endif>
                                        <label class="form-check-label" for="flexCheckDefault">Veg</label>
                                    </div>

                                    <div class="col-lg-1" style="margin-top: 35px;">
                                        <input class="form-check-input" type="checkbox" value="Non-Veg" name="food[]" id="flexCheckDefault1"
                                            @if(in_array('Non-Veg', explode(',', $menuEdit->food))) checked @endif>
                                        <label class="form-check-label" for="flexCheckDefault1">Non-Veg</label>
                                    </div>


                                    <div class="col-lg-2">
										<label class="form-label">Recipe image</label>
										<input type="file" class="form-control" id="exampleInputEmail1"
											aria-describedby="emailHelp" placeholder="" name="image" value="{{$menuEdit->image}}">
                                            {{-- <img src="{{ asset('recipe/' . $menuEdit->image) }}" alt="Current Image" width="50" height="50"> --}}

									</div>

                                    {{-- ================================================== --}}
                                    <?php
                                    $decodedType = json_decode($menuEdit->type, true);

                                    // If it's not an array, convert it to an array
                                    if (!is_array($decodedType)) {
                                        $decodedType = [$menuEdit->type];
                                    }

                                    // Debug to check the values
                                    // var_dump($menuEdit->food, $decodedFood);
                                    ?>
                                    {{-- <pre>{{ var_dump($menuEdit->food, $decodedFood) }}</pre> --}}



                                    <div class="col-lg-1" style="margin-top: 35px;">
                                        <input class="form-check-input" type="checkbox" value="Dine In" name="type[]" id="flexCheckDefault"
                                        @if(in_array('Dine In', explode(',', $menuEdit->type))) checked @endif>
                                        <label class="form-check-label" for="flexCheckDefault">Dine In</label>

                                    </div>

                                    <div class="col-lg-1" style="margin-top: 35px;">
                                    <input class="form-check-input" type="checkbox" value="Delivery" name="type[]" id="flexCheckDefault1"
                                    @if(in_array('Delivery', explode(',', $menuEdit->type))) checked @endif>
                                    <label class="form-check-label" for="flexCheckDefault1">Delivery</label>

                                    </div>
                                    {{-- ==================================================== --}}

                                    <div class="col-lg-2">

                                        <label class="form-label">Select Varient</label>
                                            <select class="single-select" name="varient" id="varient">

                                                <option value="">--Select--</option>
                                                <option value="Full" {{old('varient', $menuEdit->varient)=='Full' ? 'selected':''}}>Full</option>
                                                <option value="Half" {{old('varient', $menuEdit->varient)=='Half' ? 'selected':''}}>Half</option>


                                            </select>
                                    </div>
{{--
                                    <div class="col-lg-2">
										<label class="form-label">IGST</label>
										<input type="text" class="form-control" id="exampleInputEmail1"
											aria-describedby="emailHelp" placeholder="" name="igst" value="{{$menuEdit->igst}}">

									</div>

                                    <div class="col-lg-2">
										<label class="form-label">CGST</label>
										<input type="text" class="form-control" id="exampleInputEmail1"
											aria-describedby="emailHelp" placeholder="" name="cgst" value="{{$menuEdit->cgst}}">

									</div>

                                    <div class="col-lg-2">
										<label class="form-label">SGST</label>
										<input type="text" class="form-control" id="exampleInputEmail1"
											aria-describedby="emailHelp" placeholder="" name="sgst" value="{{$menuEdit->sgst}}">

									</div> --}}


                                    <div class="col-lg-2">

                                        <label class="form-label">Select GST</label>
                                        <select class="single-select" name="selectgst" id="selectgst">

                                            <option value="">--Select--</option>
                                            <option value="igst">IGST</option>
                                            <option value="gst">GST</option>
                                        </select>
									</div>

                                    <div class="col-lg-2" style="display: none;" id="igst-field">
										<label class="form-label">IGST (%)</label>
										<input type="text" class="form-control" id="exampleInputEmail1"
											aria-describedby="emailHelp" placeholder="" name="igst"  value="{{$menuEdit->igst}}">
									</div>

                                    <div class="col-lg-2" style="display: none;"  id="gst-field">
										<label class="form-label">GST (%)</label>
										<input type="text" class="form-control" id="exampleInputEmail1"
											aria-describedby="emailHelp" placeholder="" name="gst"  value="{{$menuEdit->cgst*2}}">
									</div>


									<div class="col-lg-3">
										<label for="inputAddress2" class="form-label">Recipe Description</label>
										<textarea class="form-control" id="inputAddress2" placeholder=""
                                        rows="3" name="description" >{{$menuEdit->description}}</textarea>
									</div>

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
		@endsection

@section('js')
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
</script>


<script>
    $(document).ready(function() {
        // Populate categories based on selected restaurant
        $('#selectRestaurant').on('change', function() {
    var restaurantId = $(this).val();
    if (restaurantId) {
        $.ajax({
            url: '{{ route("getCategoriesByRestaurant") }}',
            type: 'GET',
            data: { restaurant: restaurantId },
            success: function(data) {
                $('#selectCategory').empty().append('<option value="">--Select--</option>');

                // Check if data is an array and iterate through it
                if (Array.isArray(data)) {
                    $.each(data, function(index, category) {
                        $('#selectCategory').append('<option value="' + category.id + '">' + category.category + '</option>');
                    });
                }
            },
            error: function(xhr, status, error) {
                console.error('Error fetching categories:', error);
                // Optionally handle errors here
            }
        });
    } else {
        $('#selectCategory').empty().append('<option value="">--Select--</option>');
    }
});

    });
</script>


{{-- to show or hide type and value fields of gst --}}
<script>
    $(document).ready(function() {
        $('#selectgst').change(function() {
            var selectedValue = $(this).val();
            if (selectedValue === 'igst') {
                $('#igst-field').show();
                $('#gst-field').hide();
            } else if (selectedValue === 'gst') {
                $('#gst-field').show();
                $('#igst-field').hide();
            } else {
                $('#igst-field').hide();
                $('#gst-field').hide();
            }
        });
    });
    </script>



@endsection
