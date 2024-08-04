@extends('frontend.layout.header')

@section('main-container')
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


								<h6>Add Category</h6>
								<hr>
								<form class="row g-2" method="POST" action="{{route('categoryStore')}}">
                                    @csrf
									<div class="col-md-2"></div>
									<div class="col-lg-5">
										<label class="form-label">Category</label>
										<input type="text" class="form-control" id="exampleInputEmail1"
											aria-describedby="emailHelp" placeholder="" name="category">

									</div>

                                    {{-- <div class="col-lg-2" style="margin-top: 35px;">
										<input class="form-check-input" type="checkbox" value="Dine In" name="type[]" id="flexCheckDefault" >
										<label class="form-check-label" for="flexCheckDefault">Dine In</label>

								</div>

								<div class="col-lg-2" style="margin-top: 35px;">
									<input class="form-check-input" type="checkbox" value="Delivery" name="type[]" id="flexCheckDefault1">
									<label class="form-check-label" for="flexCheckDefault1">Delivery</label>

							</div> --}}
									{{-- <div class="col-md-2" style="margin-top:35px;">
										<button type="submit" class="btn btn-success"><i
											class="lni lni-circle-plus"></i>Submit</button>
									</div> --}}
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
											<th>Category</th>
                                            <th>Status</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
                                        @foreach ($category as $category)


										<tr>
											<td>{{$loop->index+1}}</td>
											<td>{{$category->category}}</td>
                                            {{-- <td>
                                                @if($category->type)
                                                    @php
                                                        $decodedtype = json_decode($category->type, true);
                                                    @endphp

                                                    @if(is_array($decodedtype))
                                                        {{ implode(', ', $decodedtype) }}
                                                    @else
                                                        {{ $category->type }}
                                                    @endif
                                                @endif
                                            </td> --}}

                                            <td style="background-color: #ffffff;">
                                                <div class="d-flex align-items-center">

                                                           <?php if ($category->status=='1'){?>

                                                            <a href="{{url('/update_category_status', $category->id)}}"
                                                                class="btn btn-success"> Active</a>

                                                                <?php } else {?>
                                                                <a href="{{url('/update_category_status', $category->id)}}"
                                                                    class="btn btn-danger">Inactive</a>
                                                                    <?php
                                                            }?>
                                                            </td>

											<td>

                                                <a href="{{route('categoryEdit', $category->id)}}">
                                                <button type="button" class="btn1 btn-outline-success"><i
														class='bx bx-edit-alt me-0'></i></button>
                                                    </a>

                                                        {{-- <a href="{{route('categoryDestroy', $category->id)}}">
                                                        <button type="button"
													class="btn1 btn-outline-danger"
                                                    onclick="confirmDelete({{ $category->id }})"><i
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
        function confirmDelete(categoryId) {
            var result = confirm('Are you sure you want to delete this Category?');
            if (!result) {
                event.preventDefault(); // Prevent the default action (deletion) if user clicks "Cancel"
            } else {
                window.location.href = '{{ url("categoryDestroy") }}/' + categoryId;
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
