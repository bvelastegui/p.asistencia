@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <input type="text" class="text form-control" id="fecha" placeholder="Seleccione un rango de tiempo">
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-12">
                <table class="table table-light">
                    <thead class="thead-dark">
                    <tr>
                        <th>Cédula</th>
                        <th>Nombre</th>
                        <th>Horas a trabajar</th>
                        <th>Horas trabajadas</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($info as $item)
                        <tr>
                            <td>{{ $item->identity }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->total_time }}</td>
                            <td>{{ $item->real_time }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script>
        window.addEventListener('DOMContentLoaded', function () {
            flatpickr('#fecha', {
                locale: 'es',
                mode: 'range',
                dateFormat: 'Y-m-d',
                defaultDate: ['{{ $start }}', '{{ $end }}'],
                onChange: function (selectedDates, dateStr, instance) {
                    if (selectedDates.length === 2) {
                        let dates = dateStr.split(' a ');
                        window.location = '{{ route('reports.show') }}?start=' + dates[0] + '&end=' + dates[1]
                    }
                }
            });
        })
    </script>
@endsection
