<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1.0"> -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="{{asset('js/jquery-3.3.1.js')}}"></script>

    <link rel="stylesheet" href="{{asset('css/bootstrap.css')}}">
    <link rel="stylesheet" href="{{asset('css/animate.css')}}">

    <script src="{{asset('js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('js/6631cf4e8b.js')}}"></script>
    <link rel="stylesheet" href="{{asset('css/sidebar1.css')}}">
    <link rel="stylesheet" href="{{asset('css/button.css')}}">
    <script type="text/javascript" src="{{asset('js/sidebar.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/Chart.min.js')}}"></script>
   
    <script type="text/javascript" src="{{asset('js/sweetalert2.all.min.js')}}"></script>

    <script src="https://uicdn.toast.com/tui.code-snippet/latest/tui-code-snippet.js"></script>
    <script src="https://uicdn.toast.com/tui-calendar/latest/tui-calendar.js"></script>
    <link rel="stylesheet" type="text/css" href="https://uicdn.toast.com/tui-calendar/latest/tui-calendar.css" />

    <!-- If you use the default popups, use this. -->
    <link rel="stylesheet" href="https://uicdn.toast.com/tui.date-picker/latest/tui-date-picker.css" />
    <link rel="stylesheet" href="https://uicdn.toast.com/tui.time-picker/latest/tui-time-picker.css" />

    <title>Taekwondo TT</title>
    <style>
        a {
            text-decoration: none !important;
        }
    </style>

</head>

<body>

    <!-- Bootstrap NavBar -->
    <nav class="navbar navbar-expand-md navbar-dark" style="background: #333;">
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <a class="navbar-brand" href="#">
            <!-- <img src="https://v4-alpha.getbootstrap.com/assets/brand/bootstrap-solid.svg" width="30" height="30" class="d-inline-block align-top" alt=""> -->
            <span class="menu-collapsed" onclick="location.href='dashboard'">
                <font style="color: #00cc00;"><b>Taekwondo</b></font>
                <font style="color: #0033ff;"><b> Management</b></font>
                <!-- <img src="imagelogo/logo1.png" height="50" width="250"> -->
            </span>
        </a>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <input type="text" name="search" style="width: 400px;" class="form-control" id="search" placeholder="Search..." onclick="getsearch()" />
                </li>
                <li class="nav-item">
                    <a class="nav-link text-light" href="#top">{{Session::get('key')}}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-light" href="{{action('coachController@detroySesion')}}">Logout</a>
                </li>
                <!-- This menu is hidden in bigger devices with d-sm-none. 
           The sidebar isn't proper for smaller screens imo, so this dropdown menu can keep all the useful sidebar itens exclusively for smaller screens  -->
                <!-- Smaller devices menu END -->
            </ul>
        </div>
    </nav><!-- NavBar END -->
    <!-- Bootstrap row -->
    <div class="row" id="body-row" style="background: #333;">
        <!-- Sidebar -->
        <div id="sidebar-container" class="sidebar-expanded d-none d-md-block" style="background: #333;">
            <!-- d-* hiddens the Sidebar in smaller devices. Its itens can be kept on the Navbar 'Menu' -->
            <!-- Bootstrap List Group -->
            <ul class="list-group">
                <!-- Separator with title -->
                <!-- <li class="list-group-item sidebar-separator-title text-muted d-flex align-items-center menu-collapsed">
                <small>MAIN MENU</small>
            </li> -->
                <!-- /END Separator -->
                <!-- Menu with submenu -->
                <a href="{{action('mainController@getDashboard')}}" class="list-group-item list-group-item-action" style="background: #333;">
                    <div class="d-flex w-100 justify-content-start align-items-center">
                        <span class="fa fa-dashboard fa-fw mr-3"></span>
                        <span class="menu-collapsed">Dashboard</span>
                    </div>
                </a>
                <!-- Submenu content -->
                <a href="{{action('clubController@getClub')}}" class="list-group-item list-group-item-action" style="background: #333;">
                    <div class="d-flex w-100 justify-content-start align-items-center">
                        <span class="fa fa-university fa-fw mr-3"></span>
                        <span class="menu-collapsed">Club</span>
                    </div>
                </a>
                <!-- Submenu content -->
                <a href="{{action('coachController@getCoach')}}" class="list-group-item list-group-item-action" style="background: #333;">
                    <div class="d-flex w-100 justify-content-start align-items-center">
                        <span class="fab fa-joomla fa-fw mr-3"></span>
                        <span class="menu-collapsed">Coach</span>
                    </div>
                </a>
                <!-- Separator with title -->
                <!-- <li class="list-group-item sidebar-separator-title text-muted d-flex align-items-center menu-collapsed">
                <small>OPTIONS</small>
            </li> -->
                <!-- /END Separator -->
                <a href="{{action('martialController@getMartial')}}" class="list-group-item list-group-item-action" style="background: #333;">
                    <div class="d-flex w-100 justify-content-start align-items-center">
                        <span class="fa fa-user fa-fw mr-3"></span>
                        <span class="menu-collapsed">Martial Artist </span>
                    </div>
                </a>
                <a href="{{action('examController@getExam')}}" class="list-group-item list-group-item-action" style="background: #333;">
                    <div class="d-flex w-100 justify-content-start align-items-center">
                        <span class="fa fa-calendar fa-fw mr-3"></span>
                        <span class="menu-collapsed">Exam</span>
                    </div>
                </a>
                <!-- Separator without title -->
                <!-- <li class="list-group-item sidebar-separator menu-collapsed"></li> -->
                <!-- /END Separator -->
                <a href="{{action('revenuesController@getRevenues')}}" class="list-group-item list-group-item-action" style="background: #333;">
                    <div class="d-flex w-100 justify-content-start align-items-center">
                        <span class="fas fa-bell fa-fw mr-3"></span>
                        <span class="menu-collapsed">Revenues</span>
                    </div>
                </a>
            </ul><!-- List Group END-->
        </div><!-- sidebar-container END -->
        <!-- MAIN -->
        <div class="col p-4" style="background-color: #000">
            <div class="container-fluid">
                @yield('detail')
            </div>
        </div><!-- Main Col END -->
    </div><!-- body-row END -->

</body>

</html>