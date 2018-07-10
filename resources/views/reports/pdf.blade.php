<table style="border-collapse: collapse;width: 100%;">
    <thead>
    <tr>
        <th colspan="6" style="text-align: center" align="center">
            @if($type == 'pdf')
                Reporte<br>De {{ $fecha }}<br><br><br>
            @else
                Reporte de {{ $fecha }}
            @endif
        </th>
    </tr>
    <tr>
        <th style="border-left: 1px solid #e1e1e1; border-top: 1px solid #e1e1e1; padding: 2px">Cédula</th>
        <th style="border-left: 1px solid #e1e1e1; border-top: 1px solid #e1e1e1; padding: 2px">Nombre</th>
        <th style="border-left: 1px solid #e1e1e1; border-top: 1px solid #e1e1e1; padding: 2px">Horas a trabajar</th>
        <th style="border-left: 1px solid #e1e1e1; border-top: 1px solid #e1e1e1; padding: 2px">Horas reportadas</th>
        <th style="border-left: 1px solid #e1e1e1; border-top: 1px solid #e1e1e1; padding: 2px">Precio hora</th>
        <th style="border-left: 1px solid #e1e1e1; border-top: 1px solid #e1e1e1; border-right: 1px solid #e1e1e1; padding: 2px">
            Total a pagar
        </th>
    </tr>
    </thead>
    <tbody>
    @foreach($users as $identity => $user)
        <tr>
            <td style="{{ $loop->last ? 'border-bottom: 1px solid #e1e1e1;':'' }}border-left: 1px solid #e1e1e1; border-top: 1px solid #e1e1e1; padding: 2px">{{ $identity }}</td>
            <td style="{{ $loop->last ? 'border-bottom: 1px solid #e1e1e1;':'' }}border-left: 1px solid #e1e1e1; border-top: 1px solid #e1e1e1; padding: 2px">{{ $user['name'] }}</td>
            <td style="{{ $loop->last ? 'border-bottom: 1px solid #e1e1e1;':'' }}border-left: 1px solid #e1e1e1; border-top: 1px solid #e1e1e1; padding: 2px">{{ $user['total'] }}</td>
            <td style="{{ $loop->last ? 'border-bottom: 1px solid #e1e1e1;':'' }}border-left: 1px solid #e1e1e1; border-top: 1px solid #e1e1e1; padding: 2px">{{ $user['real'] }}</td>
            <td style="{{ $loop->last ? 'border-bottom: 1px solid #e1e1e1;':'' }}border-left: 1px solid #e1e1e1; border-top: 1px solid #e1e1e1; padding: 2px">{{ $user['price'] }}</td>
            <td style="{{ $loop->last ? 'border-bottom: 1px solid #e1e1e1;':'' }}border-left: 1px solid #e1e1e1; border-top: 1px solid #e1e1e1; padding: 2px; border-right: 1px solid #e1e1e1">{{ $user['total_price'] }}</td>
        </tr>
    @endforeach
    </tbody>
</table>