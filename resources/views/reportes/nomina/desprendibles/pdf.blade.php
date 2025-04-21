<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
            margin: 30px;
            color: #000;
        }
        .container {
            border: 2px solid #000;
            padding: 15px;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #000;
            margin-bottom: 10px;
        }
        .header h1 {
            font-size: 16px;
            color: #004080;
        }
        .logo {
            text-align: right;
            margin-top: -40px;
        }
        .logo img {
            height: 50px;
        }
        .data-block {
            margin-top: 20px;
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            border: 1px solid #ccc;
            padding: 10px;
            background-color: #f5f7fa;
        }
        .data-block div {
            width: 48%;
            margin-bottom: 5px;
        }
        .section-title {
            background-color: #004080;
            color: white;
            padding: 5px;
            font-weight: bold;
            margin-top: 25px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 5px;
        }
        th, td {
            border: 1px solid #000;
            padding: 6px;
            font-size: 11px;
        }
        th {
            background-color: #eef3f9;
        }
        .resumen-table td {
            font-weight: bold;
            background-color: #f1f1f1;
        }
        .signature {
            margin-top: 40px;
            display: flex;
            justify-content: space-between;
        }
        .signature div {
            text-align: center;
            width: 45%;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>COMPROBANTE DE PAGO</h1>
        </div>

        <div class="data-block">
            <div><strong>Nombre:</strong> {{ $detail->employee->name }}</div>
            <div><strong>Cédula:</strong> {{ $detail->employee->document_identification }}</div>
            <div><strong>Empresa:</strong> {{ $detail->payroll->company->name }}</div>
            <div><strong>Período:</strong> {{ \Carbon\Carbon::parse($detail->payroll->start_date)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($detail->payroll->end_date)->format('d/m/Y') }}</div>
            <div><strong>Fecha de Pago:</strong> {{ \Carbon\Carbon::parse($detail->payroll->payment_date)->format('d/m/Y') }}</div>
        </div>

        <div class="section-title">DEVENGADOS</div>
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

        <div class="section-title">DEDUCCIONES</div>
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

        <div class="section-title">RESUMEN DE PAGO</div>
        <table class="resumen-table">
            <tr>
                <td>Total Devengado</td>
                <td>${{ number_format($detail->total_earnings, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td>Total Deducciones</td>
                <td>${{ number_format($detail->total_deductions, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td>Neto a Pagar</td>
                <td><strong>${{ number_format($detail->net_salary, 0, ',', '.') }}</strong></td>
            </tr>
        </table>

        <div class="signature">
            <div>
                ___________________________<br>
                Firma del Empleado
            </div>
            <div>
                ___________________________<br>
                Firma del Responsable
            </div>
        </div>
    </div>
</body>
</html>
