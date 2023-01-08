<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title> @yield('title') | {{ 'Morning Sky General' }}</title>
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('images/water.png') }}">

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.0/css/responsive.bootstrap5.min.css">


    @notifyCss
    @yield('style')
    <style>
        .notify {
            padding-top: 70px;
        }
    </style>
</head>

<body id="body-pd">
    @guest
        <div></div>
    @else
        <div class="header shadow" id="header">
            <div class="header_toggle"> <i class='bx bx-menu' id="header-toggle"></i> </div>

            <div class="header_toggle ">
                <h3
                    style="text-shadow: 0.5px 0.5px white;font-family:Verdana, Geneva, Tahoma, sans-serif;color:var(--first-color)">
                    <b> TANGA WATER COM</b>
                    {{-- <b>{{setting('App Name')}}</b> --}}
                </h3>
            </div>
            <div class="dropdown prof">
                <a href="#"class="dropdowsn-toggle" style="text-decoration: none; color:var(--first-color)"
                    id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bx bx-user"></i>
                </a>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                    <li>
                        <div class="text-center"><i class="bx bx-user bx-md bx-white"
                                style="width: 40px; height: 40px;color:white;border-radius: 50%; overflow: hidden;background: var(--first-color)"></i>
                        </div><a class="dropdown-item" href="#">{{ Auth::user()->name }}</a>
                    </li>
                    <li><a class="dropdown-item" href="#">Profile</a></li>
                    <li><a class="dropdown-item" href="{{ route('watercom.settings.index') }}">Settings</a></li>
                    <li><a class="dropdown-item" href="{{ route('watercom.logs.index') }}">Activity Logs</a></li>
                    <hr>
                    <li>
                        <a href="#"
                            onclick="event.preventDefault();if(confirm('Are you sure want to logout ?'))
                document.getElementById('logout-form').submit();"
                            class="text-danger dropdown-item">
                            Logout
                        </a>
                        <form id="logout-form" action="{{ route('watercom.logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>
                </ul>
            </div>
        </div>
        <div class="l-navbar" id="nav-bar">
            <a href="#" class="app_logo">
                <div class="header_img"><img style="background: white" src="{{ asset('images/water.png') }}" alt="">
                </div>
            </a>
            <nav class="nav">
                <div class="nav_list overflow-auto vh-100">
                    <a href="{{ route('watercom.index') }}"
                        class="nav_link {{ request()->routeIs('watercom.index') ? 'active' : '' }}">
                        <i class='bx bx-grid-alt nav_icon'></i> <span class="nav_name">Dashboard</span>
                    </a>
                    <a href="{{ route('watercom.stocks.index') }}"
                        class="nav_link {{ request()->routeIs('watercom.stocks.index') || request()->routeIs('watercom.stocks.show') ? 'active' : '' }}">
                        <i class='bx bx-layout nav_icon'></i> <span class="nav_name">Stocks</span> </a>
                    {{-- <a href="{{ route('watercom.items.index') }}"
                        class="nav_link {{ request()->routeIs('watercom.items.index') || request()->routeIs('watercom.items.show') ? 'active' : '' }}">
                        <i class='bx bx-purchase-tag-alt nav_icon'></i> <span class="nav_name">Items</span> </a> --}}
                    <a href="{{ route('watercom.products.index') }}"
                        class="nav_link {{ request()->routeIs('watercom.products.index') || request()->routeIs('watercom.products.show') ? 'active' : '' }}">
                        <i class='fa fa-product-hunt fa-lg nav_icon'></i> <span class="nav_name">Products</span>
                    </a>
                    <a href="{{ route('watercom.sales.index') }}"
                        class="nav_link {{ request()->routeIs('watercom.sales.index') ? 'active' : '' }}">
                        <i class='bx bx-cart nav_icon'></i> <span class="nav_name">Sales</span>
                    </a>
                    <a href="{{ route('watercoms.index') }}"
                        class="nav_link {{ request()->routeIs('watercoms.index') || request()->routeIs('watercoms.show') ? 'active' : '' }}">
                        <i class='bx bx-group nav_icon'></i> <span class="nav_name">Users</span>
                    </a>
                    <a href="{{ route('watercom.roles.index') }}"
                        class="nav_link {{ request()->routeIs('watercom.roles.index') || request()->routeIs('watercom.roles.show') ? 'active' : '' }}">
                        <i class='bx bx-registered nav_icon'></i> <span class="nav_name">Roles</span>
                    </a>
                    <a href="{{ route('watercom.reports.index') }}"
                        class="nav_link {{ request()->routeIs('watercom.reports.index') ? 'active' : '' }}"> <i
                            class='bx bx-book nav_icon'></i> <span class="nav_name">Reports</span>
                    </a>

                </div>
            </nav>

        </div>
        <br><br>
    @endguest

    <main class="pt-5">
        @yield('content')
    </main>

    </div>
    <x:notify-messages />
    @yield('scripts')
    @notifyJs
    <script src="https://use.fontawesome.com/3076bdb328.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.4.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.4.0/js/responsive.bootstrap5.min.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function(event) {
            const showNavbar = (toggleId, navId, bodyId, headerId) => {
                const toggle = document.getElementById(toggleId),
                    nav = document.getElementById(navId),
                    bodypd = document.getElementById(bodyId),
                    headerpd = document.getElementById(headerId)
                // Validate that all variables exist
                if (toggle && nav && bodypd && headerpd) {
                    toggle.addEventListener('click', () => {
                        // show navbar
                        nav.classList.toggle('show')
                        // change icon
                        toggle.classList.toggle('bx-x')
                        // add padding to body
                        bodypd.classList.toggle('body-pd')
                        // add padding to header
                        headerpd.classList.toggle('body-pd')
                    })
                }
            }
            showNavbar('header-toggle', 'nav-bar', 'body-pd', 'header')
            /*===== LINK ACTIVE =====*/
            const linkColor = document.querySelectorAll('.nav_link')

            function colorLink() {
                if (linkColor) {
                    linkColor.forEach(l => l.classList.remove('active'))
                    this.classList.add('active')
                }
            }
            linkColor.forEach(l => l.addEventListener('click', colorLink))

            // Your code to run since DOM is loaded and ready
        });
    </script>
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js;"></script>
    <script src=" https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js;"></script> --}}
    <script>
        $(document).ready(function() {
            $(document).on('submit', 'form', function() {
                $('button').attr('disabled', 'disabled');
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#data-tebo1').DataTable();
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#data-tebo2').DataTable();
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function() {

            $(".add-more").click(function() {
                var html = $(".copy").html();
                $(".after-add-more").after(html);
            });

            $("body").on("click", ".remove", function() {
                $(this).parents(".control-group").remove();
            });

        });
    </script>
    <script>
        $(function() {
            $('[data-toggle="tooltip"]').tooltip()
        })
    </script>
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

</body>

</html>
