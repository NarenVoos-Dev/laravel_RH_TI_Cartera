<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="../assets/"
    data-template="vertical-menu-template-free">

<head>
    @include('partials.head')
</head>

<body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <!-- Menu -->
            @include('partials.menu')
            <!-- Fin Menu -->
            <div class="layout-page">
                @include('partials.header')

                <!--Contenido de pagina -->
                <div class="container-wrapper">
                    <div class="container-xxl flex-grow-1 container-p-y">
                        @yield('content')
                    </div>
                    <div class="content-backdrop fade"></div>
                </div>
            </div>
             <!-- Header -->
        </div>

        @include('partials.overlay')
    </div>

    @include ('partials.loading')
    <!-- / Layout wrapper -->
    @include('partials.js')
    @stack('scripts')
</body>

</html>