@extends('admin.layout.header')

@section('main-container')


<!-- Add this at the top of your Blade file to get the authenticated user -->
@auth
<?php $authenticatedUser = auth()->user(); ?>
@endauth


		<!--start page wrapper -->
		<div class="page-wrapper">
			<div class="page-content" style="margin-top: -20px">
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
					</div>
				</div>



				<!--end page wrapper -->
				<!--start overlay-->

				<div class="overlay toggle-icon"></div>
				{{-- <hr /> --}}
				<div class="col-md-12 mx-auto">
					<div class="card">
						<div class="card-body">
                            <div style="text-align: right; margin-right: 20px;">
                                <a href="counter-bill" style="background-color: #4CAF50; /* Green */
                                               border: none;
                                               color: white;
                                               padding: 10px 32px;
                                               text-align: center;
                                               text-decoration: none;
                                               display: inline-block;
                                               font-size: 16px;
                                               margin-bottom: 20px;
                                               margin-right: -20px;
                                               cursor: pointer;
                                               border-radius: 8px;">Create New Bill</a>
                            </div>

                        <div class="table-responsive">
								<table id="example" class="table table-striped table-bordered">
									<thead>
										<tr>
											<th>Sr No</th>
											<th>Order Id</th>
											<th>Date</th>
											<th>Contact Number</th>
                                            <th>Type</th>
											<th>Sub Total</th>
                                            <th>GST</th>
                                            <th>Discount</th>
                                            <th>Total</th>
											<th style="background-color: #ffffff;">Action</th>
										</tr>
									</thead>
									<tbody>

                                    <!-- Modify the loop to show recipes only for the authenticated user -->
                                    {{-- @foreach ($orders as $order) --}}
                                    @if ($authenticatedUser->orders)
                                    @foreach ($authenticatedUser->orders as $order)
                                    @php
                                    $totalPriceWithoutGst = 0;
                                    $totalPriceWithGst = 0;

                                    // Iterate through the carts of the current order
                                    foreach ($order->carts as $cart) {
                                        $recipe = $cart->recipe;
                                        if ($recipe) {
                                            // Calculate the total price for the current recipe (excluding GST)
                                            $recipeTotalPriceWithGst = $cart->quantity * $recipe->price;
                                            $recipeGstPercentage = ($recipe->igst + $recipe->cgst + $recipe->sgst);

                                            // Calculate the price without GST for the current recipe
                                            if ($recipeGstPercentage != 0) {
                                                $priceWithoutGst = $recipeTotalPriceWithGst / (1 + $recipeGstPercentage / 100);
                                            } else {
                                                $priceWithoutGst = $recipeTotalPriceWithGst;
                                            }

                                            // Accumulate the total prices
                                            $totalPriceWithoutGst += $priceWithoutGst;
                                            $totalPriceWithGst += $recipeTotalPriceWithGst;
                                        }
                                    }

                                    // Calculate the total GST
                                    $totalGst = $totalPriceWithGst - $totalPriceWithoutGst;

                                    // Calculate the GST percentage (handle division by zero)
                                    if ($totalPriceWithoutGst != 0) {
                                        $gstPercentage = ($totalGst / $totalPriceWithoutGst) * 100;
                                    } else {
                                        $gstPercentage = 0;
                                    }
                                @endphp
										<tr>
											<td>{{$loop->index+1}}</td>

                                            <td>{{$order->order_id2}}</td>
                                            <td>{{$order->created_at->format('d/m/Y')}}</td>

                                            <td>{{ $order->contact_number }}</td>
                                            <td>{{$order->type}}</td>

                                            <td>{{$order->total}}</td>
                                            <td>{{number_format($gstPercentage,2).'%'}}</td>
                                            <td>{{$order->discount ? $order->discount:0}}</td>
                                            <td>{{number_format($order->total - $order->discount + ($order->total*$gstPercentage/100),2)}}</td>

                                            <td>
                                                <a href="{{ route('bill', $order->id) }}" class="btn btn-primary">Generate Bill</a>

                                            </td>

										</tr>
                                        @endforeach
                                        @endif
									</tbody>

								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>


        @endsection

