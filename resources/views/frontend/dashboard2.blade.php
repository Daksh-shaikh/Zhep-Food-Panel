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
                                                            <select id="citySelect" class="form-control">
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
                                                        <canvas id="dineInChart" width="100" height="100"></canvas>
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
    document.getElementById('citySelect').addEventListener('change', fetchData);

    // Listen for changes in date inputs
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
        const url = '{{ route('orders.byType') }}' + '?city_id=' + cityId + '&from_date=' + fromDate + '&to_date=' + toDate;

        fetch(url, {
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': token
                }
            })
            .then(response => response.json())
            .then(data => {
                updateChart(data.dineInCount, data.deliveryCount);
                updateTotalOrders(data.totalCount);

            })
            .catch(error => {
                console.error('Error fetching orders:', error);
            });
    }

    function updateChart(dineInCount, deliveryCount) {
        var dineInCtx = document.getElementById('dineInChart').getContext('2d');

        // Check if a Chart instance already exists for the canvas element
        if (window.dineInChartInstance) {
            window.dineInChartInstance.destroy();
        }

        window.dineInChartInstance = new Chart(dineInCtx, {
            type: 'pie',
            data: {
                labels: ['Dine-In', 'Delivery'],
                datasets: [{
                    data: [dineInCount, deliveryCount],
                    backgroundColor: ['#ff6384', '#36a2eb']
                }]
            }
        });
    }

    function updateTotalOrders(totalCount) {
        document.getElementById('totalOrders').innerText = 'Total Orders: ' + totalCount;
    }
    // Initially fetch orders for the default city and dates
    fetchData();
</script>
@endsection
