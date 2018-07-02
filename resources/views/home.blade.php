@extends('layouts.app')
{{--TODO: Las asignaturas no se eliminan solamente se puede activarlos o desactivarlos--}}
{{--TODO: Las asignaturas no se eliminan solamente se puede activarlos o desactivarlos--}}
{{--TODO: Los cursos pueden se modificados (nombre y nivel)--}}
{{--TODO: El administrador otorga claves temporales y al ingresar el usuario ingresa una clave personal--}}
@section('content')
    <div class="container">
        <div class="card-columns">
            <div class="card">
                <div class="card-body d-flex justify-content-between">
                    <i class="material-icons display-2">people</i>
                    <div class="text-right">
                        <div class="display-3">
                            {{ $users }}
                        </div>
                        <div class="lead">Usuarios</div>
                    </div>
                </div>
                <div class="card-footer p-2">
                    <a href="{{ route('users.index') }}" class="btn btn-sm btn-block btn-link p-1">Ver, editar o crear
                        usuarios</a>
                </div>
            </div>
            <div class="card">
                <div class="card-body d-flex justify-content-between">
                    <i class="material-icons display-2">class</i>
                    <div class="text-right">
                        <div class="display-3">
                            {{ $courses }}
                        </div>
                        <div class="lead">Cursos</div>
                    </div>
                </div>
                <div class="card-footer p-2">
                    <a href="{{ route('courses.index') }}" class="btn btn-sm btn-block btn-link p-1">Ver, editar o crear
                        cursos</a>
                </div>
            </div>
            <div class="card">
                <div class="card-body d-flex justify-content-between">
                    <i class="material-icons display-2">school</i>
                    <div class="text-right">
                        <div class="display-3">
                            {{ $students }}
                        </div>
                        <div class="lead">Estudiantes</div>
                    </div>
                </div>
                <div class="card-footer text-center p-2">
                    <div style="font-size: 0.7875rem;" class="p-1">Los estudiantes se modifican en la página de cursos
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body d-flex justify-content-between">
                    <i class="material-icons display-2">library_books</i>
                    <div class="text-right">
                        <div class="display-3">
                            {{ $subjects }}
                        </div>
                        <div class="lead">Materias</div>
                    </div>
                </div>
                <div class="card-footer text-center p-2">
                    <div style="font-size: 0.7875rem;" class="p-1">Las materias se modifican en la página de cursos
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body d-flex justify-content-between">
                    <i class="material-icons display-2">schedule</i>
                    <div class="text-right">
                        <div class="display-3">
                            {{ $schedules->sum('hours_per_subject') }}
                        </div>
                        <div class="lead">Horas de clase</div>
                    </div>
                </div>
                <div class="card-footer text-center p-2">
                    <div style="font-size: 0.7875rem;" class="p-1">Las horas de clase se modifican en la página de
                        cursos
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body d-flex justify-content-between">
                    <i class="material-icons display-2">schedule</i>
                    <div class="text-right">
                        <div class="display-3">
                            {{ $hours->hours_this_month }}
                        </div>
                        <div class="lead">Horas registradas</div>
                    </div>
                </div>
                <div class="card-footer text-center p-2">
                    <div style="font-size: 0.7875rem;" class="p-1">Horas registradas este mes
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('modals.course')
@endsection
