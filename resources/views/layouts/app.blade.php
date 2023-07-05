<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ config('app.name') }}</title>
    {{-- <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" /> --}}
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css"
          integrity="sha512-1PKOgIY59xJ8Co8+NE6FZ+LOAZKjy+KY8iq0G4B3CyeY6wYHN3yt9PW0XpSriVlkMXe40PTKnXrLnZ9+fkDaog=="
          crossorigin="anonymous"/> --}}

    <link rel="icon" type="image/png" href="{{asset('/img/gmis-single-logo.png')}}" sizes="32x32" />
    <link rel="icon" type="image/png" href="{{asset('/img/gmis-single-logo.png')}}" sizes="16x16" />
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('/css/styles.css') }}">

    @yield('third_party_stylesheets')

    @stack('page_css')
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="page-loader-wrapper" id="page-loader-wrapper" style="display: none;">
        <div id="loader"></div>
    </div>
    <div class="wrapper">
        <!-- Main Header -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light bg-gmis-navbar">
            <!-- Left navbar links -->.
            <div class="container-fluid">
                <div class="col-md-4">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link text-white" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                        </li>
                        {{-- <li class="nav-item d-none d-sm-inline-block">
                            <a href="/dashboard" class="nav-link font-weight-bold text-white">Cleaning APP - Partner Dashboard</a>
                        </li> --}}
                    </ul>
                </div>
                <div class="col-md-4">
                    <ul class="navbar-nav nav-tablet">
                        <li class="nav-item d-none d-sm-inline-block">
                            <a href="/dashboard" class="nav-link logo-link-tablet">
                                <img src="{{asset('/img/gmis-logo.png')}}" alt="GMIS" class="brand-image logo-tablet">
                            </a>                        
                        </li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <ul class="navbar-nav" style="justify-content:flex-end;">
                        <li class="nav-item dropdown user-menu">
                            <a href="#" class="nav-link dropdown-toggle text-white" data-toggle="dropdown">
                                <img src="{{(($partner_image[0]->user_profile_image) == 'img_avatar.png' ? asset('/img/img_avatar.png') : env('DO_SPACES_CDN_ENDPOINT')."/cleaningapp-profile-images/".$partner_image[0]->user_profile_image)}}" class="user-image img-circle elevation-2" alt="User Image">
                                <span class="d-none d-md-inline">{{ Auth::user()->name }}</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                                <!-- User image -->
                                <li class="user-header bg-gmis-userheader text-white">
                                    <img src={{asset('/img/img_avatar.png')}}
                                        class="img-circle elevation-2"
                                        alt="User Image">
                                    <p>
                                        {{ Auth::user()->name }}
                                        <small>Member since {{ Auth::user()->created_at->format('M. Y') }}</small>
                                    </p>
                                </li>
                                <!-- Menu Footer-->
                                <li class="user-footer">
                                    <a href="{{ route('profile') }}" class="btn btn-default btn-flat">Profile</a>
                                    <a href="#" class="btn btn-default btn-flat float-right"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        Sign out
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
            
        </nav>

    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar sidebar-light-info elevation-4">
        {{-- <a href="{{ route('dashboard') }}" class="brand-link"> --}}
        <a href="/dashboard" class="brand-link bg-gmis-navbar text-white">
            <img src="{{asset('/img/gmis-single-logo.png')}}" alt="GMIS" class="brand-image">
            <span class="brand-text font-weight-bold">GMIS</span>
            {{-- <span class="brand-text font-weight-bold">{{ config('app.name') }}</span> --}}
        </a>
        
        @include('layouts.sidebar')
    </aside>

    <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        {{-- <div class="col-sm-6">
                            <h1 class="m-0">{{ ucwords(Route::currentRouteName()) }}</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#" style="color:#0000FF;">Home</a></li>
                                <li class="breadcrumb-item active">{{ ucwords(Route::currentRouteName()) }}</li>
                            </ol>
                        </div> --}}
                    </div>
            </section>
            
            <!-- Content Body. (Main Content) -->
            @yield('content')
        </div>



        <!-- Main Footer -->
        <footer class="main-footer">
            <div class="float-right d-none d-sm-block">
                <b>Version</b> 0.0.7
            </div>
            <strong>Copyright &copy; 2023 <a href="https://gmiscdo.com" class="text-success">GMIS</a>.</strong> All rights
            reserved.
        </footer>
    </div>

    <script src="{{ mix('js/app.js') }}" defer></script>

    @yield('third_party_scripts')

    @stack('page_scripts')
</body>
</html>
