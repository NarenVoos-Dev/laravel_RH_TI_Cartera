@extends('layouts.app')

@section('content')

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Configuración de la aplicación</h5>
    </div>
    <div class="card-body">
        <div class="list-group">
            <a href="{{ route('earnings.index') }}" class="list-group-item list-group-item-action">
                ➕ Conceptos Devengados
            </a>
            <a href="{{ route('deductions.index') }}" class="list-group-item list-group-item-action">
                ➖ Conceptos de Deducción
            </a>
            {{-- Aquí podrías agregar más enlaces como: cargos, tipos de contrato, periodicidades, etc. --}}
        </div>
    </div>
</div>
@endsection