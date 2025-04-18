<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 5px; text-align: left; }
        h2, h4 { margin: 0; }
    </style>
</head>
<body>
    <h2>Colilla de Pago</h2>
    <h4>Empleado: {{ $detail->employee->name }}</h4>
    <h4>Empresa: {{ $detail->payroll->company->name }}</h4>
    <h4>Cédula: {{ $detail->employee->document_identification }}</h4>
    <h4>Período: {{ \Carbon\Carbon::parse($detail->payroll->start_date)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($detail->payroll->end_date)->format('d/m/Y') }}</h4>

    <h4 style="margin-top: 20px;">Devengados</h4>
    <table>
        <thead>
            <tr>
                <th>Concepto</th>
                <th>Valor</th>
            </tr>
        </thead>
        <tbody>
            @foreach($detail->items->where('type', 'earning') as $item)
            <tr>
                <td>{{ $item->description }}</td>
                <td>${{ number_format($item->amount, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <h4 style="margin-top: 20px;">Deducciones</h4>
    <table>
        <thead>
            <tr>
                <th>Concepto</th>
                <th>Valor</th>
            </tr>
        </thead>
        <tbody>
            @foreach($detail->items->where('type', 'deduction') as $item)
            <tr>
                <td>{{ $item->description }}</td>
                <td>${{ number_format($item->amount, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <h4 style="margin-top: 20px;">Resumen</h4>
    <table>
        <tr>
            <td><strong>Total Devengado</strong></td>
            <td>${{ number_format($detail->total_earnings, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td><strong>Total Deducciones</strong></td>
            <td>${{ number_format($detail->total_deductions, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td><strong>Neto a Pagar</strong></td>
            <td><strong>${{ number_format($detail->net_salary, 0, ',', '.') }}</strong></td>
        </tr>
    </table>
</body>
</html>
