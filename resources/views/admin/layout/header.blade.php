

<!doctype html>
<html lang="en">

<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">


    {{-- csrf token for pie charts --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">


	<!--favicon-->
	<link rel="icon" href="{{asset('admin/assets/images/favicon-32x32.png')}}" type="image/png" />
	<!--plugins-->
	<link href="{{asset('admin/assets/plugins/simplebar/css/simplebar.css')}}" rel="stylesheet" />
	<link href="{{asset('admin/assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css')}}" rel="stylesheet" />
	<link href="{{asset('admin/assets/plugins/metismenu/css/metisMenu.min.css')}}" rel="stylesheet" />
	<link href="{{asset('admin/assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet" />
	<link href="{{asset('admin/assets/plugins/select2/css/select2-bootstrap4.css')}}" rel="stylesheet" />
	<link href="{{asset('admin/assets/plugins/datatable/css/dataTables.bootstrap5.min.css')}}" rel="stylesheet" />

	<!-- loader-->
	<link href="{{asset('admin/assets/css/pace.min.css')}}" rel="stylesheet" />
	<script src="{{asset('admin/assets/js/pace.min.js')}}"></script>
	<script src="https://kit.fontawesome.com/yourcode.js')}}" crossorigin="anonymous"></script>
	<!-- Bootstrap CSS -->
	<link href="{{asset('admin/assets/css/bootstrap.min.css')}}" rel="stylesheet">
	<link href="{{asset('admin/assets/css/bootstrap-extended.css')}}" rel="stylesheet">
	<link href="{{asset('admin/assets/css/app.css')}}" rel="stylesheet">
	<link href="{{asset('admin/assets/css/icons.css')}}" rel="stylesheet">
	<!-- Theme Style CSS -->
	<link rel="stylesheet" href="{{asset('admin/assets/css/dark-theme.css')}}" />
	<link rel="stylesheet" href="{{asset('admin/assets/css/semi-dark.css')}}" />
	<link rel="stylesheet" href="{{asset('admin/assets/css/header-colors.css')}}" />
	<link rel="stylesheet" href="{{asset('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css')}}">

    {{-- datatables --}}
    <link rel="stylesheet" href="{{asset('https://cdn.datatables.net/2.0.8/css/dataTables.dataTables.css')}}" />
<link rel="stylesheet" href="{{asset('https://cdn.datatables.net/buttons/3.0.2/css/buttons.dataTables.css')}}" />"


{{-- To show search bar in select drop down --}}
{{-- <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> --}}


{{--  --}}

{{--  --}}
{{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script> --}}

    <title>Zhep Food</title>

    {{-- <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script> --}}



{{-- to show piecharts on dashboard --}}
<!-- Add this to your HTML file -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>



</head>

<style>
    /* Define styles for the dynamically added rows */
    .add_more_image tr td {
        padding: 5px;
        border: 1px solid #ddd; /* Add border to table cells */
    }

    .add_more_image tr td img {
        max-width: 100px;
        max-height: 100px;
    }

    .add_more_image tr td button {
        background-color: white;
        color: red;
        border: 1px solid red; /* Add border to the button */
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
					<img src="{{asset('admin/assets/images/Zhepp.png')}}" class="logo-icon" alt="logo icon"
						style="width: 30%; background-color: black;">
				</div>
				<div class="toggle-icon ms-auto"><i class='bx bx-arrow-to-left'></i>
				</div>
			</div>
			<!--navigation-->
			<ul class="metismenu" id="menu">
				<li>
					<a href="{{route('adminDashboard')}}" style="border-bottom: 1px solid red">
						<div class="parent-icon"><i class='bx bx-home-circle'></i>
						</div>
						<div class="menu-title">Dashboard</div>
					</a>

				</li>

                <li>
                    <a href="{{ route('showProfile', ['id' => $restro->id]) }}">
                   						<div class="parent-icon"><i class='bx bx-user'></i>
						</div>
						<div class="menu-title">Profile</div>
					</a>
                </li>

                <li>
                    <a href="{{ route('add-logo') }}">
                                           <div><i class="fa fa-cutlery" aria-hidden="true"></i>

                        </div>
                        <div class="menu-title">Add Logo</div>
                    </a>
                </li>

                <li>
                    <a href="{{ route('all-orders') }}">
                   						<div><i class="fa fa-cutlery" aria-hidden="true"></i>

						</div>
						<div class="menu-title">Bill</div>
					</a>
                </li>

				{{-- <li> --}}
					{{-- <a href="javascript:;" class="has-arrow">
						<div class="parent-icon"><i class="bx bx-category"></i>
						</div>
						<div class="menu-title">Master</div>
					</a> --}}


					{{-- <ul> --}}

                        <li>
                            <a href="{{ route('add_recipe') }}">
                                                   <div><i class="fa fa-cutlery" aria-hidden="true"></i>

                                </div>
                                <div class="menu-title">Add Recipe</div>
                            </a>
                        </li>



                        <li>
                            <a href="{{ route('leave_date') }}">
                                                   <div><i class="fa fa-clock-o" aria-hidden="true"></i>

                                </div>
                                <div class="menu-title">Leave Management</div>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('kitchen') }}">
                                                   <div><i class="fa fa-cutlery" aria-hidden="true"></i>

                                </div>
                                <div class="menu-title">Kitchen / Chef Registration</div>
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('area') }}">
                                                   <div><i class="fa fa-location-arrow" aria-hidden="true"></i>

                                </div>
                                <div class="menu-title">Add Area</div>
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('table') }}">
                                                   <div><i class="fa fa-table" aria-hidden="true"></i>

                                </div>
                                <div class="menu-title">Table Registration</div>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('waiter_view') }}">
                                                   <div><i class="fa fa-user" aria-hidden="true"></i>

                                </div>
                                <div class="menu-title">Waiter Registration</div>
                            </a>
                        </li>
                        {{-- <li> <a href="{{route('waiter_view')}}"><i class="fa fa-user" aria-hidden="true" style="margin-right: 10px"></i>
                            Waiter Registration</a>
						</li> --}}

						{{-- <li> <a href="{{route('delivery_slots_timing')}}"><i class="bx bx-right-arrow-alt"></i>Delivery Slots & Time</a>
						</li> --}}
{{--
					</ul>
				</li> --}}

                <li>
                    <a href="{{ route('logout') }}">
                                           <div><i class="fa fa-sign-out" aria-hidden="true"></i>

                        </div>
                        <div class="menu-title">Logout</div>
                    </a>
                </li>
                {{-- <li> <a href="{{route('logout')}}" ><i class="fa fa-sign-out" aria-hidden="true" style="margin-right: 10px"></i>
                      Logout</a>
                </li> --}}
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
													<img src="{{asset('admin/assets/images/avatars/avatar-1.png')}}" class="msg-avatar"
														alt="user avatar">
                                                        <div>
                                                            Welcome, {{ Auth::user()->email ?? null }}
                                                        </div>
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
													<img src="{{asset('admin/assets/images/avatars/avatar-2.png')}}" class="msg-avatar"
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
													<img src="{{asset('admin/assets/images/avatars/avatar-3.png')}}" class="msg-avatar"
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
													<img src="{{asset('admin/assets/images/avatars/avatar-4.png')}}" class="msg-avatar"
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
													<img src="{{asset('admin/assets/images/avatars/avatar-5.png')}}" class="msg-avatar"
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
													<img src="{{asset('admin/assets/images/avatars/avatar-6.png')}}" class="msg-avatar"
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
													<img src="{{asset('admin/assets/images/avatars/avatar-7.png')}}" class="msg-avatar"
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
													<img src="{{asset('admin/assets/images/avatars/avatar-8.png')}}" class="msg-avatar"
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
													<img src="{{asset('admin/assets/images/avatars/avatar-9.png')}}" class="msg-avatar"
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
													<img src="{{asset('admin/assets/images/avatars/avatar-10.png')}}" class="msg-avatar"
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
													<img src="{{asset('admin/assets/images/avatars/avatar-11.png')}}" class="msg-avatar"
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
						{{-- <a class="d-flex align-items-center nav-link dropdown-toggle dropdown-toggle-nocaret" href="#"
							role="button" data-bs-toggle="dropdown" aria-expanded="false">
							<img src="{{asset('admin/assets/images/profile.png" class="user-img')}}" alt="user avatar">
						</a> --}}
						<div class="user-info ps-3">
							<p class="user-name mb-0">

                                <div class="user-info ps-3">
                                    <p class="user-name mb-0">
                                        {{-- Debugging statement --}}
                                        {{-- {{ dd(auth()->user()) }} --}}

                                        {{-- Display restaurant name or 'Admin' --}}
                                        {{-- {{ auth()->user()->restaurant ?? 'Admin' }} --}}
                                    {{-- </p>
                                </div> --}}

                                {{-- {{ auth()->user()->restaurant ?? 'Admin' }} --}}
                                {{-- Admin --}}
                                <div style="margin-top: 15px">
                                    Welcome, {{ Auth::user()->email ?? null }}
                                </div>

                            </p>
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
                            <li>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                                <a class="dropdown-item" href="javascript:;" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class='bx bx-log-out-circle'></i><span>Logout</span>
                                </a>
                            </li>
						</ul>
					</div>
				</nav>
			</div>
		</header>


		<!--end header -->


        @yield('main-container')



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
	<script src="{{asset('admin/assets/js/bootstrap.bundle.min.js')}}"></script>
	<!--plugins-->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
	{{-- <script src="{{asset('admin/assets/js/jquery.min.js')}}"></script> --}}
	<script src="{{asset('admin/assets/plugins/simplebar/js/simplebar.min.js')}}"></script>
	<script src="{{asset('admin/assets/plugins/metismenu/js/metisMenu.min.js')}}"></script>
	<script src="{{asset('admin/assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js')}}"></script>
	<script src="{{asset('admin/assets/plugins/select2/js/select2.min.js')}}"></script>
	<script src="{{asset('admin/assets/js/form-select2.js')}}"></script>
	<script src="{{asset('admin/assets/plugins/datatable/js/jquery.dataTables.min.js')}}"></script>
	<script src="{{asset('admin/assets/plugins/datatable/js/dataTables.bootstrap5.min.js')}}"></script>
	<script src="{{asset('admin/assets/js/table-datatable.js')}}"></script>
	<!--app JS-->
	<script src="{{asset('admin/assets/js/app.js')}}"></script>
	<script src="https://cdn.datatables.net/fixedcolumns/4.2.2/js/dataTables.fixedColumns.min.js')}}"> </script>
	<script>
        $(document).ready(function () {
            var table = $('#example').DataTable({
                scrollCollapse: true,
                paging: true,
                fixedColumns: {
                    leftColumns: 0,
                    right: 1
                }
            });
        });
    </script>


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

@yield('js')
</body>


</html>
