<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    @notifyCss
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

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
        <div class="header" id="header">
            <div class="header_toggle"> <i class='bx bx-menu' id="header-toggle"></i> </div>

            <div class="header_toggle">
                <h3><b> Tanga Raha Restaurant</b></h3>
            </div>

            <div class="dropdown">
                <a href="#"class="dropdown-toggle" style="text-decoration: none; color:var(--first-color)"
                    id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expsanded="false">
                    {{ Auth::user()->name }}
                </a>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                    <li><a class="dropdown-item" href="#">Action</a></li>
                    <li><a class="dropdown-item" href="#">Another action</a></li>
                    <li><a class="dropdown-item" href="#">Something else here</a></li>
                </ul>
            </div>
        </div>
        <div class="l-navbar" id="nav-bar">
            <a href="#" class="app_logo">
                <div class="header_img"><img style="background: white" src="{{ asset('images/logo.png') }}" alt="">
                </div>
            </a>
            <nav class="nav">

                <div class="nav_list overflow-auto vh-100">
                    <a href="{{ route('dashboard') }}"
                        class="nav_link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <i class='bx bx-grid-alt nav_icon'></i> <span class="nav_name">Dashboard</span>
                    </a>
                    <a href="{{ route('sales') }}" class="nav_link {{ request()->routeIs('sales') ? 'active' : '' }}">
                        <i class='bx bx-dollar nav_icon'></i> <span class="nav_name">Sales</span>
                    </a>
                    <a href="{{ route('materials') }}"
                        class="nav_link {{ request()->routeIs('materials') ? 'active' : '' }}"> <i
                            class='bx bx-layout nav_icon'></i> <span class="nav_name">Materials</span> </a>
                    <a href="{{ route('items') }}" class="nav_link {{ request()->routeIs('items') ? 'active' : '' }}">
                        <i class='bx bx-purchase-tag-alt nav_icon'></i> <span class="nav_name">Items</span> </a>
                    <a href="{{ route('products') }}"
                        class="nav_link {{ request()->routeIs('products') ? 'active' : '' }}"> <i
                            class='bx bx-cart nav_icon'></i> <span class="nav_name">Products</span>
                    </a>
                    <a href="{{ route('users') }}" class="nav_link {{ request()->routeIs('users') ? 'active' : '' }}">
                        <i class='bx bx-group nav_icon'></i> <span class="nav_name">Users</span>
                    </a>
                    <a href="{{ route('settings') }}"
                        class="nav_link {{ request()->routeIs('settings') ? 'active' : '' }}"> <i
                            class='bx bx-cog nav_icon'></i> <span class="nav_name">Settings</span>
                    </a>
                    <a href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                document.getElementById('logout-form').submit();"
                        class="nav_link"> <i class='bx bx-log-out nav_icon'></i> <span class="nav_name">Sign Out</span> </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </nav>

        </div>
    @endguest
    <br><br>

    <main class="">
        @yield('content')
    </main>

    </div>
    <x:notify-messages />

    @yield('scripts')
    @notifyJs
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
    <!-- Scripts -->
    <script src=" https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js;"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js;"></script>
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

</body>

</html>
