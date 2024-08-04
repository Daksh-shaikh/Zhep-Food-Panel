@extends('admin.layout.header')

@section('main-container')


<!-- Add this at the top of your Blade file to get the authenticated user -->
@auth
<?php $authenticatedUser = auth()->user(); ?>
@endauth


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

                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

						<div class="card">
							<div class="card-body">

								<h6>Add Recipe</h6>
								<hr>
								<form class="row g-2" action="{{route('recipeStore')}}" method="post" enctype="multipart/form-data">
                                    @csrf
									<div class="col-lg-2">
											<label class="form-label">Select Category</label>
											<select class="single-select" name="category">
                                                <option value="">--Select--</option>
                                                @foreach ($category as $category_name)
                                                <option value="{{$category_name->id}}">{{$category_name->category}}</option>

                                                @endforeach

											</select>
									</div>
									<div class="col-lg-2">
										<label class="form-label">Recipe Name</label>
										<input type="text" class="form-control" id="exampleInputEmail1"
											aria-describedby="emailHelp" placeholder="" name="recipe">
									</div>

									<div class="col-lg-2">
										<label class="form-label">Price</label>
										<input type="text" class="form-control" id="exampleInputEmail1"
											aria-describedby="emailHelp" placeholder="" name="price">

									</div>

                                    <div class="col-lg-1" style="margin-top: 35px;">
										<input class="form-check-input" type="checkbox" value="Veg" name="food[]" id="flexCheckDefault" >
										<label class="form-check-label" for="flexCheckDefault">Veg</label>
								    </div>

								<div class="col-lg-1" style="margin-top: 35px;">
									<input class="form-check-input" type="checkbox" value="Non-Veg" name="food[]" id="flexCheckDefault1">
									<label class="form-check-label" for="flexCheckDefault1">Non-Veg</label>
							    </div>

									<div class="col-lg-2">
										<label class="form-label">Recipe image</label>
										<input type="file" class="form-control" id="exampleInputEmail1"
											aria-describedby="emailHelp" placeholder="" name="image">

									</div>

                                    <div class="col-lg-1" style="margin-top: 35px;">
										<input class="form-check-input" type="checkbox" value="Dine In" name="type[]" id="flexCheckDefault" >
										<label class="form-check-label" for="flexCheckDefault">Dine In</label>

								</div>

								<div class="col-lg-1" style="margin-top: 35px;">
									<input class="form-check-input" type="checkbox" value="Delivery" name="type[]" id="flexCheckDefault1">
									<label class="form-check-label" for="flexCheckDefault1">Delivery</label>

							</div>


                            <div class="col-lg-2">

                                <label class="form-label">Select Varient</label>
                                    <select class="single-select" name="varient" id="varient">

                                        <option value="">--Select--</option>
                                        <option value="Full">Full</option>
                                        <option value="Half">Half</option>


                                    </select>
                            </div>

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
                                    aria-describedby="emailHelp" placeholder="" name="igst" value="0">
                            </div>

                            <div class="col-lg-2" style="display: none;"  id="gst-field">
                                <label class="form-label">GST (%)</label>
                                <input type="text" class="form-control" id="exampleInputEmail1"
                                    aria-describedby="emailHelp" placeholder="" name="gst" value="0">
                            </div>


									<div class="col-lg-3">
										<label for="inputAddress2" class="form-label">Recipe Description</label>
										<textarea class="form-control" id="inputAddress2" placeholder=""
                                        rows="3" name="description"></textarea>
									</div>


									<div class="col-lg-2"  style="margin-top: 35px;">
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
				<div class="col-md-12 mx-auto">
					<div class="card">
						<div class="card-body">
							<div class="table-responsive">
								<table id="example" class="table table-striped table-bordered">
									<thead>
										<tr>
											<th>Sr No</th>
											<th>Category</th>
											<th>Recipe Name</th>
											<th>Price</th>
											<th>Recipe image</th>
                                            <th>IGST</th>
                                            <th>CGST</th>
                                            <th>SGST</th>
											<th>Recipe Description</th>
                                            <th>Status</th>
											<th style="background-color: #ffffff;">Action</th>
										</tr>
									</thead>
									<tbody>


                                    <!-- Modify the loop to show recipes only for the authenticated user -->
                                    @foreach ($authenticatedUser->recipes as $item)

										<tr>
											<td>{{$loop->index+1}}</td>
											{{-- <td>{{$item->category}}</td> --}}
                                            <td>
                                                @if($item->category_name)
                                                {{ $item->category_name->category }}
                                            @else
                                                null
                                            @endif

                                            {{-- {{$item->category_id}} --}}
                                            </td>
                                            <td>{{$item->recipe}}</td>
                                            <td>{{$item->price}}</td>
                                            {{-- <td>{{$recipe->image}}</td> --}}
                                            <td>  <a href="{{asset('recipe/'. $item->image)}}"></a>
                                                <img height="50px" width="50px"  src="{{asset('recipe/'. $item->image)}}" alt="" />
</td>
                                            <td>{{$item->igst}}</td>
                                            <td>{{$item->cgst}}</td>
                                            <td>{{$item->sgst}}</td>
                                            <td>{{$item->description}}</td>


                                            {{-- active inactive button --}}
                                            <td style="background-color: #ffffff;">
                                                <div class="d-flex align-items-center">

                                                           <?php if ($item->status=='1'){?>

                                                            <a href="{{url('/update_recipe_status', $item->id)}}"
                                                                class="btn btn-success"> Active</a>

                                                                <?php } else {?>
                                                                <a href="{{url('/update_recipe_status', $item->id)}}"
                                                                    class="btn btn-danger">Inactive</a>
                                                                    <?php
                                                            }?>
                                                            </td>

                                        {{--active inactive button end  --}}

											<td style="background-color: #ffffff;">

                                                <a href="{{route('recipeEdit', $item->id)}}">
                                                    <button type="submit" class="btn1 btn-outline-success"><i
														class='bx bx-edit-alt me-0'></i></button></a>

                                                        {{-- <a href="{{route('recipeDestroy', $item->id)}}">
                                                        <button type="button"
													class="btn1 btn-outline-danger"
                                                    onclick="confirmDelete({{ $item->id }})"><i
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



		<!--end page wrapper -->

        @endsection

        @section('js')
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
