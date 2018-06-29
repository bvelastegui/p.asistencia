@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-0">
            {{$course->name}}
        </h1>
        <small class="mb-3">{{$course->level}}</small>
        <p class="lead">Existen registros desde <b>{{ $dates->start_date }}</b> hasta <b>{{ $dates->end_date }}</b></p>
        <form class="form-group" action="">
            <label for="date">Fecha:</label>
            <input type="date" name="" id="" class="form-control">
        </form>
    </div>
@endsection