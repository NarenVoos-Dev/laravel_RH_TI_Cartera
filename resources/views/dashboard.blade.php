@extends('layouts.app')

@section('title','Intranet-Corp / Dashboard')

@section('content')
<div class="card">
    <div class="mb-4 card-header">
        <ul class="nav nav-tabs card-header-tabs" id="dashboardTabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="accesos-tab" data-bs-toggle="tab" href="#accesos" role="tab">Accesos directos</a>
            </li>
            @can('ver indicadores')
            <li class="nav-item">
                <a class="nav-link" id="indicadores-tab" data-bs-toggle="tab" href="#indicadores" role="tab">Indicadores</a>
            </li>
            @endcan
        </ul>
    </div>

    <div class="card-body tab-content">
        {{-- ACCESOS DIRECTOS --}}
        <div class="tab-pane fade show active" id="accesos" role="tabpanel">
            <h5 class="mb-4">Te damos la bienvenida, ¿Qué deseas hacer?</h5>
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">

                @can('crear nomina')
                <div class="text-center col">
                    <a href="{{ route('payrolls.create') }}" class="text-decoration-none text-dark">
                        <div class="mx-auto mb-2 rounded-circle bg-light d-flex justify-content-center align-items-center" style="width:80px; height:80px;">
                            <i class="bx bx-file fs-2 text-primary"></i>
                        </div>
                        <p class="mb-0 fw-semibold">Crear Nómina</p>
                    </a>
                </div>
                @endcan

                @can('gestionar empleados')
                <div class="text-center col">
                    <a href="{{ route('employees.index') }}" class="text-decoration-none text-dark">
                        <div class="mx-auto mb-2 rounded-circle bg-light d-flex justify-content-center align-items-center" style="width:80px; height:80px;">
                            <i class="bx bx-group fs-2 text-primary"></i>
                        </div>
                        <p class="mb-0 fw-semibold">Gestión de Empleados</p>
                    </a>
                </div>
                @endcan

                @can('cartera')
                <div class="text-center col">
                    <a href="{{ route('cartera.index') }}" class="text-decoration-none text-dark">
                        <div class="mx-auto mb-2 rounded-circle bg-light d-flex justify-content-center align-items-center" style="width:80px; height:80px;">
                            <i class="bx bx-wallet fs-2 text-primary"></i>
                        </div>
                        <p class="mb-0 fw-semibold">Carteras</p>
                    </a>
                </div>
                @endcan

                @can('ver colillas')
                <div class="text-center col">
                    <a href="{{ route('desprendibles.index') }}" class="text-decoration-none text-dark">
                        <div class="mx-auto mb-2 rounded-circle bg-light d-flex justify-content-center align-items-center" style="width:80px; height:80px;">
                            <i class="bx bx-file fs-2 text-primary"></i>
                        </div>
                        <p class="mb-0 fw-semibold">Mis Desprendibles</p>
                    </a>
                </div>
                @endcan

                {{-- Puedes seguir agregando más accesos según permisos --}}
                @can('ver roles')
                <div class="text-center col">
                    <a href="{{ route('roles.index') }}" class="text-decoration-none text-dark">
                        <div class="mx-auto mb-2 rounded-circle bg-light d-flex justify-content-center align-items-center" style="width:80px; height:80px;">
                            <i class="bx bx-id-card fs-2 text-primary"></i>
                        </div>
                        <p class="mb-0 fw-semibold">Roles</p>
                    </a>
                </div>
                @endcan

                @can('ver usuarios')
                <div class="text-center col">
                    <a href="{{ route('users.index') }}" class="text-decoration-none text-dark">
                        <div class="mx-auto mb-2 rounded-circle bg-light d-flex justify-content-center align-items-center" style="width:80px; height:80px;">
                            <i class="bx bx-user-circle fs-2 text-primary"></i>
                        </div>
                        <p class="mb-0 fw-semibold">Usuarios</p>
                    </a>
                </div>
                @endcan

                @can('ver companías')
                <div class="text-center col">
                    <a href="{{ route('companies.index') }}" class="text-decoration-none text-dark">
                        <div class="mx-auto mb-2 rounded-circle bg-light d-flex justify-content-center align-items-center" style="width:80px; height:80px;">
                            <i class="bx bx-buildings fs-2 text-primary"></i>
                        </div>
                        <p class="mb-0 fw-semibold">Compañías</p>
                    </a>
                </div>
                @endcan

                <div class="text-center col">
                    <a href="#" class="text-decoration-none text-dark">
                        <div class="mx-auto mb-2 rounded-circle bg-light d-flex justify-content-center align-items-center" style="width:80px; height:80px;">
                            <i class="bx bx-user fs-2 text-primary"></i>
                        </div>
                        <p class="mb-0 fw-semibold">Mi Perfil</p>
                    </a>
                </div>

            </div>
        </div>

        {{-- INDICADORES --}}
        @can('ver indicadores')
        <div class="tab-pane fade" id="indicadores" role="tabpanel">
            <p class="text-muted">Aquí irán los gráficos y estadísticas más adelante.</p>
        </div>
        @endcan

    </div>
</div>
@endsection
