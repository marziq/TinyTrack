<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <title>TinyTrack</title>
        <meta content="width=device-width, initial-scale=1.0" name="viewport">
        <meta content="" name="keywords">
        <meta content="" name="description">

        <!-- Google Web Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@600;700&family=Montserrat:wght@200;400;600&display=swap" rel="stylesheet">

        <!-- Icon Font Stylesheet -->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"/>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

        <!-- Libraries Stylesheet -->
        <link href="lib/animate/animate.min.css" rel="stylesheet">
        <link href="lib/lightbox/css/lightbox.min.css" rel="stylesheet">
        <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

        <!-- Customized Bootstrap Stylesheet -->
        <link href="css/bootstrap.min.css" rel="stylesheet">

        <!-- Template Stylesheet -->
        <link href="css/style.css" rel="stylesheet">

        <!-- Inline script to set initial theme early to avoid flash-of-incorrect-theme -->
        <script>
            (function() {
                try {
                    var stored = localStorage.getItem('userDarkMode');
                    if (stored !== null) {
                        if (stored === 'true') document.documentElement.classList.add('dark');
                        else document.documentElement.classList.remove('dark');
                    } else if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
                        document.documentElement.classList.add('dark');
                    }
                } catch (e) { /* ignore */ }
            })();
        </script>



    </head>

    <body>

        <!-- Spinner Start -->
        <div id="spinner" class="show w-100 vh-100 bg-white position-fixed translate-middle top-50 start-50  d-flex align-items-center justify-content-center">
            <div class="spinner-grow text-primary" role="status"></div>
        </div>
        <!-- Spinner End -->


        <!-- Navbar start -->
        <div class="container-fluid border-bottom wow fadeIn" data-wow-delay="0.1s" style="background-color: white;">
            <div class="container topbar d-none d-lg-block py-2" style="border-radius: 0 40px; background: linear-gradient(to right, #c1c8e4, #c4fff9)">
                <div class="d-flex justify-content-between">
                    <div class="top-info ps-2">
                        <small class="me-3"><i class="fas fa-envelope me-2 text-secondary"></i><a href="#" style="color: black; font-weight: bold; padding: 5px;">support@tinytrack.com</a></small>
                        <small class="me-3" style="margin-left: 1px !important"><i class="fas fa-phone-alt me-2 text-secondary"></i><a href="#" style="color: black; font-weight: bold; padding: 2px;">+601-9456 7890</a></small>
                    </div>
                </div>
            </div>
            <div class="container px-0">
                <nav class="navbar navbar-light navbar-expand-xl py-3 justify-content-center">
                    <!--Put logo here-->
                    <a href="{{route('mainpage')}}" class="navbar-brand d-flex align-items-center">
                        <img src="{{ asset('img/tinytrack-logo.png') }}" alt="TinyTrack Logo" style="height: 48px; width: auto; margin-right: 10px;">
                        <h1 class="text-primary display-6 mb-0">Tiny<span class="text-secondary">Track</span></h1>
                    </a>
                    <button class="navbar-toggler py-2 px-3" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                        <span class="fa fa-bars text-primary"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarCollapse">
                        <!-- Centered main navigation -->
                        <div class="navbar-nav mx-auto">
                            <a href="{{route('mainpage')}}" class="nav-item nav-link">Home</a>
                            <a href="{{route('expert')}}" class="nav-item nav-link">Experts</a>
                            <a href="{{route('service')}}" class="nav-item nav-link">Services</a>
                            <a href="{{route('faq')}}" class="nav-item nav-link">FAQ</a>
                            <a href="{{route('contact')}}" class="nav-item nav-link">Contact</a>
                        </div>

                        <!-- Right section with login/register and account button -->
                        <div class="navbar-nav ms-auto">
                            @guest
                            <a class="nav-item nav-link" href="{{ route('login') }}">Login</a>
                            <a class="nav-item nav-link" href="{{ route('register') }}" style="margin-right: 5px;">Register</a>
                            @endguest

                            @auth
                            <div class="dropdown">
                                <button class="profile-btn dropdown-toggle d-flex align-items-center gap-2" type="button" id="accountDropdown" data-bs-toggle="dropdown" aria-expanded="false" style="background-image: none;">
                                    <div class="profile-img-container">
                                        <img src="{{ Auth::user()->profile_photo_url }}" alt="Profile" class="profile-img">
                                    </div>
                                    <i class="fas fa-chevron-down text-muted arrow-icon"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="accountDropdown">
                                    <li><a class="dropdown-item" href="{{ route('dashboard') }}"><i class="fas fa-tachometer-alt me-2"></i> Dashboard</a></li>
                                    <li><a class="dropdown-item" href="{{ route('dashboard') }}"><i class="fas fa-baby me-2"></i> My Baby</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <a class="dropdown-item text-danger" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            <i class="fas fa-sign-out-alt me-2"></i> Logout
                                        </a>
                                    </li>
                                </ul>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                            @else
                            <div class="dropdown">
                                <button class="btn btn-primary btn-md-square rounded-circle dropdown-toggle" type="button" id="accountDropdown" data-bs-toggle="dropdown" aria-expanded="false" style="background: linear-gradient(to right, #c1c8e4, #c4fff9) !important;">
                                    <i class="fas fa-user text-white"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="accountDropdown">
                                    <li><a class="dropdown-item" href="{{ route('login') }}">Login</a></li>
                                    <li><a class="dropdown-item" href="{{ route('register') }}">Register</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item text-danger" href="{{ route('admin.login.submit') }}">Login as Admin</a></li>
                                </ul>
                            </div>
                            @endauth
                        </div>
                    </div>
                </nav>
            </div>
        </div>
        <!-- Navbar End -->



       @yield('content')

        <!-- Footer Start -->

        <!-- Footer End -->


        <!-- Copyright Start -->
        <div class="container-fluid copyright bg-dark py-4">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                        <span class="text-light"><a href="#" style='color: #4D65F9 !important;'><i class="fas fa-copyright text-light me-2"></i>TinyTrack</a>, All right reserved.</span>
                    </div>
                </div>
            </div>
        </div>
        <!-- Copyright End -->


        <!-- Back to Top -->
        <a href="#" class="btn btn-primary border-3 border-primary rounded-circle back-to-top" style="background: linear-gradient(to right, #c1c8e4, #c4fff9); color: #FF4880;"><i class="fa fa-arrow-up"></i></a>


    <!-- JavaScript Libraries -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/wow/wow.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/lightbox/js/lightbox.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
    </body>

</html>
