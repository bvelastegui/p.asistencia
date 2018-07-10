@extends('layouts.app')

@section('content')
  <div class="container-fluid">
    <div class="row">
      <div class="col-7 d-flex justify-content-start">
        <div class="mr-4">
          <i class="material-icons display-4">assessment</i>
        </div>
        <div>
          <h2 class="mb-0">
            {{$course->name}}
          </h2>
          <p class="lead mb-0">{{$course->level}}</p>
        </div>
      </div>
      <div class="col-5">
        <p class="lead mb-2">
          @if($dates->start_date)
            Existen registros desde <b>{{ $dates->start_date }}</b> hasta <b>{{ $dates->end_date }}</b>
          @else
            No existen registros
          @endif
        </p>
        <form id="dateForm" class="form-inline d-flex justify-content-between">
          <label for="date">Seleccione una fecha:</label>
          <input {{ $dates->start_date ? '': 'disabled ' }}type="text" name="date" id="date"
                 class="form-control" value="{{ $now }}">
          <button {{ $dates->start_date ? '': 'disabled ' }}class="btn btn-primary" type="submit">
            Buscar registros
          </button>
        </form>
      </div>
    </div>
    <hr>
    <div class="row">
      <div class="col-12">
        <div class="row">
          <div class="col-12">
            <div class="lead text-center mb-3">Leccionario Académico</div>
            <div class="table-responsive">
              <table class="table table-sm table-light table-bordered">
                <thead class="thead-dark">
                <tr>
                  <th width="10">N°</th>
                  <th>Nómina</th>
                  @php($workDays = collect())
                  @foreach($schedules as $schedule)
                    @php($workDays[$schedule->id] = \App\Attendance::getAttendances($schedule->subject_id, $now)->keyBy('student_id')->toArray())
                    <th class="text-center">{{ $loop->iteration }}</th>
                  @endforeach
                  @foreach(['Present','Late','Absent','Justified'] as $status)
                    <th class="text-center">{{ __($status) }}</th>
                  @endforeach
                </tr>
                </thead>
                <tbody>
                @foreach($course->students()->where('active', true)->get() as $student)
                  @php($sums = ['present' => 0, 'late' => 0, 'absent' => 0, 'justified' => 0])
                  <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $student->last_name }} {{ $student->name }}</td>
                    @foreach($schedules as $schedule)
                      @php($attendance = $workDays[$schedule->id][$student->id] ?? null )
                      @if($attendance)
                        @php($sums[$attendance['status']]++)
                        <td class="text-center">{{ __(ucfirst($attendance['status']))}}</td>
                      @else
                        <td class="text-center table-danger">{{__('Pending')}}</td>
                      @endif
                    @endforeach

                    @foreach(['Present','Late','Absent','Justified'] as $status)
                      <th class="text-center">{{ $sums[strtolower($status)] }}</th>
                    @endforeach
                  </tr>
                @endforeach
                </tbody>
              </table>
            </div>
          </div>
          <div class="col-12">
            <div class="lead text-center mb-3">Registro Académico</div>
            <table class="table table-bordered table-light">
              <thead class="thead-dark">
              <tr>
                <th class="text-center" width="10">H</th>
                <th width="25%">{{ __('Subject') }}</th>
                <th>{{ __('Theme') }}</th>
                <th width="30%">{{ __('Firma') }}</th>
              </tr>
              </thead>
              <tbody>
              @foreach($schedules as $schedule)
                @php($workDay = \App\WorkDay::select('theme')->where('subject_id', $schedule->subject->id)->where('date', $now->format('Y-m-d'))->first())
                <tr class="{{ $workDay ? '': 'table-danger' }}">
                  <td class="text-center">{{ $loop->iteration }}</td>
                  <td>{{ $schedule->subject->name }}</td>
                  <td>{{ $workDay ? $workDay->theme : __('Pending')}}</td>
                  <td></td>
                </tr>
              @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script>
      window.addEventListener('DOMContentLoaded', function () {
          $('#dateForm').on('submit', function (e) {
              e.preventDefault();
              let date = $('#date').val();
              window.location = '{{ route('reports.index', ['course' => $course->id]) }}/' + date
          });
          flatpickr('#date', {
              dateFormat: 'Y-m-d',
              minDate: '{{ $dates->start_date }}',
              maxDate: '{{ $dates->end_date }}',
              enable: [
                  function (date) {
                      return (date.getDay() !== 6 && date.getDay() !== 0);
                  }
              ],
              locale: 'es'
          });
      })
  </script>
@endsection