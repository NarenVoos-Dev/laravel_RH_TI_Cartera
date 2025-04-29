@extends('layouts.app')

@section('title','Intranet-Corp / Dashboard')

@section('content')
<div class="card">
    <div class="mb-4 card-header">
        <ul class="nav nav-tabs card-header-tabs" id="dashboardTabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="accesos-tab" data-bs-toggle="tab" href="#accesos" role="tab">Accesos
                    directos</a>
            </li>
            @can('ver indicadores')
            <li class="nav-item">
                <a class="nav-link" id="indicadores-tab" data-bs-toggle="tab" href="#indicadores"
                    role="tab">Indicadores</a>
            </li>
            @endcan
        </ul>
    </div>

    <div class="card-body tab-content">
        {{-- ACCESOS DIRECTOS --}}
        <div class="tab-pane fade show active" id="accesos" role="tabpanel">
            <h5 class="mb-4">Te damos la bienvenida, ¿Qué deseas hacer?</h5>
            <div class="row g-4">

                @can('crear nomina')
                <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                    <div class="text-center shadow-sm card rounded-4 h-100">
                        <div class="card-body d-flex flex-column justify-content-between">
                            <div class="mb-3">
                                <i class="bx bx-file fs-1 text-primary"></i>
                                <h6 class="mt-3 fw-semibold">Crear Nómina</h6>
                            </div>
                            <a href="{{ route('payrolls.create') }}"
                                class="mt-auto btn btn-primary rounded-pill">Ingresar</a>
                        </div>
                    </div>
                </div>
                @endcan

                @can('gestionar empleados')
                <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                    <div class="text-center shadow-sm card rounded-4 h-100">
                        <div class="card-body d-flex flex-column justify-content-between">
                            <div class="mb-3">
                                <i class="bx bx-group fs-1 text-primary"></i>
                                <h6 class="mt-3 fw-semibold">Gestión de Empleados</h6>
                            </div>
                            <a href="{{ route('employees.index') }}"
                                class="mt-auto btn btn-primary rounded-pill">Ingresar</a>
                        </div>
                    </div>
                </div>
                @endcan

                @can('cartera')
                <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                    <div class="text-center shadow-sm card rounded-4 h-100">
                        <div class="card-body d-flex flex-column justify-content-between">
                            <div class="mb-3">
                                <i class="bx bx-wallet fs-1 text-primary"></i>
                                <h6 class="mt-3 fw-semibold">Carteras</h6>
                            </div>
                            <a href="{{ route('cartera.index') }}"
                                class="mt-auto btn btn-primary rounded-pill">Ingresar</a>
                        </div>
                    </div>
                </div>
                @endcan

                @can('ver colillas')
                <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                    <div class="text-center shadow-sm card rounded-4 h-100">
                        <div class="card-body d-flex flex-column justify-content-between">
                            <div class="mb-3">
                                <i class="bx bx-file fs-1 text-primary"></i>
                                <h6 class="mt-3 fw-semibold">Mis Desprendibles</h6>
                            </div>
                            <a href="{{ route('desprendibles.index') }}"
                                class="mt-auto btn btn-primary rounded-pill">Ingresar</a>
                        </div>
                    </div>
                </div>
                @endcan

                @can('ver roles')
                <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                    <div class="text-center shadow-sm card rounded-4 h-100">
                        <div class="card-body d-flex flex-column justify-content-between">
                            <div class="mb-3">
                                <i class="bx bx-id-card fs-1 text-primary"></i>
                                <h6 class="mt-3 fw-semibold">Roles</h6>
                            </div>
                            <a href="{{ route('roles.index') }}"
                                class="mt-auto btn btn-primary rounded-pill">Ingresar</a>
                        </div>
                    </div>
                </div>
                @endcan

                @can('ver usuarios')
                <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                    <div class="text-center shadow-sm card rounded-4 h-100">
                        <div class="card-body d-flex flex-column justify-content-between">
                            <div class="mb-3">
                                <i class="bx bx-user-circle fs-1 text-primary"></i>
                                <h6 class="mt-3 fw-semibold">Usuarios</h6>
                            </div>
                            <a href="{{ route('users.index') }}"
                                class="mt-auto btn btn-primary rounded-pill">Ingresar</a>
                        </div>
                    </div>
                </div>
                @endcan

                @can('ver companías')
                <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                    <div class="text-center shadow-sm card rounded-4 h-100">
                        <div class="card-body d-flex flex-column justify-content-between">
                            <div class="mb-3">
                                <i class="bx bx-buildings fs-1 text-primary"></i>
                                <h6 class="mt-3 fw-semibold">Compañías</h6>
                            </div>
                            <a href="{{ route('companies.index') }}"
                                class="mt-auto btn btn-primary rounded-pill">Ingresar</a>
                        </div>
                    </div>
                </div>
                @endcan

                <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                    <div class="text-center shadow-sm card rounded-4 h-100">
                        <div class="card-body d-flex flex-column justify-content-between">
                            <div class="mb-3">
                                <i class="bx bx-user fs-1 text-primary"></i>
                                <h6 class="mt-3 fw-semibold">Mi Perfil</h6>
                            </div>
                            <a href="#" class="mt-auto btn btn-primary rounded-pill">Ingresar</a>
                        </div>
                    </div>
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