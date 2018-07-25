@extends('layouts.admin')
@section('content')
  <div class="container-fluid">
    <div class="row">
      <div class="{{ isset($courseId) ? 'col-md-4': 'col-md-12' }}">
        <div class="text-right mb-3">
          <a href="#courseModal" id="createCourse" class="btn btn-sm btn-outline-secondary" data-toggle="modal">
            {{__('Add course')}}
          </a>
        </div>
        <div class="card">
          <div class="list-group list-group-flush">
            @foreach($courses as $course)
              <div class="list-group-item{{ isset($courseId) && $courseId == $course->id ? ' active': '' }}">
                <div class="d-flex w-100 justify-content-between">
                  <div>
                    <h5 class="mb-0">{{ $course->name }}</h5>
                    <p>{{ $course->level }}</p>
                    <p>{{ $course->period }}</p>
                    <p class="mb-0 text-muted">{{ $course->code }}</p>
                  </div>
                  <div class="text-right">
                    <a href="{{route('reports.index',['course' => $course->id])}}"
                       class="btn btn-secondary btn-sm d-flex justify-content-start">
                      <i class="material-icons mr-2">assessment</i>
                      <span class="p-1">Reportes</span>
                    </a>
                    <a class="btn btn-secondary mt-2 btn-sm d-flex justify-content-start"
                       href="?course={{ $course->id }}">
                      <i class="material-icons mr-2">settings</i>
                      <span class="p-1">Configuracionies</span>
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
                  <a class="nav-link{{ $activeTab == 'default' ? ' active':'' }}"
                     href="?course={{$courseId}}&tab=default">{{__('Editar información')}}</a>
                </li>
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
                      onclick="window.location = '{{ route('courses.index') }}'">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="card-body tab-content">
              @if($activeTab === 'default')
                @php($course = \App\Course::find($courseId))
                <form id="default" class="tab-pane active" method="post">
                  @csrf
                  @method('put')
                  <input type="hidden" name="id" value="{{$course->id}}">
                  <div class="modal-body">
                    <div class="form-group">
                      <label for="name">{{__('Name')}}:</label>
                      <input type="text" class="form-control" name="name" id="name" value="{{ $course->name }}"
                             required>
                    </div>
                    <div class="form-group">
                      <label for="level">{{__('Level')}}:</label>
                      <input type="text" class="form-control" name="level" id="level" value="{{ $course->level }}"
                             required>
                    </div>
                    <div class="form-group">
                      <label for="period">Periodo:</label>
                      <input type="text" class="form-control" name="period" id="period" value="{{ $course->period }}"
                             required>
                    </div>
                    <div class="form-group">
                      <label for="code">{{__('Code')}}:</label>
                      <input type="text" class="form-control" name="code" id="code" value="{{ $course->code }}"
                             required>
                    </div>
                    <div class="form-group">
                      <button class="btn btn-primary" type="submit">Guardar cambios</button>
                    </div>
                </form>
              @endif
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