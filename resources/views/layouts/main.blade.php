@php
use App\Models\Modules;
use Illuminate\Support\Facades\Storage;
$controller = $getControllerName;
$action = $getActionName;
@endphp
<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    {{-- <meta name="viewport" content="width=device-width, initial-scale=1"> --}}
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="csrf-token" content="_token">

    <title>@yield('title')</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.4/css/all.min.css"
        integrity="sha256-mUZM63G8m73Mcidfrv5E+Y61y7a12O5mW4ezU3bxqW4=" crossorigin="anonymous">
    <!-- plugin css-->
    <link href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('plugins/dependent-dropdown/css/dependent-dropdown.min.css') }}" rel="stylesheet"
        type="text/css">
    <link href="{{ asset('plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css">
    @yield('pluginsCss')
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('plugins/sweetalert2/css/sweetalert2.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('plugins/summernote/summernote-bs5.css') }}" rel="stylesheet" type="text/css">
    <!-- common script-->
    <script src="{{ asset('js/jquery.js') }}" type="text/javascript"></script>

    <!-- The core Firebase JS SDK is always required and must be listed first -->
    <script src="https://www.gstatic.com/firebasejs/8.3.2/firebase-app.js"></script>
    <script src="https://www.gstatic.com/firebasejs/8.3.2/firebase-messaging.js"></script>
    <!-- TODO: Add SDKs for Firebase products that you want to use
        https://firebase.google.com/docs/web/setup#available-libraries -->

    <script>
        // Your web app's Firebase configuration
        var firebaseConfig = {
            apiKey: "AIzaSyAomfeAwSjzSqLZnq2-9lY7YpkmjrXFgkU",
            authDomain: "vandemission-98da0.firebaseapp.com",
            projectId: "vandemission-98da0",
            storageBucket: "vandemission-98da0.appspot.com",
            messagingSenderId: "655157812442",
            appId: "1:655157812442:web:611d3e66091794662ad9e3",
            measurementId: "G-NGKBM04VKN"
        };
        // Initialize Firebase
        firebase.initializeApp(firebaseConfig);

        const messaging = firebase.messaging();

        function initFirebaseMessagingRegistration() {
            messaging.requestPermission().then(function() {
                return messaging.getToken()
            }).then(function(token) {
                console.log(token);


                $.ajaxSetup({

                    headers: {

                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

                    }

                });



                $.ajax({
                    url: "{{ route('admin.dashboard.fcmToken') }}",
                    type: 'POST',
                    data: {
                        token: token
                    },
                    dataType: 'JSON',
                    success: function(response) {
                        // alert('Token saved successfully.');
                    },
                    error: function(err) {
                        console.log('User Chat Token Error' + err);
                    },
                });
                // axios.post("{{ route('admin.dashboard.fcmToken') }}", {
                //     _method: "PATCH",
                //     token
                // }).then(({
                //     data
                // }) => {
                //     console.log(data)
                // }).catch(({
                //     response: {
                //         data
                //     }
                // }) => {
                //     console.error(data)
                // })

            }).catch(function(err) {
                console.log(`Token Error :: ${err}`);
            });
        }

        initFirebaseMessagingRegistration();

        messaging.onMessage(function({
            data: {
                body,
                title
            }
        }) {
            new Notification(title, {
                body
            });
        });
    </script>

    @stack('after-styles')
</head>

<body class="hold-transition layout-fixed layout-navbar-fixed sidebar-mini-lg">
    @auth
        <!-- /.navbar -->
        <!-- Site wrapper -->
        <div class="wrapper">
            {{-- @include('layouts.loader') --}}
            <!-- Navbar -->
            <nav class="main-header navbar navbar-expand navbar-light">
                <div class="container-fluid">
                    <!-- Start navbar links -->
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" data-lte-toggle="sidebar-full" href="#" role="button"><i
                                    class="fas fa-bars"></i></a>
                        </li>
                        <li class="nav-item d-none d-md-block">
                            <a href="" class="nav-link">Home</a>
                        </li>
                    </ul>

                    <!-- End navbar links -->
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item dropdown user-menu">
                            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                <img src="https://github.com/mdo.png" class="user-image img-circle shadow" alt="User Image">
                                <span class="d-none d-md-inline">Alexander Pierce</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                                <!-- User image -->
                                <li class="user-header bg-primary">
                                    <img src="../../assets/img/user2-160x160.jpg" class="img-circle shadow"
                                        alt="User Image">
                                    <p>
                                        {{ $user->first_name . ' ' . $user->last_name }}
                                    </p>
                                </li>
                                <!-- Menu Footer-->
                                <li class="user-footer">
                                    <a href="#" class="btn btn-default btn-flat">Profile</a>
                                    <a class="btn btn-default btn-flat float-end" href="{{ route('admin.logout') }}"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="fas fa-sign-out-alt mr-2"></i> {{ __('Sign out') }}
                                    </a>
                                    <form id="logout-form" action="{{ route('admin.logout') }}" method="POST"
                                        class="d-none">
                                        @csrf
                                    </form>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Main Sidebar Container -->
            <aside class="main-sidebar sidebar-bg-dark sidebar-color-primary shadow">
                <div class="brand-container">
                    <a href="javascript:;" class="brand-link">
                        <img src="{{ url('/img/AdminLTELogo.png') }}" alt="" class="brand-image opacity-80 shadow">
                        <span class="brand-text fw-light">{{ config('app.name') }}</span>
                    </a>
                    <a class="pushmenu mx-1" data-lte-toggle="sidebar-mini" href="javascript:;" role="button"><i
                            class="fas fa-angle-double-left"></i></a>
                </div>
                <!-- Sidebar -->
                <div class="sidebar">
                    <nav class="mt-2">
                        <!-- Sidebar Menu -->
                        <?php
                        $menus = Modules::where(['type' => 'Menu', 'is_active' => '1', 'panel' => 'Backend'])
                            ->where('title', '!=', '')
                            ->orderBy('menu_position', 'asc')
                            ->get()
                            ->toArray();
                        $sideMenu = '';
                        if ($menus) {
                            foreach ($menus as $key_menu => $value_menu) {
                                $active_sidemenu = '';
                                $nav_open_sidemenu = '';

                                if ($value_menu['controller'] && $value_menu['action'] == 'index') {
                                    $url = $value_menu['controller'];
                                } elseif ($value_menu['controller'] && $value_menu['action'] != 'index') {
                                    $url = $value_menu['controller'] . '/' . $value_menu['action'];
                                } else {
                                    $url = false;
                                }
                                $childMenu = '';
                                $icon = '';
                                $submenu = Modules::where(['type' => 'Submenu', 'parent_menu_id' => $value_menu['id'], 'is_active' => '1', 'panel' => 'Backend'])
                                    ->where('title', '!=', '')
                                    ->orderBy('submenu_position', 'asc')
                                    ->get()
                                    ->toArray();
                                $totalchildMenu = [];
                                if ($submenu) {
                                    $childMenu .= '<ul class="nav nav-treeview">';
                                    foreach ($submenu as $key_submenu => $value_submenu) {
                                        if ($value_submenu['controller'] && $value_submenu['action'] == 'index') {
                                            $url_childmenu = $value_submenu['controller'];
                                        } elseif ($value_submenu['controller'] && $value_submenu['action'] != 'index') {
                                            $url_childmenu = $value_submenu['controller'] . '/' . $value_submenu['action'];
                                        } else {
                                            $url_childmenu = false;
                                        }
                                        $active_childmenu = '';
                                        if ($url_childmenu && $controller == $value_submenu['controller'] && $action == $value_submenu['action']) {
                                            $active_sidemenu = 'active';
                                            $active_childmenu = 'active';
                                            $nav_open_sidemenu = 'menu-open menu-is-open';
                                        }
                                        $iconchild = '';
                                        $childInMenu = '';
                                        $subsubmenu = Modules::where(['type' => 'Subsubmenu', 'parent_menu_id' => $value_menu['id'], 'parent_submenu_id' => $value_submenu['id'], 'is_active' => '1', 'panel' => 'Backend'])
                                            ->where('title', '!=', '')
                                            ->orderBy('submenu_position', 'asc')
                                            ->get()
                                            ->toArray();
                                        if ($subsubmenu) {
                                            $childInMenu .= '<ul class="nav nav-treeview">';
                                            foreach ($subsubmenu as $key_subsubmenu => $value_subsubmenu) {
                                                if ($value_subsubmenu['controller'] && $value_subsubmenu['action'] == 'index') {
                                                    $url_childInmenu = $value_subsubmenu['controller'];
                                                } elseif ($value_subsubmenu['controller'] && $value_subsubmenu['action'] != 'index') {
                                                    $url_childInmenu = $value_subsubmenu['controller'] . '/' . $value_subsubmenu['action'];
                                                } else {
                                                    $url_childInmenu = false;
                                                }
                                                $active_childInmenu = '';
                                                if ($url_childInmenu && $controller == $value_subsubmenu['controller'] && $action == $value_subsubmenu['action']) {
                                                    $active_sidemenu = 'active';
                                                    $active_childmenu = 'active';
                                                    $active_childInmenu = 'active';
                                                    $nav_open_sidemenu = 'menu-open menu-is-open';
                                                }
                                                if (!empty(checkaccess($value_subsubmenu['action'], $value_subsubmenu['controller']))) {
                                                    $childInMenutitle = '<i class="nav-icon ' . $value_subsubmenu['icon'] . '"></i><p>' . $value_subsubmenu['title'] . '</p>';
                                                    $url_childInmenu = $url_childmenu ? url('/admin') . '/' . $url_childInmenu : 'javascript:;';
                                                    $childInMenu .= '<li class="nav-item"><a href="' . $url_childInmenu . '" class="nav-link ' . $active_childInmenu . '">' . $childInMenutitle . '</a></li>';
                                                }
                                            }
                                        }
                                        if (!empty(checkaccess($value_submenu['action'], $value_submenu['controller']))) {
                                            $childMenutitle = '<i class="nav-icon ' . $value_submenu['icon'] . '"></i><p>' . $value_submenu['title'] . $iconchild . '</p>';
                                            $url_childmenu = $url_childmenu ? url('/admin') . '/' . $url_childmenu : 'javascript:;';
                                            $childMenu .= '<li class="nav-item"><a href="' . $url_childmenu . '" class="nav-link ' . $active_childmenu . '">' . $childMenutitle . '</a>' . $childInMenu . '</li>';
                                            $totalchildMenu[] = true;
                                        }
                                    }
                                    $childMenu .= '</ul>';
                                    $icon .= '<i class="end fas fa-angle-right"></i>';
                                } else {
                                    if ($url && $controller == $value_menu['controller'] && $action == $value_menu['action']) {
                                        $active_sidemenu = 'active';
                                        $nav_open_sidemenu = 'menu-open menu-is-open';
                                    }
                                }
                                if (!empty(checkaccess($value_menu['action'], $value_menu['controller']))) {
                                    $sideMenutitle = '<i class="nav-icon ' . $value_menu['icon'] . '"></i><p>' . $value_menu['title'] . $icon . '</p>';
                                    $url = $url ? url('/admin') . '/' . $url : 'javascript:;';
                                    $sideMenu .= '<li class="nav-item ' . $nav_open_sidemenu . '"><a href="' . $url . '" class="nav-link ' . $active_sidemenu . '">' . $sideMenutitle . '</a>' . $childMenu . '</li>';
                                } else {
                                    if ($totalchildMenu || $value_menu['controller'] == 'dashboard') {
                                        $sideMenutitle = '<i class="nav-icon ' . $value_menu['icon'] . '"></i><p>' . $value_menu['title'] . $icon . '</p>';
                                        $url = $url ? url('/admin') . '/' . $url : 'javascript:;';
                                        $sideMenu .= '<li class="nav-item ' . $nav_open_sidemenu . '"><a href="' . $url . '" class="nav-link ' . $active_sidemenu . '">' . $sideMenutitle . '</a>' . $childMenu . '</li>';
                                    }
                                }
                            }
                        }
                        ?>
                        <ul class="nav nav-pills nav-sidebar flex-column" data-lte-toggle="treeview" role="menu"
                            data-accordion="false">
                            {!! $sideMenu !!}
                        </ul>
                    </nav>
                </div>
                <!-- /.sidebar -->
            </aside>

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                @yield('breadcrumb')
                <!-- Main content -->
                <section class="content">
                    <div class="container-fluid">
                        @yield('content')
                    </div>
                </section>
                <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->

        </div>
        @yield('modal')
        {{-- @include('grid_view::modal.container') --}}
        <!-- ./wrapper -->
        @stack('before-scripts')
        <!-- common js -->
        <script src="{{ asset('js/app.js') }}" defer></script>
        <script src="{{ asset('js/jquery.form.min.js') }}" defer></script>
        <script src="{{ asset('js/adminlte.min.js') }}" type="text/javascript"></script>
        <!-- plugin js -->
        <script type="text/javascript" src="{{ asset('plugins/jsvalidation/jsvalidation.js') }}"></script>
        <script src="{{ asset('plugins/dependent-dropdown/js/dependent-dropdown.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('plugins/jquery-pjax/jquery.pjax.js') }}" type="text/javascript"></script>
        <script src="{{ asset('plugins/sweetalert2/js/sweetalert2.all.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('plugins/inputmask/jquery.inputmask.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('plugins/handlebars/handlebars.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('plugins/summernote/summernote-bs5.min.js') }}" type="text/javascript"></script>
        @yield('pluginsJs')
        <!-- script js -->
        <script src="{{ asset('js/cloneData.js') }}" type="text/javascript"></script>
        <script src="{{ asset('js/grid.js') }}" type="text/javascript"></script>
        <script src="{{ asset('js/sweetalert2.js') }}" type="text/javascript"></script>
        {{-- <script src="{{ asset('js/demo.js') }}" type="text/javascript"></script> --}}
        <script src="{{ asset('js/myfunction.js') }}" type="text/javascript"></script>
        @stack('after-scripts')
        @yield('pagescript')
    @endauth
    <script>
        const SELECTOR_SIDEBAR = '.sidebar'
        const Default = {
            scrollbarTheme: 'os-theme-light',
            scrollbarAutoHide: 'leave'
        }
        document.addEventListener("DOMContentLoaded", function() {
            if (typeof OverlayScrollbars !== 'undefined') {
                OverlayScrollbars(document.querySelectorAll(SELECTOR_SIDEBAR), {
                    className: Default.scrollbarTheme,
                    sizeAutoCapable: true,
                    scrollbars: {
                        autoHide: Default.scrollbarAutoHide,
                        clickScrolling: true
                    }
                })
            }
        })
    </script>
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $(document).ready(function() {
            $(":input").inputmask();
            // Inputmask().mask(document.querySelectorAll("input"));
        });
    </script>

    @stack('grid_js')
</body>

</html>
