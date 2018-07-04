@extends('layouts.app')
{{--TODO: Los alumnos no se eliminan solamente se puede activarlos o desactivarlos--}}
{{--TODO: Las asignaturas no se eliminan solamente se puede activarlos o desactivarlos--}}
{{--TODO: Las asignaturas no se eliminan solamente se puede activarlos o desactivarlos--}}
{{--TODO: Los cursos pueden se modificados (nombre y nivel)--}}
{{--TODO: El administrador otorga claves temporales y al ingresar el usuario ingresa una clave personal--}}
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="{{ isset($courseId) ? 'col-md-4': 'col-md-12' }}">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex w-100 justify-content-between">
                            <h4 class="mb-0">{{__('Courses')}}</h4>
                            <div>
                                <a href="#courseModal" class="btn btn-sm btn-outline-secondary" data-toggle="modal">
                                    {{__('Add')}}
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="list-group list-group-flush">
                        @foreach($courses as $course)
                            <div class="list-group-item{{ isset($courseId) && $courseId == $course->id ? ' active': '' }}">
                                <div class="d-flex w-100 justify-content-between">
                                    <div>
                                        <h5 class="mb-0">{{ $course->name }}</h5>
                                        <p>{{ $course->level }}</p>
                                    </div>
                                    <div class="text-right">
                                        <a href="{{route('reports.index',['course' => $course->id])}}"
                                           class="btn btn-link btn-sm">
                                            <i class="material-icons" style="color: var(--secondary)">assessment</i>
                                        </a>
                                        <a class="btn btn-link btn-sm" href="?course={{ $course->id }}">
                                            <i class="material-icons" style="color: var(--secondary)">settings</i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @if(!is_null($courseId))
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <ul class="nav nav-tabs card-header-tabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link{{ $activeTab == 'students' ? ' active':'' }}"
                                       href="?course={{$courseId}}&tab=students">{{__('Students')}}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link{{ $activeTab == 'subjects' ? ' active':'' }}"
                                       href="?course={{$courseId}}&tab=subjects">{{__('Subjects')}}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link{{ $activeTab == 'classSchedule' ? ' active':'' }}"
                                       href="?course={{$courseId}}&tab=classSchedule">{{__('Class Schedule')}}</a>
                                </li>
                            </ul>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"
                                    onclick="window.location = '/courses'">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="card-body tab-content">
                            @includeWhen($activeTab == 'students', 'course.students', ['course' => $courseId])
                            @includeWhen($activeTab == 'subjects', 'course.subjects', ['course' => $courseId])
                            @includeWhen($activeTab == 'classSchedule', 'course.classSchedule', ['course' => $courseId])
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
    @include('modals.course')
@endsection