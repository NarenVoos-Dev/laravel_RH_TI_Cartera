<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="{{ route('dashboard') }}" class="app-brand-link">
            <span class="app-brand-logo demo">
                <!-- Logo SVG omitido por brevedad -->
            </span>
            <span class="app-brand-text demo menu-text fw-bolder ms-2">NomiVoos</span>
        </a>
        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="align-middle bx bx-chevron-left bx-sm"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="py-1 menu-inner">
        <!-- Dashboard visible para todos -->
        <li class="menu-item">
            <a href="{{ route('dashboard') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-bar-chart-alt-2"></i>
                <div>Dashboard</div>
            </a>
        </li>

        <!-- Cartera (solo si tiene permiso) -->
        @can('cartera')
        <li class="menu-item">
            <a href="{{ route('cartera.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-wallet"></i>
                <div>Cartera</div>
            </a>
        </li>
        @endcan

        <!-- Nómina (admin o rrhh) -->
         @can('nomina')
        <li class="menu-item">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-credit-card"></i>
                <div>Nomina</div>
            </a>
            <ul class="menu-sub">
                @can('crear nomina')
                <li class="menu-item">
                    <a href="{{ route('payrolls.create') }}" class="menu-link">
                        <i class="bx bx-calculator"></i>
                        <div>Liquidar Nómina</div>
                    </a>
                </li>
                @endcan
                @can('ver nomina')
                <li class="menu-item">
                    <a href="{{ route('payrolls.index') }}" class="menu-link">
                        <i class="bx bx-history"></i>
                        <div>Historial de Nóminas</div>
                    </a>
                </li>
                @endcan
                @can('ver colillas')
                <li class="menu-item">
                    <a href="{{ route('desprendibles.index') }}" class="menu-link">
                        <i class="bx bx-file"></i>
                        <div>Desprendibles</div>
                    </a>
                </li>
                @endcan
                @can('ver configuracion')
                <li class="menu-item">
                    <a href="{{ route('configuration.index') }}" class="menu-link">
                        <i class="bx bx-cog"></i>
                        <div>Configuraciones</div>
                    </a>
                </li>
                @endcan
            </ul>
        </li>
        @endcan
        <!-- Contrataciones (admin o rrhh) -->
         @can('empleados')
        <li class="menu-item">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-briefcase-alt-2"></i>
                <div>Contrataciones</div>
            </a>
            <ul class="menu-sub">
                @can('gestionar empleados')
                <li class="menu-item">
                    <a href="{{ route('employees.index') }}" class="menu-link">
                        <i class="bx bx-user"></i>
                        <div>Empleados</div>
                    </a>
                </li>
                @endcan
                @can('asignar asignaciones')
                <li class="menu-item">
                    <a href="{{ route('assignments.index') }}" class="menu-link">
                        <i class="bx bx-task"></i>
                        <div>Asignaciones</div>
                    </a>
                </li>
                @endcan
            </ul>
        </li>
        @endcan

        <!-- Configuración (solo administrador) -->
         @can('configuracion')
        <li class="menu-item">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-cog"></i>
                <div>Configuración</div>
            </a>
            <ul class="menu-sub">
                @can('ver roles')
                <li class="menu-item">
                    <a href="{{ route('roles.index') }}" class="menu-link">
                        <i class="bx bx-id-card"></i>
                        <div>Roles</div>
                    </a>
                </li>
                @endcan
                @can('ver usuarios')
                <li class="menu-item">
                    <a href="{{ route('users.index') }}" class="menu-link">
                        <i class="bx bx-user-circle"></i>
                        <div>Usuarios</div>
                    </a>
                </li>
                @endcan
                @can('ver companías')
                <li class="menu-item">
                    <a href="{{ route('companies.index') }}" class="menu-link">
                        <i class="bx bx-buildings"></i>
                        <div>Compañías</div>
                    </a>
                </li>
                @endcan
            </ul>
        </li>
        @endcan
    </ul>
</aside>
