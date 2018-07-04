@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="mb-0">
            {{$subject->name}}
        </h2>
        <p class="lead">{{$subject->course->name}} - {{ $subject->course->level }}</p>
        @if(session()->has('success'))
            <div class="alert alert-success">
                {{session()->get('success')}}
            </div>
        @endif
        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form class="card" method="post"
              action="{{$workDay->exists ? route('workDays.update', ['date' => $workDay->date, 'subject' => $subject->id]): route('workDays.store', ['date' => $workDay->date, 'subject' => $subject->id])}}">
            @csrf
            @if($workDay->exists)
                @method('PUT')
                <input type="hidden" name="workDayId" value="{{$workDay->id}}">
            @endif
            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-lg-8 col-md-8">
                        <input type="text" name="theme" id="theme" class="w-100 form-control"
                               value="{{$workDay->theme}}" placeholder="{{__('Theme')}}">
                    </div>
                    <div class="col-12 text-center text-md-right text-lg-right col-lg-4 col-md-8 mt-3 m-md-0">
                        <div class="btn-group">
                            <button class="btn btn-success" type="submit" value="1"
                                    name="start" {{ $workDay->start ? 'disabled' : '' }}>{{ $workDay->start ?'Inició: '. $workDay->start :'Registrar hor. ingreso' }}</button>
                            <button class="btn btn-danger" type="submit" name="end" value="1"
                                    value="2" {{ $workDay->end ? 'disabled' : '' }}>{{ $workDay->end ? 'Finalizó: '. $workDay->end:'Registrar hor. salida' }}</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered mb-0">
                    <thead>
                    <tr>
                        <th>N°</th>
                        <th>Nómina</th>
                        @foreach(['Present', 'Late', 'Absent', 'Justified'] as $status)
                            <th>{{__($status)}}</th>
                        @endforeach
                    </tr>
                    </thead>
                    @foreach($subject->course->students()->where('active', true)->get() as $student)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{$student->last_name}} {{$student->name}}</td>
                            @php($attendance = $workDay->exists ? \App\Attendance::where('work_day_id', $workDay->id)->where('student_id', $student->id)->first():new \App\Attendance(['status' => 'present']))
                            @foreach(['present', 'late', 'absent', 'justified'] as $status)
                                <td width="10" class="text-center">
                                    <div class="custom-control custom-radio">
                                        <input {{ $status == $attendance->status ? 'checked ': '' }}type="radio"
                                               id="customRadio_{{$status}}_{{$student->id}}"
                                               name="attendances[{{$student->id}}]" class="custom-control-input"
                                               value="{{$status}}" title="{{$status}}">
                                        <label class="custom-control-label"
                                               for="customRadio_{{$status}}_{{$student->id}}">&nbsp;</label>
                                    </div>
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                </table>
            </div>
            <div class="card-footer">
                <button class="btn btn-block" type="submit">{{__('Save')}}</button>
            </div>
        </form>
    </div>
@endsection