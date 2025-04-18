@extends('layouts.app')

@section('title','Dashboard')

@section('content')
<div class="card">
    <div class="mb-4 card-header">
        <ul class="nav nav-tabs card-header-tabs" id="dashboardTabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="accesos-tab" data-bs-toggle="tab" href="#accesos" role="tab">Accesos
                    directos</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="indicadores-tab" data-bs-toggle="tab" href="#indicadores"
                    role="tab">Indicadores</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="habilitaciones-tab" data-bs-toggle="tab" href="#habilitaciones"
                    role="tab">Habilitaciones electrónicas</a>
            </li>
        </ul>
    </div>

    <div class="card-body tab-content">
        {{-- ACCESOS DIRECTOS --}}
        <div class="tab-pane fade show active" id="accesos" role="tabpanel">
            <h5 class="mb-4">Te damos la bienvenida, ¿Qué deseas hacer?</h5>
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
                <div class="text-center col">
                    <a href="#" class="text-decoration-none text-dark">
                        <div class="mx-auto mb-2 rounded-circle bg-light d-flex justify-content-center align-items-center"
                            style="width:80px; height:80px;">
                            <i class="bx bx-file fs-2 text-primary"></i>
                        </div>
                        <p class="mb-0 fw-semibold">Crear Nómina</p>
                    </a>
                </div>

                <div class="text-center col">
                    <a href="#" class="text-decoration-none text-dark">
                        <div class="mx-auto mb-2 rounded-circle bg-light d-flex justify-content-center align-items-center"
                            style="width:80px; height:80px;">
                            <i class="bx bx-group fs-2 text-primary"></i>
                        </div>
                        <p class="mb-0 fw-semibold">Gestión de Empleados</p>
                    </a>
                </div>

                <div class="text-center col">
                    <a href="#" class="text-decoration-none text-dark">
                        <div class="mx-auto mb-2 rounded-circle bg-light d-flex justify-content-center align-items-center"
                            style="width:80px; height:80px;">
                            <i class="bx bx-wallet fs-2 text-primary"></i>
                        </div>
                        <p class="mb-0 fw-semibold">Carteras</p>
                    </a>
                </div>

                <div class="text-center col">
                    <a href="#" class="text-decoration-none text-dark">
                        <div class="mx-auto mb-2 rounded-circle bg-light d-flex justify-content-center align-items-center"
                            style="width:80px; height:80px;">
                            <i class="bx bx-user fs-2 text-primary"></i>
                        </div>
                        <p class="mb-0 fw-semibold">Mi Perfil</p>
                    </a>
                </div>
                {{-- Puedes seguir agregando más accesos aquí --}}
            </div>
        </div>

        {{-- INDICADORES --}}
        <div class="tab-pane fade" id="indicadores" role="tabpanel">
            <p class="text-muted">Aquí irán los gráficos y estadísticas más adelante.</p>
        </div>

        {{-- HABILITACIONES --}}
        <div class="tab-pane fade" id="habilitaciones" role="tabpanel">
            <p class="text-muted">Sección futura para habilitaciones electrónicas.</p>
        </div>
    </div>
</div>
@endsection