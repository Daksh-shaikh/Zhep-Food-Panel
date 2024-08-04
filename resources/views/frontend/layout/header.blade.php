<!doctype html>
<html lang="en">

<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

{{-- csrf token for pie charts --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">



	<!--favicon-->
	<link rel="icon" href="{{asset('frontend/images/favicon-32x32.png')}}" type="image/png" />

    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap2-toggle.min.css" rel="stylesheet">
	<!--plugins-->
	<link href="{{asset('frontend/plugins/simplebar/css/simplebar.css')}}" rel="stylesheet" />
	<link href="{{asset('frontend/plugins/perfect-scrollbar/css/perfect-scrollbar.css')}}" rel="stylesheet" />
	<link href="{{asset('frontend/plugins/metismenu/css/metisMenu.min.css')}}" rel="stylesheet" />
	<link href="{{asset('frontend/plugins/select2/css/select2.min.css')}}" rel="stylesheet" />
	<link href="{{asset('frontend/plugins/select2/css/select2-bootstrap4.css')}}" rel="stylesheet" />
	<link href="{{asset('frontend/plugins/datatable/css/dataTables.bootstrap5.min.css')}}" rel="stylesheet" />


    {{-- to include font awesome library --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha384-ZfMgqEkPrDUnR0Dq4z5cu8pVoOTsuV62jUogkP+61GwATQPOJj8qzDL+xssXbxVF" crossorigin="anonymous">



	<!-- Bootstrap CSS -->
	<link href="{{asset('frontend/css/bootstrap.min.css')}}" rel="stylesheet">
	<link href="{{asset('frontend/css/bootstrap-extended.css')}}" rel="stylesheet">
	<link href="{{asset('frontend/css/app.css')}}" rel="stylesheet">
	<link href="{{asset('frontend/css/icons.css')}}" rel="stylesheet">
	<!-- Theme Style CSS -->
	<link rel="stylesheet" href="{{asset('frontend/css/dark-theme.css')}}" />
	<link rel="stylesheet" href="{{asset('frontend/css/semi-dark.css')}}" />
	<link rel="stylesheet" href="{{asset('frontend/css/header-colors.css')}}" />
	<link rel="stylesheet" href="{{asset('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css')}}">

    <!-- loader-->
	<link href="{{asset('frontend/css/pace.min.css')}}" rel="stylesheet" />
	<script src="{{asset('frontend/js/pace.min.js')}}"></script>
    <script src="https://kit.fontawesome.com/6762e5b36e.js" crossorigin="anonymous"></script>


{{-- jQuery for  restaurant as per city--}}
    {{-- <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script> --}}
{{-- toggle --}}
    <!-- Bootstrap Toggle CSS -->

<!-- Bootstrap Toggle JS -->
<script src="https://gitcdn.link/repo/gitbrent/bootstrap4-toggle/v3.6.1/dist/js/bootstrap4-toggle.min.js"></script>

{{-- to show piecharts on dashboard --}}
<!-- Add this to your HTML file -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


<!-- Add this in the <head> section of your HTML to include Bootstrap Toggle Switch styles -->
    {{-- <link href="path/to/bootstrap4-toggle.min.css" rel="stylesheet"> --}}

        <!-- Your script containing toggleTimeFields function -->
        {{-- <script>
            function toggleTimeFields(dayId) {
                console.log("Toggling time fields for day ID: " + dayId);

                var checkbox = $('#is_close_' + dayId);

                // Assuming you have corresponding elements with these IDs
                var openCloseFields = $('#open_at_' + dayId);
                var closeAtFields = $('#close_at_' + dayId);

                if (checkbox.prop('checked')) {
                    console.log("Checkbox is checked");
                    openCloseFields.hide();
                    closeAtFields.hide();
                } else {
                    console.log("Checkbox is not checked");
                    openCloseFields.show();
                    closeAtFields.show();
                }
            }
        </script>
 --}}


 {{-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> --}}



	<title>Zhep Food</title>

    {{-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"> --}}

    {{-- to hide days when checkbox is checked --}}

        <!-- jQuery library -->



        {{--script for active and deactive toggle  --}}

</head>

<style>
    /* Style for the toggle switch */
    .toggle-container {
        display: inline-block;
        position: relative;
        width: 40px;
        height: 18px;
    }

    .toggle-input {
        display: none;
    }

    .toggle-slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        -webkit-transition: .4s;
        transition: .4s;
        border-radius: 34px;
    }

    .toggle-slider:before {
        position: absolute;
        content: "";
        height: 15px;
        width: 15px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        -webkit-transition: .4s;
        transition: .4s;
        border-radius: 50%;
    }

    .toggle-input:checked + .toggle-slider {
        background-color: #4CAF50;
    }

    .toggle-input:focus + .toggle-slider {
        box-shadow: 0 0 1px #4CAF50;
    }

    .toggle-input:checked + .toggle-slider:before {
        -webkit-transform: translateX(26px);
        -ms-transform: translateX(26px);
        transform: translateX(26px);
    }
</style>

<style>
    /* Define styles for the dynamically added rows */
    .add_more_image tr td {
        padding: 5px;
        border: 1px solid #ddd; /* Add border */

    }

    .add_more_image tr td img {
        max-width: 100px;
        max-height: 100px;
    }

    .add_more_image tr td button {
        background-color: white;
        color: red;
        border: 1px solid red;
        padding: 5px 10px;
        cursor: pointer;
    }
</style>

<body>
	<!--wrapper-->
	<div class="wrapper">
		<!--sidebar wrapper -->
		<div class="sidebar-wrapper" data-simplebar="true" style="background-color: rgb(29, 29, 59);">
			<div class="sidebar-header" style="background-color: black;">
				<div>
					<img src="{{asset('frontend/images/Zhepp.png')}}" class="logo-icon" alt="logo icon"
						style="width: 30%; background-color: black;">
				</div>
				<div class="toggle-icon ms-auto"><i class='bx bx-arrow-to-left'></i>
				</div>
			</div>
			<!--navigation-->
			<ul class="metismenu" id="menu">
				<li>
					<a href="{{route('dashboard')}}">
						<div class="parent-icon"><i class='bx bx-home-circle'></i>
						</div>
						<div class="menu-title">Dashboard</div>
					</a>

				</li>

				<li>
					<a href="javascript:;" class="has-arrow">
						<div class="parent-icon"><i class="bx bx-category"></i>
						</div>
						<div class="menu-title">Master</div>
					</a>
					<ul>
						<li> <a href="{{route('city')}}"><i class="bx bx-right-arrow-alt"></i>City</a>
						</li>
						<li> <a href="{{route('bannerIndex')}}"><i class="bx bx-right-arrow-alt"></i>Banner</a>
						</li>
						<li> <a href="{{route('categoryIndex')}}"><i class="bx bx-right-arrow-alt"></i>Category</a>
						</li>

						{{-- <li> <a href="{{route('gstIndex')}}"><i class="bx bx-right-arrow-alt"></i>GST</a>
						</li> --}}


					</ul>
				</li>

				<li>
					<a href="{{route('restroIndex')}}">
						<div class="parent-icon"><i class="fa fa-cutlery" aria-hidden="true"></i>
						</div>
						<div class="menu-title">Restaurant</div>
					</a>

				</li>

                <li>
					<a href="{{route('menuIndex')}}">
						<div class="parent-icon"><i class="fa fa-user" aria-hidden="true"></i>
						</div>
						<div class="menu-title">Add Menu</div>
					</a>

				</li>



				<li>
					<a href="{{route('couponIndex')}}">
						<div class="parent-icon"><i class='bx bx-file'></i>
						</div>
						<div class="menu-title">Coupon</div>
					</a>

				</li>

                <li>
					<a href="{{route('notification-index')}}">
						<div class="parent-icon"><i class='bx bx-file'></i>
						</div>
						<div class="menu-title">Notification</div>
					</a>

				</li>


                <li>
					<a href="{{route('delivery_boy')}}">
						<div class="parent-icon"><i class="fa fa-cutlery" aria-hidden="true"></i>
						</div>
						<div class="menu-title">Delivery Boy</div>
					</a>

				</li>


                <li>
					<a href="{{route('logout')}}">
						<div class="parent-icon"><i class="fa fa-sign-out" aria-hidden="true"></i>

						</div>
						<div class="menu-title">Logout</div>
					</a>

				</li>

			</ul>
			<!--end navigation-->
		</div>
		<!--end sidebar wrapper -->
		<!--start header -->
		<header>
			<div class="topbar d-flex align-items-center">
				<nav class="navbar navbar-expand">
					<div class="mobile-toggle-menu"><i class='bx bx-menu'></i>
					</div>
					<div class="search-bar flex-grow-1">
						<!-- burber -->
						<!-- <i class="fa fa-burger"></i> -->
					</div>

					<div class="top-menu ms-auto">
						<ul class="navbar-nav align-items-center">
							<li class="nav-item mobile-search-icon">
								<a class="nav-link" href="#"><i class='bx bx-search'></i>
								</a>
							</li>
							<li class="nav-item dropdown dropdown-large">

								<div class="dropdown-menu dropdown-menu-end">
									<div class="row row-cols-3 g-3 p-3">
										<div class="col text-center">
											<div class="app-box mx-auto bg-gradient-cosmic text-white"><i
													class='bx bx-group'></i>
											</div>
											<div class="app-title">Teams</div>
										</div>
										<div class="col text-center">
											<div class="app-box mx-auto bg-gradient-burning text-white"><i
													class='bx bx-atom'></i>
											</div>
											<div class="app-title">Projects</div>
										</div>
										<div class="col text-center">
											<div class="app-box mx-auto bg-gradient-lush text-white"><i
													class='bx bx-shield'></i>
											</div>
											<div class="app-title">Tasks</div>
										</div>
										<div class="col text-center">
											<div class="app-box mx-auto bg-gradient-kyoto text-dark"><i
													class='bx bx-notification'></i>
											</div>
											<div class="app-title">Feeds</div>
										</div>
										<div class="col text-center">
											<div class="app-box mx-auto bg-gradient-blues text-dark"><i
													class='bx bx-file'></i>
											</div>
											<div class="app-title">Files</div>
										</div>
										<div class="col text-center">
											<div class="app-box mx-auto bg-gradient-moonlit text-white"><i
													class='bx bx-filter-alt'></i>
											</div>
											<div class="app-title">Alerts</div>
										</div>
									</div>
								</div>
							</li>
							<li class="nav-item dropdown dropdown-large">

								<div class="dropdown-menu dropdown-menu-end">
									<a href="javascript:;">
										<div class="msg-header">
											<p class="msg-header-title">Notifications</p>
											<p class="msg-header-clear ms-auto">Marks all as read</p>
										</div>
									</a>
									<div class="header-notifications-list">
										<a class="dropdown-item" href="javascript:;">
											<div class="d-flex align-items-center">
												<div class="notify bg-light-primary text-primary"><i
														class="bx bx-group"></i>
												</div>
												<div class="flex-grow-1">
													<h6 class="msg-name">New Customers<span
															class="msg-time float-end">14 Sec
															ago</span></h6>
													<p class="msg-info">5 new user registered</p>
												</div>
											</div>
										</a>
										<a class="dropdown-item" href="javascript:;">
											<div class="d-flex align-items-center">
												<div class="notify bg-light-danger text-danger"><i
														class="bx bx-cart-alt"></i>
												</div>
												<div class="flex-grow-1">
													<h6 class="msg-name">New Orders <span class="msg-time float-end">2
															min
															ago</span></h6>
													<p class="msg-info">You have recived new orders</p>
												</div>
											</div>
										</a>
										<a class="dropdown-item" href="javascript:;">
											<div class="d-flex align-items-center">
												<div class="notify bg-light-success text-success"><i
														class="bx bx-file"></i>
												</div>
												<div class="flex-grow-1">
													<h6 class="msg-name">24 PDF File<span class="msg-time float-end">19
															min
															ago</span></h6>
													<p class="msg-info">The pdf files generated</p>
												</div>
											</div>
										</a>
										<a class="dropdown-item" href="javascript:;">
											<div class="d-flex align-items-center">
												<div class="notify bg-light-warning text-warning"><i
														class="bx bx-send"></i>
												</div>
												<div class="flex-grow-1">
													<h6 class="msg-name">Time Response <span
															class="msg-time float-end">28 min
															ago</span></h6>
													<p class="msg-info">5.1 min avarage time response</p>
												</div>
											</div>
										</a>
										<a class="dropdown-item" href="javascript:;">
											<div class="d-flex align-items-center">
												<div class="notify bg-light-info text-info"><i
														class="bx bx-home-circle"></i>
												</div>
												<div class="flex-grow-1">
													<h6 class="msg-name">New Product Approved <span
															class="msg-time float-end">2 hrs ago</span></h6>
													<p class="msg-info">Your new product has approved</p>
												</div>
											</div>
										</a>
										<a class="dropdown-item" href="javascript:;">
											<div class="d-flex align-items-center">
												<div class="notify bg-light-danger text-danger"><i
														class="bx bx-message-detail"></i>
												</div>
												<div class="flex-grow-1">
													<h6 class="msg-name">New Comments <span class="msg-time float-end">4
															hrs
															ago</span></h6>
													<p class="msg-info">New customer comments recived</p>
												</div>
											</div>
										</a>
										<a class="dropdown-item" href="javascript:;">
											<div class="d-flex align-items-center">
												<div class="notify bg-light-success text-success"><i
														class='bx bx-check-square'></i>
												</div>
												<div class="flex-grow-1">
													<h6 class="msg-name">Your item is shipped <span
															class="msg-time float-end">5 hrs
															ago</span></h6>
													<p class="msg-info">Successfully shipped your item</p>
												</div>
											</div>
										</a>
										<a class="dropdown-item" href="javascript:;">
											<div class="d-flex align-items-center">
												<div class="notify bg-light-primary text-primary"><i
														class='bx bx-user-pin'></i>
												</div>
												<div class="flex-grow-1">
													<h6 class="msg-name">New 24 authors<span
															class="msg-time float-end">1 day
															ago</span></h6>
													<p class="msg-info">24 new authors joined last week</p>
												</div>
											</div>
										</a>
										<a class="dropdown-item" href="javascript:;">
											<div class="d-flex align-items-center">
												<div class="notify bg-light-warning text-warning"><i
														class='bx bx-door-open'></i>
												</div>
												<div class="flex-grow-1">
													<h6 class="msg-name">Defense Alerts <span
															class="msg-time float-end">2 weeks
															ago</span></h6>
													<p class="msg-info">45% less alerts last 4 weeks</p>
												</div>
											</div>
										</a>
									</div>
									<a href="javascript:;">
										<div class="text-center msg-footer">View All Notifications</div>
									</a>
								</div>
							</li>
							<li class="nav-item dropdown dropdown-large">

								<div class="dropdown-menu dropdown-menu-end">
									<a href="javascript:;">
										<div class="msg-header">
											<p class="msg-header-title">Messages</p>
											<p class="msg-header-clear ms-auto">Marks all as read</p>
										</div>
									</a>
									<div class="header-message-list">
										<a class="dropdown-item" href="javascript:;">
											<div class="d-flex align-items-center">
												<div class="user-online">
													<img src="{{asset('frontend/images/avatars/avatar-1.png')}}" class="msg-avatar"
														alt="user avatar">
												</div>
												<div class="flex-grow-1">
													<h6 class="msg-name">Daisy Anderson <span
															class="msg-time float-end">5 sec
															ago</span></h6>
													<p class="msg-info">The standard chunk of lorem</p>
												</div>
											</div>
										</a>
										<a class="dropdown-item" href="javascript:;">
											<div class="d-flex align-items-center">
												<div class="user-online">
													<img src="{{asset('frontend/images/avatars/avatar-2.png')}}" class="msg-avatar"
														alt="user avatar">
												</div>
												<div class="flex-grow-1">
													<h6 class="msg-name">Althea Cabardo <span
															class="msg-time float-end">14
															sec ago</span></h6>
													<p class="msg-info">Many desktop publishing packages</p>
												</div>
											</div>
										</a>
										<a class="dropdown-item" href="javascript:;">
											<div class="d-flex align-items-center">
												<div class="user-online">
													<img src="{{asset('frontend/images/avatars/avatar-3.png')}}" class="msg-avatar"
														alt="user avatar">
												</div>
												<div class="flex-grow-1">
													<h6 class="msg-name">Oscar Garner <span class="msg-time float-end">8
															min
															ago</span></h6>
													<p class="msg-info">Various versions have evolved over</p>
												</div>
											</div>
										</a>
										<a class="dropdown-item" href="javascript:;">
											<div class="d-flex align-items-center">
												<div class="user-online">
													<img src="{{asset('frontend/images/avatars/avatar-4.png')}}" class="msg-avatar"
														alt="user avatar">
												</div>
												<div class="flex-grow-1">
													<h6 class="msg-name">Katherine Pechon <span
															class="msg-time float-end">15
															min ago</span></h6>
													<p class="msg-info">Making this the first true generator</p>
												</div>
											</div>
										</a>
										<a class="dropdown-item" href="javascript:;">
											<div class="d-flex align-items-center">
												<div class="user-online">
													<img src="{{asset('frontend/images/avatars/avatar-5.png')}}" class="msg-avatar"
														alt="user avatar">
												</div>
												<div class="flex-grow-1">
													<h6 class="msg-name">Amelia Doe <span class="msg-time float-end">22
															min
															ago</span></h6>
													<p class="msg-info">Duis aute irure dolor in reprehenderit</p>
												</div>
											</div>
										</a>
										<a class="dropdown-item" href="javascript:;">
											<div class="d-flex align-items-center">
												<div class="user-online">
													<img src="{{asset('frontend/images/avatars/avatar-6.png')}}" class="msg-avatar"
														alt="user avatar">
												</div>
												<div class="flex-grow-1">
													<h6 class="msg-name">Cristina Jhons <span
															class="msg-time float-end">2 hrs
															ago</span></h6>
													<p class="msg-info">The passage is attributed to an unknown</p>
												</div>
											</div>
										</a>
										<a class="dropdown-item" href="javascript:;">
											<div class="d-flex align-items-center">
												<div class="user-online">
													<img src="{{asset('frontend/images/avatars/avatar-7.png')}}" class="msg-avatar"
														alt="user avatar">
												</div>
												<div class="flex-grow-1">
													<h6 class="msg-name">James Caviness <span
															class="msg-time float-end">4 hrs
															ago</span></h6>
													<p class="msg-info">The point of using Lorem</p>
												</div>
											</div>
										</a>
										<a class="dropdown-item" href="javascript:;">
											<div class="d-flex align-items-center">
												<div class="user-online">
													<img src="{{asset('frontend/images/avatars/avatar-8.png')}}" class="msg-avatar"
														alt="user avatar">
												</div>
												<div class="flex-grow-1">
													<h6 class="msg-name">Peter Costanzo <span
															class="msg-time float-end">6 hrs
															ago</span></h6>
													<p class="msg-info">It was popularised in the 1960s</p>
												</div>
											</div>
										</a>
										<a class="dropdown-item" href="javascript:;">
											<div class="d-flex align-items-center">
												<div class="user-online">
													<img src="{{asset('frontend/images/avatars/avatar-9.png')}}" class="msg-avatar"
														alt="user avatar">
												</div>
												<div class="flex-grow-1">
													<h6 class="msg-name">David Buckley <span
															class="msg-time float-end">2 hrs
															ago</span></h6>
													<p class="msg-info">Various versions have evolved over</p>
												</div>
											</div>
										</a>
										<a class="dropdown-item" href="javascript:;">
											<div class="d-flex align-items-center">
												<div class="user-online">
													<img src="{{asset('frontend/images/avatars/avatar-10.png')}}" class="msg-avatar"
														alt="user avatar">
												</div>
												<div class="flex-grow-1">
													<h6 class="msg-name">Thomas Wheeler <span
															class="msg-time float-end">2 days
															ago</span></h6>
													<p class="msg-info">If you are going to use a passage</p>
												</div>
											</div>
										</a>
										<a class="dropdown-item" href="javascript:;">
											<div class="d-flex align-items-center">
												<div class="user-online">
													<img src="{{asset('frontend/images/avatars/avatar-11.png')}}" class="msg-avatar"
														alt="user avatar">
												</div>

												<div class="flex-grow-1">
													<h6 class="msg-name">Johnny Seitz <span class="msg-time float-end">5
															days
															ago</span></h6>
													<p class="msg-info">All the Lorem Ipsum generators</p>
												</div>
											</div>
										</a>
									</div>
									<a href="javascript:;">
										<div class="text-center msg-footer">View All Messages</div>
									</a>
								</div>
							</li>
						</ul>
					</div>
					<div class="user-box dropdown">
						<a class="d-flex align-items-center nav-link dropdown-toggle dropdown-toggle-nocaret" href="#"
							role="button" data-bs-toggle="dropdown" aria-expanded="false">
							<img src="{{asset('frontend/images/profile.png')}}" class="user-img" alt="user avatar">
						</a>
						<div class="user-info ps-3">
                            <p class="user-name mb-0">Admin</p>
                            <div>
                                Welcome, {{ Auth::user()->email ?? null }}
                            </div>
                        </div>


						<ul class="dropdown-menu dropdown-menu-end">
							<li><a class="dropdown-item" href="javascript:;"><i
										class="bx bx-user"></i><span>Profile</span></a>
							</li>
							<li><a class="dropdown-item" href="javascript:;"><i
										class="bx bx-cog"></i><span>Settings</span></a>
							</li>
							<li><a class="dropdown-item" href="javascript:;"><i
										class='bx bx-home-circle'></i><span>Dashboard</span></a>
							</li>
							<li><a class="dropdown-item" href="javascript:;"><i
										class='bx bx-dollar-circle'></i><span>Earnings</span></a>
							</li>
							<li><a class="dropdown-item" href="javascript:;"><i
										class='bx bx-download'></i><span>Downloads</span></a>
							</li>
							<li>
								<div class="dropdown-divider mb-0"></div>
							</li>
							{{-- <li><a class="dropdown-item" href="javascript:;"><i
										class='bx bx-log-out-circle'></i><span>Logout</span></a>
							</li> --}}
                            <li>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf

                                <a class="dropdown-item" href="javascript:;" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class='bx bx-log-out-circle'></i><span>Logout</span>
                                </a>
                            </form>
                            </li>
						</ul>
					</div>
				</nav>
			</div>
		</header>


        @yield('main-container')






		<!--end page wrapper -->
		<!--start overlay-->
		<div class="overlay toggle-icon"></div>
		<!--end overlay-->
		<!--Start Back To Top Button--> <a href="javaScript:;" class="back-to-top"><i
				class='bx bxs-up-arrow-alt'></i></a>
		<!--End Back To Top Button-->
		<footer class="page-footer">
			<p class="mb-0"> © 2023 ZHEP FOOD</p>
		</footer>
	</div>
	<!--end wrapper-->
	<!--start switcher-->
	<div class="switcher-wrapper">
		<!-- <div class="switcher-btn"> <i class='bx bx-cog bx-spin'></i>
		</div> -->

	</div>
	<!--end switcher-->
	<!-- Bootstrap JS -->
	<script src="{{asset('frontend/js/bootstrap.bundle.min.js')}}"></script>
	<!--plugins-->
	{{-- <script src="{{asset('frontend/js/jquery.min.js')}}"></script> --}}
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
	<script src="{{asset('frontend/plugins/simplebar/js/simplebar.min.js')}}"></script>
	<script src="{{asset('frontend/plugins/metismenu/js/metisMenu.min.js')}}"></script>
	<script src="{{asset('frontend/plugins/perfect-scrollbar/js/perfect-scrollbar.js')}}"></script>
	<script src="{{asset('frontend/plugins/select2/js/select2.min.js')}}"></script>
	<script src="{{asset('frontend/js/form-select2.js')}}"></script>
	<script src="{{asset('frontend/plugins/datatable/js/jquery.dataTables.min.js')}}"></script>
	<script src="{{asset('frontend/plugins/datatable/js/dataTables.bootstrap5.min.js')}}"></script>
	<script src="{{asset('frontend/js/table-datatable.js')}}"></script>
	<!--app JS-->
	<script src="{{asset('frontend/js/app.js')}}"></script>




<!-- Add this before the closing </body> tag to include Bootstrap Toggle Switch JavaScript -->
{{-- <script src="path/to/bootstrap4-toggle.min.js"></script> --}}

<!-- jQuery library -->
{{-- <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script> --}}


@yield('js')

</body>


</html>

