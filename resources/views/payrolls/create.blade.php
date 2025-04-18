@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Crear Nueva Nómina</h5>
        <a href="{{ route('payrolls.index') }}" class="btn btn-secondary">
            <i class="bx bx-arrow-back"></i> Volver
        </a>
    </div>
</div>

<div class="p-4 mt-4 card">
    <form action="{{ route('payrolls.store') }}" method="POST" class="show-loader">
        @csrf

        <div class="row g-3">
            <div class="col-md-6">
                <label for="company_id" class="form-label">Empresa</label>
                <select name="company_id" id="company_id" class="form-select" required>
                    <option value="">Seleccione una empresa</option>
                    @foreach ($companies as $company)
                        <option value="{{ $company->id }}">{{ $company->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-6">
                <label for="payment_date" class="form-label">Fecha de pago</label>
                <input type="date" name="payment_date" id="payment_date" class="form-control" required>
            </div>

            <div class="col-md-6">
                <label for="start_date" class="form-label">Fecha de inicio</label>
                <input type="date" name="start_date" id="start_date" class="form-control" required>
            </div>

            <div class="col-md-6">
                <label for="end_date" class="form-label">Fecha de fin</label>
                <input type="date" name="end_date" id="end_date" class="form-control" required>
            </div>
        </div>

        <div class="gap-2 mt-4 d-flex justify-content-end">
            <button type="submit" class="btn btn-primary">
                <i class="bx bx-play-circle"></i> Generar nómina
            </button>
            <a href="{{ route('payrolls.index') }}" class="btn btn-outline-secondary">
                <i class="bx bx-x"></i> Cancelar
            </a>
        </div>
    </form>
</div>
@endsection
