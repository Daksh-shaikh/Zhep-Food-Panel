@extends('admin.layout.header')

@section('main-container')


<!-- Add this at the top of your Blade file to get the authenticated user -->


		<!--start page wrapper -->
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


						<div class="card">
							<div class="card-body">

								<h6>Add Waiter</h6>
								<hr>
								<form class="row g-2" action="{{route('waiter-update')}}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="id" value="{{$waiterEdit->id}}"/>

									<div class="col-lg-2">
										<label class="form-label">Name</label>
										<input type="text" class="form-control" id="exampleInputEmail1"
											aria-describedby="emailHelp" placeholder="" name="name" value="{{$waiterEdit->name}}">

									</div>

									<div class="col-lg-2">
										<label class="form-label">Contact</label>
										<input type="text" class="form-control" id="exampleInputEmail1"
											aria-describedby="emailHelp" placeholder="" name="contact" value="{{$waiterEdit->contact}}">

									</div>
									<div class="col-lg-2">
										<label class="form-label">email</label>
										<input type="text" class="form-control" id="exampleInputEmail1"
											aria-describedby="emailHelp" placeholder="" name="email" value="{{$waiterEdit->email}}">

									</div>

                                    <div class="col-lg-2">
										<label class="form-label">password</label>
										<input type="password" class="form-control" id="exampleInputEmail1"
											aria-describedby="emailHelp" placeholder="" name="password" >

									</div>




                                      {{-- ---------------------------------------------------------- --}}
        {{-- layout image section --}}


{{--====================================================================================================================  --}}

                                    {{-- <div class="col-md-6" style="margin-top:2vh;">
                                        <div class="row"> --}}

                                         <!-- layout image section  -->

                                         <div class="col-md-12" style="margin-top: 1px;">

                                            <div class="col-md-6">
                                                <table width="100%">

                                          {{-- layout image section --}}
                                        <!-- layout Image -->
                                       {{-- <div class="col-md-12">
                                           <table width="80%"> --}}
                                               <tr style="height:30px;">
                                                   <th width="30%">Upload Documents<span style="color: red;">*</span></th>
                                               </tr>
                                               <tr>
                                                   <td style="padding: 2px;" width="20%">
                                                       <input type="file" class="form-control" id="document" placeholder="" />
                                                   </td>
                                                   <td style="padding: 2px;" width="2%">
                                                       <a>
                                                           <button id="on" type="button" class="btn mjks add-row-image"
                                                               style="color:#FFFFFF; height:30px; width:auto;background-color: #006699; margin-left: 4px;">
                                                               <i class="fa fa-plus " aria-hidden="true"></i></button>
                                                       </a>
                                                   </td>
                                               </tr>
                                           </table>
                                           <table width="100%" border="1" style="margin-top: 5px; margin-bottom:20px">
                                               <tr style="background-color:#f0f0f0; height:30px;">
                                                   <th width="3%" style="text-align:center">Sr.No</th>
                                                   <th width="5%" style="text-align:center">Added Documents</th>
                                                   <th width="5%" style="text-align:center">Action</th>
                                               </tr>
                                               <tbody class="add_more_image">
                                                   @foreach ($layoutImages as $item)
                                                   <tr class="existing-row" data-image-id="{{ $item->id }}">
                                                       <td style="text-align:center;">{{ $loop->index + 1 }}</td>
                                                       <td>
                                                           <input type="hidden" name="existing_id[]" value="{{ $item->waiter_id }}">
                                                           <input type="hidden" value="{{ $item->document }}">
                                                           <img src="{{ asset('/' . $item->document) }}"
                                                               style="max-width: 50px; max-height: 50px;">
                                                       </td>
                                                       <td style="text-align:center; color:#FF0000">
                                                           <button type="button" class="edit render delete-row-image"><i
                                                                   class="fa fa-trash-o"></i></button>
                                                       </td>
                                                   </tr>
                                                   @endforeach
                                               </tbody>
                                           </table>
                                       </div>
                                       <hr style="border-color: #ccc8c8; width: 100%; margin-bottom:5px"> <!-- Horizontal line -->
                                       <!-- END layout Image -->


{{-- ==================================================================================================================== --}}

{{-- ---------------------------------------------------- --}}


									<div class="col-lg-2"  style="margin-top: 35px;">
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
    {{-- to show confirmation alert message while delete --}}
    <script>
        function confirmDelete(recipeId) {
            var result = confirm('Are you sure you want to delete this Recipe?');
            if (!result) {
                event.preventDefault(); // Prevent the default action (deletion) if user clicks "Cancel"
            } else {
                window.location.href = '{{ url("recipeDestroy") }}/' + recipeId;
            }
        }
    </script>




<script>
    $(document).ready(function() {
        $(".add-row-image").click(function()  {
            // Get the input file element
            var inputElement = document.getElementById('document');

            // Check if a file is selected
            if (!inputElement.files || inputElement.files.length === 0) {
                alert('Please select an image file.');
                return;
            }

            // Use FileReader to display the selected image
            var fileReader = new FileReader();
            fileReader.onload = function(e) {
                var imageSrc = e.target.result;

                // Create a new row with the image
                var rowCount = $(".add_more_image tr").length;
var srNo=$(".new-row").length;
            srNo= parseInt(srNo)+parseInt(1);


                var markup =
                    '<tr class="new-row">' +
                        '<td style="text-align:center;">' + srNo + '</td>' +
                       '<td><input type="hidden" name="document[]" value="' + imageSrc + '"><img src="' + imageSrc + '" style="max-width: 50px; max-height: 50px;"></td>' +
                        '<td style="text-align:center; color:#FF0000"><button class="delete-row-image"><i class="fa fa-trash-o"></i></button></td>' +
                    '</tr>';

                $(".add_more_image").append(markup);
            };

            // Read the selected file as Data URL
            fileReader.readAsDataURL(inputElement.files[0]);

            // Clear the input file
            $('#document').val('');
        });

        // Find and remove selected table rows
        $("tbody").delegate(".delete-row-image", "click", function() {
            $(this).parents("tr").remove();
        });


    });



</script>


<script>
  $(document).on("click", ".delete-row-image", function() {
    var row = $(this).closest("tr");
    var imageId = row.data('image-id');

    $.ajax({
        type: 'get',
        url: "{{ url('delete-waiter-image') }}/" + imageId,
        success: function(response) {
            row.remove();
            console.log('Document deleted successfully');
        },
        error: function(error) {
            console.error('Error deleting image:', error);
        }
    });
});

</script>
    @endsection
