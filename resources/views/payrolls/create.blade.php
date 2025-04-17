@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Crear Nómina</h2>

    <form action="{{ route('payrolls.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="company_id" class="form-label">Empresa</label>
            <select name="company_id" id="company_id" class="form-control" required>
                <option value="">Seleccione una empresa</option>
                @foreach ($companies as $company)
                    <option value="{{ $company->id }}">{{ $company->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="start_date" class="form-label">Fecha de inicio</label>
            <input type="date" name="start_date" id="start_date" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="end_date" class="form-label">Fecha de fin</label>
            <input type="date" name="end_date" id="end_date" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="payment_date" class="form-label">Fecha de pago</label>
            <input type="date" name="payment_date" id="payment_date" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Generar nómina</button>
        <a href="{{ route('payrolls.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
