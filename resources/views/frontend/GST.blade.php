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

								<h6>Add IGST</h6>
								{{-- <hr> --}}
								<form class="row g-2" method="post" action="{{route('gstStore')}}">
                                    @csrf

                                    <input type="hidden" name="type" value="igst">
                                    <input type="hidden" name="id" value="{{ $igst->id }}"> <!-- Add this hidden input field for id -->

                                <div class="col-lg-3">
                                    <label class="form-label">DS Type</label>
                                    <select class="single-select" name="dstype">
                                        <option value="Percent" {{old('dstype', $igst->dstype)==='Percent' ? 'selected' : ''}}>%</option>
                                        <option value="Rupee" {{old ('dstype', $igst->dstype)==='Rupee' ? 'selected' : ''}}>₹</option>
                                    </select>
                            </div>

									<div class="col-lg-3">
										<label class="form-label">Value</label>
										<input type="text" class="form-control" id="exampleInputEmail1"
											aria-describedby="emailHelp" placeholder="" name="value" value="{{$igst->value}}">

									</div>


									<div class="col-md-2" style="margin-top:35px;">
										<button type="submit" class="btn btn-success">
                                            <i class="fa fa-pencil-square-o" aria-hidden="true" style="font-size: 19px"></i>
                                            Update</button>
									</div>
								</form>


<hr>
<div style="margin-top: 40px"></div>
								<h6>Add CGST</h6>
								{{-- <hr> --}}
								<form class="row g-2" method="post" action="{{route('gstStore')}}">
                                    @csrf

                                    <input type="hidden" name="type" value="cgst">

                                <div class="col-lg-3">
                                    <label class="form-label">DS Type</label>
                                    <select class="single-select" name="dstype">
                                        <option value="Percent" {{old('dstype', $cgst->dstype)==='Percent' ? 'selected' : ''}}>%</option>
                                        <option value="Rupee" {{old ('dstype', $cgst->dstype)==='Rupee' ? 'selected' : ''}}>₹</option>
                                    </select>
                            </div>

									<div class="col-lg-3">
										<label class="form-label">Value</label>
										<input type="text" class="form-control" id="exampleInputEmail1"
											aria-describedby="emailHelp" placeholder="" name="value" value="{{$cgst->value}}">

									</div>


									<div class="col-md-2" style="margin-top:35px;">
										<button type="submit" class="btn btn-success">
                                            <i class="fa fa-pencil-square-o" aria-hidden="true" style="font-size: 19px"></i>
                                            Update</button>
									</div>
								</form>



<hr>
<div style="margin-top: 40px"></div>
								<h6>Add SGST</h6>
								{{-- <hr> --}}
								<form class="row g-2" method="post" action="{{route('gstStore')}}">
                                    @csrf

                                    <input type="hidden" name="type" value="sgst">

                                <div class="col-lg-3">
                                    <label class="form-label">DS Type</label>
                                    <select class="single-select" name="dstype">
                                        <option value="Percent" {{old('dstype', $sgst->dstype)==='Percent' ? 'selected' : ''}}>%</option>
                                        <option value="Rupee" {{old ('dstype', $sgst->dstype)==='Rupee' ? 'selected' : ''}}>₹</option>
                                    </select>
                            </div>

									<div class="col-lg-3">
										<label class="form-label">Value</label>
										<input type="text" class="form-control" id="exampleInputEmail1"
											aria-describedby="emailHelp" placeholder="" name="value" value="{{$sgst->value}}">

									</div>


									<div class="col-md-2" style="margin-top:35px;">
										<button type="submit" class="btn btn-success">
                                            <i class="fa fa-pencil-square-o" aria-hidden="true" style="font-size: 19px"></i>
                                            Update</button>
									</div>
								</form>


							</div>

						</div>
					</div>
				</div>


			</div>
		</div>



		<!--end page wrapper -->

        @endsection
