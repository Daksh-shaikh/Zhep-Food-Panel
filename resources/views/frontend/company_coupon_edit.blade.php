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
								<form class="row g-2" method="post" action="{{route('companyCouponUpdate')}}" enctype="multipart/form-data">
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
									<div class="col-lg-2">

											<label class="form-label">Select Restaurant</label>
											<select class="single-select" name="restaurant">
                                                <option value="">--select--</option>
                                                @foreach ($restro as $restro_name)
                                                    <option value="{{ $restro_name->id }}"
                                                        {{ old('restaurant', $couponEdit->restaurant_id) == $restro_name->id ? 'selected' : '' }}>
                                                        {{ $restro_name->restaurant}}</option>
                                                @endforeach
                                                    </select>
									</div>
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
											<th>Restaurant</th>
											<th>Coupon Code</th>
											<th>DS Type</th>
											<th>Value</th>
											<th>Start From</th>
											<th>Up to</th>
											<th>Min. Cost Value</th>
											<th style="background-color: #ffffff;">Action</th>
										</tr>
									</thead>
									<tbody>

                                        @foreach ($coupon as $coupon)


										<tr>
											<td>{{$loop->index+1}}</td>

                                            <td>
                                                @if($coupon->restaurant_name)
                                                {{ $coupon->restaurant_name->restaurant}}
                                            @else
                                                null
                                            @endif</td>

											<td>{{$coupon->code}}</td>
											<td>{{$coupon->dstype}}</td>
											<td>{{$coupon->value}}</td>
											<td>{{$coupon->start_from}}</td>
											<td>{{$coupon->upto}}</td>
											<td>{{$coupon->min_cost}}</td>
											<td style="background-color: #ffffff;">



                                                        <a href="{{route('couponDestroy', $coupon->id)}}">
                                                        <button type="button"
													class="btn1 btn-outline-danger"
                                                    onclick="confirmDelete({{ $coupon->id }})"><i
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


 --}}
		<!--end page wrapper -->


		@endsection


    {{-- to show confirmation alert message while delete --}}

   <script>
    function confirmDelete(couponId) {
        var result = confirm('Are you sure you want to delete this Coupon?');
        if (!result) {
            event.preventDefault(); // Prevent the default action (deletion) if user clicks "Cancel"
        } else {
            window.location.href = '{{ url("couponDestroy") }}/' + couponId;
        }
    }
</script>
