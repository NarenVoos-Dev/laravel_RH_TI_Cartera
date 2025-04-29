<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="Software de Nomina & Tecnologia - Naren Voos" />
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="author" content="Naren Voos" />
<title>@yield('title','Sistema de Nomina & TI')</title>

<!-- Favicon -->
<link rel="icon" type="image/x-icon" href="../assets/img/favicon/favicon.ico" />

<!-- Fonts -->
<link rel="preconnect" href="https://fonts.googleapis.com" />
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
<link
    href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
    rel="stylesheet" />

<!-- Icons. Uncomment required icon fonts -->
<link rel="stylesheet" href="{{ asset('assets/vendor/fonts/boxicons.css') }}" />
<!--bootstrap -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

<!-- Core CSS -->
<link rel="stylesheet" href="{{ asset('assets/vendor/css/core.css') }}" class="template-customizer-core-css" />
<link rel="stylesheet" href="{{ asset('assets/vendor/css/theme-default.css') }}" class="template-customizer-theme-css" />
<link rel="stylesheet" href="{{ asset('assets/css/demo.css') }}" />

<!-- Vendors CSS -->
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/apex-charts/apex-charts.css') }}" />

<!-- Page CSS -->

<!-- Helpers -->
<script src="{{ asset('assets/vendor/js/helpers.js') }}"></script>

<script src="{{ asset('assets/js/config.js') }}"></script>


<!-- SweetAlert2 CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<!-- Datatables -->
<link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.dataTables.css" />
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">

<!-- CSS de Select2 -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet">

<style>
    @media (forced-colors: active) {
        body {
            background-color: black;
            color: white;
        }
    }
</style>

