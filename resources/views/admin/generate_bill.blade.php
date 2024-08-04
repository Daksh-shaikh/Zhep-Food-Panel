@extends('admin.layout.header')

@section('main-container')

<!-- Add this at the top of your Blade file to get the authenticated user -->
@auth
<?php $authenticatedUser = auth()->user(); ?>
@endauth

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
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 mx-auto">
                <div class="card">
                    <div class="card-body">
                        <h6>Generate Bill</h6>
                        <hr>
<form action="{{route('counter-bill-store')}}" method="post">
    @csrf
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Select Category <span style="color: red;">*</span></th>
                                        <th>Select Items <span style="color: red;">*</span></th>
                                        <th>Quantity <span style="color: red;">*</span></th>
                                        <th>Price <span style="color: red;">*</span></th>
                                        <th>Total <span style="color: red;">*</span></th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <select class="single-select" id="category" >
                                                <option value="">--Select--</option>
                                                @foreach ($categoryNames as $categoryName)
                                                    <option value="{{ $categoryName }}">{{ $categoryName }}</option>
                                                @endforeach
                                            </select>

                                            {{-- <select class="single-select" name="category">
                                                <option value="">--Select--</option>
                                                @foreach ($category as $category_name)
                                                <option value="{{$category_name->id}}">{{$category_name->category}}</option>

                                                @endforeach

											</select> --}}
                                        </td>



                                        <td>
                                            <select class="single-select" id="item" onchange="updatePrice()"  >
                                                <option value="">--Select--</option>
                                                @foreach ($authenticatedUser->recipes as $recipe)
                                                <option value="{{ $recipe->id }}" data-price="{{ $recipe->price }}">{{ $recipe->recipe }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <input type="number" class="form-control" id="quantity" placeholder="Enter Quantity" oninput="calculateTotal()" />
                                        </td>
                                        <td>
                                            <input type="number" class="form-control" id="price" placeholder="Enter Price" readonly />
                                        </td>
                                        <td>
                                            <input type="number" class="form-control" id="total" placeholder="Enter Total" readonly />
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-success add-row-slot">
                                                <i class="fa fa-plus" style="font-size: 16px"></i> ADD
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <table class="table table-bordered" style="margin-top: 5px;">
                                <thead>
                                    <tr style="background-color:#f0f0f0;">
                                        <th style="text-align:center">Sr.No</th>
                                        <th style="text-align:center">Selected Category</th>
                                        <th style="text-align:center">Selected Item</th>
                                        <th style="text-align:center">Quantity</th>
                                        <th style="text-align:center">Price</th>
                                        <th style="text-align:center">Total</th>
                                        <th style="text-align:center">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="add_more_slot"></tbody>
                            </table>
                        </div>

                        <div class="form-group row mt-4">
                            <label for="name" class="col-lg-2 col-form-label">Customer Name</label>
                            <div class="col-lg-4">
                                <input type="text" id="name" class="form-control" name="customer_name" value="Customer" required>
                            </div>
                        </div>

                        <div class="form-group row mt-4">
                            <label for="contact" class="col-lg-2 col-form-label">Contact</label>
                            <div class="col-lg-4">
                                <input type="text" id="contact" class="form-control" name="contact" required>
                            </div>
                        </div>

                        <div class="form-group row mt-4">
                            <label for="total_amount" class="col-lg-2 col-form-label">Total Amount</label>
                            <div class="col-lg-4">
                                <input type="text" id="total_amount" class="form-control" name="total_amount" required readonly>
                            </div>
                        </div>

                        <div class="form-group row mt-4">
                            <label for="discount" class="col-lg-2 col-form-label">Discount</label>
                            <div class="col-lg-4">
                                <input type="number" id="discount" class="form-control" name="discount" value="0" oninput="updateTotalAmount()" required>
                            </div>
                        </div>


                        <div class="form-group row mt-4">
                            <label for="discount" class="col-lg-2 col-form-label">Final Amount</label>
                            <div class="col-lg-4">
                                <input type="number" id="final_amount" class="form-control" name="final_amount" required readonly>
                            </div>
                        </div>
                        <div class="form-group row mt-4" style="margin-right: -30px">
                            <div class="col-lg-4 offset-lg-9">
                                <button type="submit" class="btn btn-success">Submit & Generate Bill</button>
                            </div>
                        </div>
                    </div>
                </form>
                </div>
            </div>
        </div>

    </div>
</div>

@endsection

@section('js')
{{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}



 <script>
    $(document).ready(function () {
        var rowCount = 0;

        $("#category").change(function() {
            var categoryId = $(this).val();
            var url = categoryId ? '{{ route("get-recipes", ":id") }}'.replace(':id', categoryId) : '{{route("get-all-recipes")}}'
            // if (categoryId) {
                $.ajax({
                    url: url,
                    type: 'GET',
                    success: function (data) {
                        $('#item').empty().append('<option value="">--Select--</option>');
                        $.each(data, function (key, value) {
                            $('#item').append('<option value="' + value.id + '" data-price="' + value.price + '">' + value.recipe + '</option>');
                        });
                        // $('#item').select2({
                        //     placeholder: "--Select--"
                        // });
                    }
                });
            // }
            // else {
            //     $('#item').empty().append('<option value="">--Select--</option>').select2({
            //         placeholder: "--Select--"
            //     });
            // }
        });

        $(".add-row-slot").click(function () {
            rowCount++;
            var categorySelect = $('#category');
            var selectedCategoryText = categorySelect.find("option:selected").text();
            var categoryId = categorySelect.val();

            var itemSelect = $('#item');
            var selectedItemText = itemSelect.find("option:selected").text();
            var itemId = itemSelect.val();
            var quantity = $('#quantity').val();
            var price = $('#price').val();
            var total = parseFloat($('#total').val());

            if (itemId === '' || quantity.trim() === '' || price.trim() === '' || isNaN(total) || total <= 0) {
                alert('Please fill in all fields with valid values before adding a new row.');
                return;
            }

            var markup =
                '<tr>' +
                '<td style="text-align:center;">' + rowCount + '</td>' +
                '<td>' + selectedCategoryText + '<input type="hidden" name="category[]" value="' + categoryId + '"></td>' +
                '<td>' + selectedItemText + '<input type="hidden" name="items[]" value="' + itemId + '"></td>' +
                '<td><input type="text" name="quantities[]" required class="form-control-plaintext" value="' + quantity + '"></td>' +
                '<td><input type="text" name="prices[]" required class="form-control-plaintext" value="' + price + '"></td>' +
                '<td><input type="text" name="totals[]" required class="form-control-plaintext" value="' + total.toFixed(2) + '"></td>' +
                '<td style="text-align:center;"><button class="btn btn-danger delete-row"><i class="fa fa-trash-o"></i></button></td>' +
                '</tr>';

            $(".add_more_slot").append(markup);

            $('#category').val('');
            $('#item').val('');
            $('#quantity').val('');
            $('#price').val('');
            $('#total').val('');

            updateTotalAmount();
        });

        function updateTotalAmount() {
            var totalAmount = 0;
            $("input[name='totals[]']").each(function () {
                totalAmount += parseFloat($(this).val());
            });

            var discount = parseFloat($('#discount').val());
            if (isNaN(discount) || discount < 0) {
                discount = 0;
            }

            var finalAmount = totalAmount - discount;

            $('#total_amount').val(totalAmount.toFixed(2));
            $('#final_amount').val(finalAmount.toFixed(2));
        }

        $("tbody").on("click", ".delete-row", function () {
            $(this).parents("tr").remove();
            updateTotalAmount();
        });

        $('#discount').on('input', function() {
            updateTotalAmount();
        });
    });

    function updatePrice() {
        var select = document.getElementById('item');
        var selectedOption = select.options[select.selectedIndex];
        var price = selectedOption.getAttribute('data-price');

        document.getElementById('price').value = price;
        calculateTotal();
    }

    function calculateTotal() {
        var quantity = document.getElementById('quantity').value;
        var price = document.getElementById('price').value;
        var total = quantity * price;

        document.getElementById('total').value = total;
    }

    document.getElementById('item').addEventListener('change', function() {
        updatePrice();
        calculateTotal();
    });

    document.getElementById('quantity').addEventListener('input', calculateTotal);
</script>

{{-- To show search bar in select drop down of recipe --}}
{{-- <script>
    $(document).ready(function() {
        $('#item').select2({
            placeholder: "--Select--"
        });
    });
</script> --}}


@endsection
