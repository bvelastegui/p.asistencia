@extends('layouts.admin')

@section('content')
  <form class="container" method="post" action="{{ route('reports.generate') }}">
    @csrf
    <div class="row">
      <div class="col-12 d-flex justify-content-between">
        <input type="text" class="text form-control" name="fecha" id="fecha"
               placeholder="Seleccione un rango de tiempo">
        <button type="submit" name="type" value="pdf" class="btn btn-secondary ml-2">Generar PDF</button>
        <button type="submit" name="type" value="xlsx" class="btn btn-secondary ml-2">Generar hoja de calculo
        </button>
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
            <th width="15%">Precio Hora</th>
            <th width="15%">Total a pagar</th>
          </tr>
          </thead>
          <tbody>
          @foreach($info as $item)
            <input type="hidden" name="users[{{ $item->identity }}][name]" value="{{ $item->name }}">
            <input type="hidden" name="users[{{ $item->identity }}][total]" value="{{ $item->total_time }}">
            <input type="hidden" name="users[{{ $item->identity }}][real]" value="{{ $item->real_time }}">
            <tr>
              <td>{{ $item->identity }}</td>
              <td>{{ $item->name }}</td>
              <td>{{ $item->total_time }}</td>
              <td>{{ $item->real_time }}</td>
              <td>
                <div class="input-group input-group-sm">
                  <div class="input-group-prepend">
                    <span class="input-group-text">$</span>
                  </div>
                  <input class="price_per_hour form-control form-control-sm" placeholder=""
                         type="text"
                         tabindex="{{ $item->id }}"
                         name="users[{{ $item->identity }}][price]"
                         id="price_for_{{ $item->identity }}"
                         data-info="{{ json_encode($item) }}" required>
                </div>
              </td>
              <td>
                <div class="input-group input-group-sm">
                  <div class="input-group-prepend">
                    <span class="input-group-text">$</span>
                  </div>
                  <input type="text" readonly
                         placeholder="0"
                         name="users[{{ $item->identity }}][total_price]"
                         id="total_price_for_{{ $item->identity }}"
                         class="form-control form-control-sm" required>
                </div>
              </td>
            </tr>
          @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </form>
  <script>
      window.addEventListener('DOMContentLoaded', function () {
          let $pricePerHour = $('.price_per_hour');

          $pricePerHour.on('keypress', isNumberKey);
          $pricePerHour.on('change', function () {
              let info = $(this).data('info');
              let price = $(this).val();
              let hours = info.minutes_worked / 60;
              console.log(info);
              $('#total_price_for_' + info.identity).val(hours * price)
          });

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
      });

      function isNumberKey(evt) {
          let obj = evt.target;
          let charCode = (evt.which) ? evt.which : event.keyCode
          let value = obj.value;
          let dotcontains = value.indexOf(".") !== -1;
          if (dotcontains)
              if (charCode === 46) return false;
          if (charCode === 46) return true;
          if (charCode > 31 && (charCode < 48 || charCode > 57))
              return false;
          return true;
      }
  </script>
@endsection
