@extends('admin.layout.header')

@section('main-container')

@auth
<?php $authenticatedUser = auth()->user(); ?>
@endauth


<div class="page-wrapper">
    <div class="page-content">
        <div class="row" style="margin-top: -35px">
            <!-- Your existing cards -->
        </div>

        <div class="card">
            <div class="card-body">
                {{-- {{auth()->user()}} --}}
                <div class="tab-content py-3">
                    <div class="tab-pane fade show active" id="primaryhome" role="tabpanel">
                <div class="row">
                    <div class="col-md-6 mx-auto">
                        <div class="card">
                            <div class="card-body">
                                <div class="container">
                                    <div class="row" >
{{--
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="citySelect">Select City:</label>
                                                <select id="citySelect" class="form-control">
                                                    <option value="">All Cities</option>
                                                    @foreach ($city as $city_name)
                                                    <option value="{{$city_name->id}}">{{$city_name->city}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div> --}}
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="fromDate">From Date:</label>
                                                <input type="date" id="fromDate" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="toDate">To Date:</label>
                                                <input type="date" id="toDate" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-lg-6 mx-auto" style="margin-top: 50px">
                                            <canvas id="dineInChart" width="400" height="400"></canvas>
                                            <div id="totalOrders" class="mt-3 text-center"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mx-auto">
                        <div class="card">
                            <div class="card-body">
                                <div class="container">
                                    <div class="row" >

                                        {{-- <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="citySelect">Select City:</label>
                                                <select id="citySelect2" class="form-control">
                                                    <option value="">All Cities</option>
                                                    @foreach ($city as $city_name)
                                                    <option value="{{$city_name->id}}">{{$city_name->city}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div> --}}
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="fromDate">From Date:</label>
                                                <input type="date" id="fromDate2" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="toDate">To Date:</label>
                                                <input type="date" id="toDate2" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-lg-6 mx-auto" style="margin-top: 50px">
                                            <canvas id="orderChart" width="100" height="100"></canvas>
                                            <div id="totalOrders2" class="mt-3 text-center"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                    </div>
                </div>


            <div class="row">
                <div class="form-group col-md-3">

                    <input class="form-control" id="fromDate3" placeholder="From Date" type="date">
                  </div>
                  <div class="form-group col-md-3">
                    <input class="form-control" id="toDate3" placeholder="To Date" type="date">
                  </div>

                  <div class="form-group col-md-3">
                    <button class="btn btn-primary" id="searchButton" type="button" style="height: 38px;">
                      <i class="fa fa-search" aria-hidden="true"></i> Search
                    </button>
                </div>
            </div>

            <div style="margin-bottom:20px"></div>

<div class="overlay toggle-icon"></div>
				{{-- <hr /> --}}
				<div class="col-md-12 mx-auto">
					{{-- <div class="card">
						<div class="card-body"> --}}
							<div class="table-responsive">
								<table id="exampleX" class="table table-striped table-bordered">
									<thead>
										<tr>
											<th>Sr No</th>
											<th>Order Id</th>
                                            <th>Order Date</th>
											<th>Customer Name</th>
											<th>Contact Number</th>
											<th>Type</th>
                                            <th>Delivery Type</th>
                                            <th>Sub Total</th>
                                            <th>Discount</th>
                                            <th>GST</th>
                                            <th>Total</th>

                                            {{-- <th>Status</th> --}}
											{{-- <th style="background-color: #ffffff;">Action</th> --}}
										</tr>
									</thead>
									<tbody>


                                    <!-- Modify the loop to show recipes only for the authenticated user -->
                                    @if ($authenticatedUser->orders)
                                    @foreach ($authenticatedUser->orders as $item)

                                    @php
                                    $totalPriceWithoutGst = 0;
                                    $totalPriceWithGst = 0;

                                    // Iterate through the carts of the current order
                                    foreach ($item->carts as $cart) {
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
                                            <td>{{$item->order_id2}}</td>
                                            <td>{{$item->created_at->format('d/m/Y')}}</td>
                                            <td>
                                                @if($item->user)
                                                {{ $item->user->name }}
                                            @else
                                                null
                                            @endif
                                            </td>
                                            <td>{{$item->contact_number}}</td>
                                            <td>{{$item->type}}</td>
                                            <td>{{$item->delivery_type}}</td>
                                            <td>{{$item->total}}</td>
                                            <td>{{$item->discount ? $item->discount:0}}</td>
                                            <td>{{number_format($gstPercentage,2).'%'}}</td>
                                            <td>{{number_format($item->total - $item->discount + ($item->total*$gstPercentage/100),2)}}</td>

										</tr>
                                        @endforeach
                                        @endif
									</tbody>

								</table>
							{{-- </div>
						</div> --}}
					</div>
				</div>
			</div>
		</div>
    </div>
</div>
</div>
</div>
@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>



{{-- Order Dine In or Delivery --}}
<script>
    // document.getElementById('citySelect').addEventListener('change', fetchData);
    document.getElementById('fromDate').addEventListener('change', fetchData);
    document.getElementById('toDate').addEventListener('change', fetchData);

    function fetchData() {
        // var cityId = document.getElementById('citySelect').value;
        var fromDate = document.getElementById('fromDate').value;
        var toDate = document.getElementById('toDate').value;
        fetchOrders(fromDate, toDate);
    }

    function fetchOrders(fromDate, toDate) {
        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const url = `{{ route('orders.byTypeAdmin') }}?from_date=${fromDate}&to_date=${toDate}`;

        fetch(url, {
            method: 'GET',
            headers: {
                'X-CSRF-TOKEN': token,
                'Accept': 'application/json'
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            if (data.totalCount === 0) {
                updateChart(0, 0, 0, true);
                updateTotalOrders(0, true);
            } else {
                updateChart(data.dineInCount, data.deliveryCount, data.takeAways, false);
                updateTotalOrders(data.totalCount, false);
            }
        })
        .catch(error => {
            console.error('Error fetching orders:', error);
        });
    }

    function updateChart(dineInCount, deliveryCount, takeAways, noOrders) {
        var dineInCtx = document.getElementById('dineInChart').getContext('2d');

        if (window.dineInChartInstance) {
            window.dineInChartInstance.destroy();
        }

        let chartData, chartOptions;

        if (noOrders) {
            chartData = {
                labels: ['No Orders'],
                datasets: [{
                    data: [1],
                    backgroundColor: ['#d3d3d3'] // Light grey color for no orders
                }]
            };
            chartOptions = {
                title: {
                    display: true,
                    text: 'No orders for the selected dates'
                }
            };
        } else {
            chartData = {
                labels: ['Dine-In', 'Delivery', 'Take Away'],
                datasets: [{
                    data: [dineInCount, deliveryCount, takeAways],
                    backgroundColor: ['#ff6384', '#36a2eb', '#ffce56']
                }]
            };
            chartOptions = {};
        }

        window.dineInChartInstance = new Chart(dineInCtx, {
            type: 'pie',
            data: chartData,
            options: chartOptions
        });
    }

    function updateTotalOrders(totalCount, noOrders) {
        const totalOrdersElement = document.getElementById('totalOrders');
        if (noOrders) {
            totalOrdersElement.innerText = 'No orders for the selected dates';
        } else {
            totalOrdersElement.innerText = 'Total Orders: ' + totalCount;
        }
    }

    fetchData();
</script>



{{-- Order Completed Or Cancelled --}}


<script>
//    document.getElementById('citySelect2').addEventListener('change', fetchData2);
document.getElementById('fromDate2').addEventListener('change', fetchData2);
document.getElementById('toDate2').addEventListener('change', fetchData2);

function fetchData2() {
    // var cityId2 = document.getElementById('citySelect2').value;
    var fromDate2 = document.getElementById('fromDate2').value;
    var toDate2 = document.getElementById('toDate2').value;
    fetchOrders2(fromDate2, toDate2);
}

function fetchOrders2( fromDate2, toDate2) {
    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const url = `{{ route('orders.byStatus') }}?from_date2=${fromDate2}&to_date2=${toDate2}`;

    fetch(url, {
        method: 'GET',
        headers: {
            'X-CSRF-TOKEN': token,
            'Accept': 'application/json'
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        if (data.totalCount === 0) {
            updateChart2(0, 0, true);
            updateTotalOrders2(0, true);
        } else {
            updateChart2(data.CompletedCount, data.CancelledCount, data.InprogressCount, false);
            updateTotalOrders2(data.totalCount, false);
        }
    })
    .catch(error => {
        console.error('Error fetching orders:', error);
    });
}

function updateChart2(CompletedCount, CancelledCount, InprogressCount, noOrders) {
    var orderChartCtx = document.getElementById('orderChart').getContext('2d');

    if (window.orderChartInstance) {
        window.orderChartInstance.destroy();
    }

    let chartData, chartOptions;

    if (noOrders) {
        chartData = {
            labels: ['No Orders'],
            datasets: [{
                data: [1],
                backgroundColor: ['#d3d3d3'] // Light grey color for no orders
            }]
        };
        chartOptions = {
            title: {
                display: true,
                text: 'No orders for the selected dates'
            }
        };
    } else {
        chartData = {
            labels: ['Completed', 'Cancelled', 'Inprogress'],
            datasets: [{
                data: [CompletedCount, CancelledCount, InprogressCount],
                backgroundColor: ['#36a2eb', '#ff6384', '#ffce56']
            }]
        };
        chartOptions = {};
    }

    window.orderChartInstance = new Chart(orderChartCtx, {
        type: 'pie',
        data: chartData,
        options: chartOptions
    });
}

function updateTotalOrders2(totalCount, noOrders) {
    const totalOrdersElement = document.getElementById('totalOrders2');
    if (noOrders) {
        totalOrdersElement.innerText = 'No orders for the selected dates';
    } else {
        totalOrdersElement.innerText = 'Total Orders: ' + totalCount;
    }
}

fetchData2();

</script>



<script>
    $(document).ready(function() {
        var table = $('#exampleX').DataTable();

        $('#searchButton').on('click', function() {
            table.draw();
        });

        $.fn.dataTable.ext.search.push(
            function(settings, data, dataIndex) {
                var min = $('#fromDate3').val() ? new Date($('#fromDate3').val()).getTime() : null;
                var max = $('#toDate3').val() ? new Date($('#toDate3').val()).getTime() : null;
                var createdAt = new Date(data[2].split('/').reverse().join('-')).getTime(); // use data for the date column

                if ((min === null && max === null) ||
                    (min === null && createdAt <= max) ||
                    (min <= createdAt && max === null) ||
                    (min <= createdAt && createdAt <= max)) {
                    return true;
                }
                return false;
            }
        );
    });
</script>








@endsection
