<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Reporte de Movimientos</title>
    <style>
    body {
        font-family: sans-serif;
        font-size: 12px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    th,
    td {
        padding: 6px;
        border: 1px solid #ccc;
        text-align: left;
    }

    th {
        background-color: #f2f2f2;
    }
    </style>
</head>

<body>
    <h3>Reporte de Movimientos</h3>
    <table style="border-collapse: collapse; width: 100%;">
        <thead>
            <tr>
                <th style="border: 1px solid #000; padding: 6px; background-color: #f2f2f2;">#</th>
                <th style="border: 1px solid #000; padding: 6px; background-color: #f2f2f2;">Empleado</th>
                <th style="border: 1px solid #000; padding: 6px; background-color: #f2f2f2;">Compañía</th>
                <th style="border: 1px solid #000; padding: 6px; background-color: #f2f2f2;">Valor</th>
                <th style="border: 1px solid #000; padding: 6px; background-color: #f2f2f2;">Fecha</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($movimientos as $index => $mov)
            <tr style="background-color: {{ $index % 2 == 0 ? '#ffffff' : '#f9f9f9' }};">
                <td style="border: 1px solid #000; padding: 6px; text-align: center;">{{ $index + 1 }}</td>
                <td style="border: 1px solid #000; padding: 6px;">{{ $mov->wallet->employee->name ?? 'No asignado' }}
                </td>
                <td style="border: 1px solid #000; padding: 6px;">{{ $mov->wallet->company->name ?? 'No asignado' }}
                </td>
                <td style="border: 1px solid #000; padding: 6px; text-align: right;">
                    ${{ number_format($mov->amount, 0, ',', '.') }}</td>
                <td style="border: 1px solid #000; padding: 6px; text-align: center;">
                    {{ $mov->created_at->format('Y-m-d') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

</body>

</html>