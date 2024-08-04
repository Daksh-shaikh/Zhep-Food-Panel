@extends('admin.layout.header')

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

								<h6>Add Recipe</h6>
								<hr>
								<form class="row g-2" action="{{route('recipeUpdate')}}" method="post" enctype="multipart/form-data">
                                    @csrf
									<div class="col-lg-2">
                                        <input type="hidden" name="id" value="{{$recipeEdit->id}}"/>
											<label class="form-label">Select Category</label>
											<select class="single-select" name="category">
                                                <option value="">--Select--</option>
                                                @foreach ($category as $category_name)
                                                <option value="{{$category_name->id}}"
                                                    {{ old('category', $recipeEdit->category_id) == $category_name->id ? 'selected' : '' }}>
                                                    {{$category_name->category}}</option>

                                                @endforeach
												{{-- <option value="United States">Chines</option>
												<option value="United Kingdom">South Indian</option> --}}
											</select>
									</div>
									<div class="col-lg-2">
										<label class="form-label">Recipe Name</label>
										<input type="text" class="form-control" id="exampleInputEmail1"
											aria-describedby="emailHelp" placeholder="" name="recipe"
                                            value="{{$recipeEdit->recipe}}">

									</div>

									<div class="col-lg-1">
										<label class="form-label">Price</label>
										<input type="text" class="form-control" id="exampleInputEmail1"
											aria-describedby="emailHelp" placeholder="" name="price"
                                            value="{{$recipeEdit->price}}">

									</div>

                                    <?php
                                    $decodedFood = json_decode($recipeEdit->food, true);

                                    // If it's not an array, convert it to an array
                                    if (!is_array($decodedFood)) {
                                        $decodedFood = [$recipeEdit->food];
                                    }

                                    // Debug to check the values
                                    // var_dump($recipeEdit->food, $decodedFood);
                                    ?>
                                    {{-- <pre>{{ var_dump($recipeEdit->food, $decodedFood) }}</pre> --}}



                                    <div class="col-lg-1" style="margin-top: 35px;">
                                        <input class="form-check-input" type="checkbox" value="Veg" name="food[]" id="flexCheckDefault"
                                            @if(in_array('Veg', explode(',', $recipeEdit->food))) checked @endif>
                                        <label class="form-check-label" for="flexCheckDefault">Veg</label>
                                    </div>

                                    <div class="col-lg-1" style="margin-top: 35px;">
                                        <input class="form-check-input" type="checkbox" value="Non-Veg" name="food[]" id="flexCheckDefault1"
                                            @if(in_array('Non-Veg', explode(',', $recipeEdit->food))) checked @endif>
                                        <label class="form-check-label" for="flexCheckDefault1">Non-Veg</label>
                                    </div>



									<div class="col-lg-2">
										<label class="form-label">Recipe image</label>
										<input type="file" class="form-control" id="exampleInputEmail1"
											aria-describedby="emailHelp" placeholder="" name="image"
                                            >
                                            @if($recipeEdit->image)
                                            <p>{{ $recipeEdit->image }}</p>
                                          @else
                                            <p>No image uploaded</p>
                                          @endif

									</div>

                                      {{-- ================================================== --}}
                                      <?php
                                      $decodedType = json_decode($recipeEdit->type, true);

                                      // If it's not an array, convert it to an array
                                      if (!is_array($decodedType)) {
                                          $decodedType = [$recipeEdit->type];
                                      }

                                      // Debug to check the values
                                      // var_dump($recipeEdit->food, $decodedFood);
                                      ?>
                                      {{-- <pre>{{ var_dump($recipeEdit->food, $decodedFood) }}</pre> --}}



                                      <div class="col-lg-1" style="margin-top: 35px;">
                                          <input class="form-check-input" type="checkbox" value="Dine In" name="type[]" id="flexCheckDefault"
                                          @if(in_array('Dine In', explode(',', $recipeEdit->type))) checked @endif>
                                          <label class="form-check-label" for="flexCheckDefault">Dine In</label>

                                      </div>

                                      <div class="col-lg-1" style="margin-top: 35px;">
                                      <input class="form-check-input" type="checkbox" value="Delivery" name="type[]" id="flexCheckDefault1"
                                      @if(in_array('Delivery', explode(',', $recipeEdit->type))) checked @endif>
                                      <label class="form-check-label" for="flexCheckDefault1">Delivery</label>

                                      </div>
                                      {{-- ==================================================== --}}


                                      <div class="col-lg-2">

                                        <label class="form-label">Select Varient</label>
                                            <select class="single-select" name="varient" id="varient">

                                                <option value="">--Select--</option>
                                                <option value="Full" {{old('varient', $recipeEdit->varient)=='Full' ? 'selected':''}}>Full</option>
                                                <option value="Half" {{old('varient', $recipeEdit->varient)=='Half' ? 'selected':''}}>Half</option>


                                            </select>
                                    </div>

                                    <div class="col-lg-2">
										<label class="form-label">IGST</label>
										<input type="text" class="form-control" id="exampleInputEmail1"
											aria-describedby="emailHelp" placeholder="" name="igst"
                                            value="{{$recipeEdit->igst}}">

									</div>


                                    <div class="col-lg-2">
										<label class="form-label">CGST</label>
										<input type="text" class="form-control" id="exampleInputEmail1"
											aria-describedby="emailHelp" placeholder="" name="cgst"
                                            value="{{$recipeEdit->cgst}}">

									</div>


                                    <div class="col-lg-2">
										<label class="form-label">SGST</label>
										<input type="text" class="form-control" id="exampleInputEmail1"
											aria-describedby="emailHelp" placeholder="" name="sgst"
                                            value="{{$recipeEdit->sgst}}">

									</div>


									<div class="col-lg-3">
										<label for="inputAddress2" class="form-label">Recipe Description</label>
										<textarea class="form-control" id="inputAddress2" placeholder=""
                                        rows="3" name="description" >{{$recipeEdit->description}}</textarea>
									</div>


									<div class="col-lg-2"  style="margin-top: 35px;">
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



    {{-- to show confirmation alert message while delete --}}
    <script>
        function confirmDelete(recipeId) {
            var result = confirm('Are you sure you want to delete this Recipe?');
            if (!result) {
                event.preventDefault(); // Prevent the default action (deletion) if user clicks "Cancel"
            } else {
                window.location.href = '{{ url("recipeDestroy") }}/' + recipeId;
            }
        }
    </script>
