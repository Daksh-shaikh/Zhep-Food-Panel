@extends('admin.layout.header')

@section('main-container')
    <!--start page wrapper -->


    @auth
<?php $authenticatedUser = auth()->user(); ?>
@endauth


    <div class="page-wrapper">
        <div class="page-content">


            <div class="row" style="margin-top: -35px">
                <div class="card text-bg-dark m-3" style="max-width: 15rem;">
                    <div class="card-body">
                        <h5 class="card-title" style="color:#ffffff">Number Of Recipes</h5>
                        <p class="card-text">20</p>
                    </div>
                </div>

                <div class="card text-bg-dark mb-3 m-3" style="max-width: 15rem;">
                    <div class="card-body">
                        <h5 class="card-title" style="color:#ffffff">Number Of Waiter Registered</h5>
                        <p class="card-text">20</p>
                    </div>
                </div>

                <div class="card text-bg-dark mb-3 m-3" style="max-width: 15rem;">
                    <div class="card-body">
                        <h5 class="card-title" style="color:#ffffff">Number Of Kitchen Registered</h5>
                        <p class="card-text">20</p>
                    </div>
                </div>

                <div class="card text-bg-dark mb-3 m-3" style="max-width: 15rem;">
                    <div class="card-body">
                        <h5 class="card-title" style="color:#ffffff">Income Of This Month</h5>
                        <p class="card-text">20</p>
                    </div>
                </div>
            </div>

                    <div class="card">
                        <div class="card-body">
                            <!-- Button Tabs start -->
                            <div style="background-color: white;">
                                <div class="row">
                                    <div class="col-md-12" style="" align="center">

                                        <a href="{{ route('adminDashboard') }}" class="" id="over1"> <button
                                                type="button" id="overall" class="btn mjks"
                                                style="color:#ffffff; background-color: #49b6d6; height:30px; width:250px;"><i
                                                    class="fa fa-user" aria-hidden="true"></i>
                                                Registered Users<label id="overall1" class="circle shake" align="right"
                                                    style="display: none;"></label></button></a>

                                        <a href="{{ route('dashboard-waiter') }}" class="" id="over1"> <button
                                                type="button" id="overall" class="btn mjks"
                                                style="color:#ffffff; background-color: #49b6d6; height:30px; width:250px;"><i
                                                    class="fa fa-user" aria-hidden="true"></i>
                                                Registered Waiter<label id="overall1" class="circle shake" align="right"
                                                    style="display: none;"></label></button></a>

                                        <a href="{{ route('dashboard-food') }}" class="" id="over1"> <button
                                                type="button" id="overall" class="btn mjks"
                                                style="color:#ffffff; background-color: #49b6d6; height:30px; width:200px;"><i
                                                    class="fa fa-user" aria-hidden="true"></i>
                                                Food<label id="overall1" class="circle shake" align="right"
                                                    style="display: none;"></label></button></a>

                                        <a href="{{ route('dashboard-order') }}" class="" id="over1"> <button
                                                type="button" id="overall" class="btn mjks"
                                                style="color:#ffffff; background-color: #49b6d6; height:30px; width:175px;"><i
                                                    class="fa fa-user" aria-hidden="true"></i>
                                                    Orders<label id="overall1" class="circle shake" align="right"
                                                    style="display: none;"></label></button></a>

                                    </div>

                                </div>
                                <!-- Button Tabs End -->
<div></div>

</div>
</div>
                    </div>



            <div class="row" style="margin-top: -25px ">
                <div class="col-md-12 mx-auto">

                    <div class="card">
                        <div class="card-body">

                                <table id="example2" class="display nowrap" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Sr. No.</th>
                                            <th>Date</th>
                                            <th>Recipe</th>
                                            <th>Price</th>
                                            <th>Quantity</th>
                                            <th>Image</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>


                                    <!-- Modify the loop to show recipes only for the authenticated user -->
                                    @foreach ($authenticatedUser->recipes as $item)

                                    <tr>
                                        <td>{{$loop->index+1}}</td>

                                        <td>
                                            @if($item->cart_name)
                                            {{$item->cart_name->created_at->format('d-m-Y')}}
                                        @else
                                            null
                                        @endif
                                        </td>
                                        <td>{{$item->recipe}}</td>
                                        <td>{{$item->price}}</td>
                                        <td>
                                            @if($item->cart_name)
                                            {{$item->cart_name->quantity}}
                                        @else
                                            null
                                        @endif
                                        </td>
                                        <td>  <a href="{{asset('recipe/'. $item->image)}}"></a>
                                            <img height="50px" width="50px"  src="{{asset('recipe/'. $item->image)}}" alt="" />
                                        </td>

                                     <td>{{$item->price*$item->cart_name->quantity}}</td>

                                        @endforeach

                                        </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>



        <!--end page wrapper -->



        {{-- <script> https://cdn.datatables.net/2.0.8/js/dataTables.js</script>
<script> https://cdn.datatables.net/buttons/3.0.2/js/dataTables.buttons.js</script>
<script> https://cdn.datatables.net/buttons/3.0.2/js/buttons.dataTables.js</script>
<script> https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js</script>
<script> https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js</script>
<script> https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js</script>
<script> https://cdn.datatables.net/buttons/3.0.2/js/buttons.html5.min.js</script>
<script> https://cdn.datatables.net/buttons/3.0.2/js/buttons.print.min.js</script>
 --}}

        <script>
            new DataTable('#example2', {
                layout: {
                    topStart: {
                        buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
                    }
                }
            });
        </script>
    @endsection
