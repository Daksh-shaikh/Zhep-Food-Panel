@extends('admin.layout.header')

@section('main-container')

@auth
<?php $authenticatedUser = auth()->user(); ?>
@endauth

<!-- Add this at the top of your Blade file to get the authenticated user -->


		<!--start page wrapper -->
		<div class="page-wrapper">
			<div class="page-content">
				<div class="row">
					<div class="col-md-8 mx-auto">


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

								<h6>Add Logo</h6>
								<hr>
								<form class="row g-2" action="{{route('update-logo')}}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="col-md-3"></div>
                                    <div class="col-lg-4">
										<label class="form-label"> Logo </label>
                                        <input type="file" class="form-control" id="file" aria-describedby="emailHelp" placeholder="" name="logo" onchange="showImagePreview()">

                                        {{-- <label for="file">File name goes inside</label>
                                        <img id="imagePreview" src="{{ $authenticatedUser->logo ? asset('logo/' . $authenticatedUser->logo) : asset('admin/assets/images/image.png') }}" alt="Logo Preview" style="height: 40px; width: 40px; margin-bottom: 10px; margin-left: 10px"> --}}
                                    </div>


									<div class="col-lg-3"  style="margin-top: 35px;">
										<button type="submit" class="btn btn-success"><i
											class="lni lni-circle-plus"></i>Update</button>
									</div>
								</form>

							</div>

						</div>
					</div>
				</div>



				<!--end page wrapper -->
				<!--start overlay-->


			</div>
		</div>



		<!--end page wrapper -->

        @endsection
@section('js')

{{-- <script>
    function showImagePreview() {
        var input = document.getElementById('file');
        var imagePreview = document.getElementById('imagePreview');

        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                imagePreview.src = e.target.result;
            };

            reader.readAsDataURL(input.files[0]);
        } else {
            imagePreview.src = ''; // Clear the image source if no file is selected.
        }
    }
    </script> --}}
@endsection
