@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="text-muted ml-3 mb-3">{{ __($day) }}, {{ date('d \d\e M') }}</div>
    <div class="list-group mb-3">
      @forelse($schedules as $schedule)
        <div class="list-group-item d-flex justify-content-between">
          <div>
            <div>{{$schedule->subject->name}}</div>
            <p class="text-muted">{{ $schedule->subject->course->name }}
              - {{ $schedule->subject->course->level }}</p>
            <small class="text-muted">{{$schedule->start}} - {{ $schedule->end }}</small>
          </div>
          <div>
            <a href="{{route('workDays.edit',['subject' => $schedule->subject->id, 'date' => date('Y-m-d')])}}"
               class="btn btn-primary">Registrar asistencia</a>
          </div>
        </div>
      @empty
        <div class="alert alert-success" role="alert">
          <h4 class="alert-heading">Bien</h4>
          <p>Al parecer hoy no tienes horas de clase</p>
        </div>
      @endforelse
    </div>
    <div class="mb-3">
      <div class="form-inline text-muted ml-3 mb-3">
        Por fecha
        <input type="text"
               name="date"
               id="fecha"
               class="form-control form-control-sm ml-3 bg-transparent"
               placeholder="Seleccione una fecha"
               value="{{ $selected_date }}">
      </div>
      @forelse($lastSchedules as $lastSchedule)
        <div class="list-group-item d-flex justify-content-between">
          <div>
            <div>{{$lastSchedule->subject->name}}</div>
            <p class="text-muted">{{ $lastSchedule->subject->course->name }}
              - {{ $lastSchedule->subject->course->level }}</p>
            <small class="text-muted">{{$lastSchedule->start}} - {{ $lastSchedule->end }}</small>
          </div>
          <div>
            <a href="{{route('workDays.edit',['subject' => $lastSchedule->subject->id, 'date' => $selected_date])}}"
               class="btn btn-primary">Actualizar asistencia</a>
          </div>
        </div>
      @empty
        <div class="alert alert-info" role="alert">
          <p>Al parecer no tienes horas de clase registradas para esta fecha</p>
        </div>
      @endforelse
    </div>
  </div>
  <script>
      window.addEventListener('DOMContentLoaded', function () {
          flatpickr('#fecha', {
              locale: 'es',
              altInput: true,
              altFormat: "l, j \\de F",
              dateFormat: "Y-m-d",
              maxDate: '{{ \Carbon\Carbon::now()->subDay()->format('Y-m-d') }}',
              enable: [
                  function (date) {
                      return (date.getDay() !== 6 && date.getDay() !== 0);
                  }
              ],
          });

          $('#fecha').on('change', function () {
              let $date = $(this).val();
              window.location = '{{ route('schedules.index') }}?date=' + $date
          })
      })
  </script>
@endsection