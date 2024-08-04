@extends('frontend.layout.header')

@section('main-container')
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
                        {{-- <ul class="nav nav-tabs nav-primary" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link active" data-bs-toggle="tab" href="#primaryhome" role="tab" aria-selected="true">
                                    <div class="d-flex align-items-center">
                                        <div class="tab-icon"></div>
                                        <div class="tab-title">Order Table</div>
                                    </div>
                                </a>
                            </li>
                        </ul> --}}
                        <div class="tab-content py-3">
                            <div class="tab-pane fade show active" id="primaryhome" role="tabpanel">
                                <div class="col-md-12 mx-auto">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="container">
                                                <div class="row">
                                                    <div class="col-lg-4">
                                                        <div class="form-group">
                                                            <label for="citySelect">Select City:</label>
                                                            <select id="citySelect" class="form-control" name="city_id">
                                                                <option value="">All Cities</option>
                                                                @foreach ($city as $city_name)
                                                                <option value="{{$city_name->id}}">{{$city_name->city}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div class="form-group">
                                                            <label for="fromDate">From Date:</label>
                                                            <input type="date" id="fromDate" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div class="form-group">
                                                            <label for="toDate">To Date:</label>
                                                            <input type="date" id="toDate" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4 mx-auto" style="margin-top: 50px">
                                                        <canvas id="myPieChart" width="100" height="100"></canvas>

                                                        <div id="totalOrders" class="mt-3 text-center"></div> <!-- Add this line -->

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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



        <script>
            document.addEventListener('DOMContentLoaded', function () {
                var ctx = document.getElementById('myPieChart').getContext('2d');

                var myPieChart = new Chart(ctx, {
                    type: 'pie',
                    data: {
                        labels: ['Dine-In', 'Delivery', 'Take Aways'],
                        datasets: [{
                            data: [0, 0, 0], // Initial data
                            backgroundColor: ['#ff6384', '#36a2eb', '#ffce56']
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'top',
                            },
                            title: {
                                // display: true,
                                // text: 'Order Type Distribution'
                            }
                        }
                    }
                });

                document.getElementById('citySelect').addEventListener('change', fetchData);
                document.getElementById('fromDate').addEventListener('change', fetchData);
                document.getElementById('toDate').addEventListener('change', fetchData);

                function fetchData() {
                    var cityId = document.getElementById('citySelect').value;
                    var fromDate = document.getElementById('fromDate').value;
                    var toDate = document.getElementById('toDate').value;
                    fetchOrders(cityId, fromDate, toDate);
                }

                function fetchOrders(cityId, fromDate, toDate) {
                    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                    const url = `{{ route('orders.byType') }}?city_id=${cityId}&from_date=${fromDate}&to_date=${toDate}`;

                    fetch(url, {
                            method: 'GET',
                            headers: {
                                'X-CSRF-TOKEN': token,
                                'Content-Type': 'application/json'
                            }
                        })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Network response was not ok ' + response.statusText);
                            }
                            return response.json();
                        })
                        .then(data => {
                            console.log('Fetched Data:', data); // Debugging line
                            myPieChart.data.datasets[0].data = [data.dineInCount, data.deliveryCount, data.takeAwaysCount];
                            myPieChart.update();
                            document.getElementById('totalOrders').innerText = `Total Orders: ${data.totalCount}`;

                        })
                        .catch(error => {
                            console.error('Error fetching orders:', error);
                        });
                }

                // Initially fetch all orders
                fetchOrders('', '', '', '');
            });
        </script>
@endsection
