@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="text-muted ml-3 mb-3">{{ __(date('l')) }}, {{ date('d \d\e M') }}</div>
        <div class="list-group mb-3">
            @forelse($schedules as $schedule)
                <a class="list-group-item"
                   href="{{route('workDays.edit',['subject' => $schedule->subject->id, 'date' => date('Y-m-d')])}}">
                    <div>{{$schedule->subject->name}}</div>
                    <p class="text-muted">{{$schedule->subject->course->name}}</p>
                    <small class="text-muted">{{$schedule->start}} - {{ $schedule->end }}</small>
                </a>
            @empty
                <div class="alert alert-success" role="alert">
                    <h4 class="alert-heading">Bien</h4>
                    <p>Al parecer hoy no tienes horas de clase</p>
                </div>
            @endforelse
        </div>
        <div class="text-muted ml-3 mb-3">Días pasados</div>
    </div>
@endsection