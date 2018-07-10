@inject('subjects','App\Repositories\SubjectsRepository')
@inject('users', 'App\Repositories\UsersRepository' )
@php($teachers = $users->teachers())
<div id="subjects" class="tab-pane active accordion">
  <div class="text-right mb-3">
    <a href="#subjectModal" data-toggle="modal"
       class="btn btn-sm btn-outline-secondary">Añadir materia</a>
  </div>
  @foreach($subjects->byCourse($course) as $subject)
    <form class="card" method="post" action="{{ route('courses.subjects.update', ['courseId' => $course]) }}">
      <div class="card-header d-flex justify-content-between bg-transparent">
        <div>
          <b>{{ $loop->iteration }}.</b> {{ $subject->name }}
          <p class="text-muted mb-0">{{ $subject->teacher->name }}</p>
        </div>
        <div>
          <button style="height: 30px; width: 30px;"
                  type="button"
                  data-toggle="collapse"
                  data-target="#updateSubject-{{ $subject->id }}"
                  class="btn btn-sm btn-outline-primary p-1">
            <i class="material-icons" style="font-size: 20px">edit</i>
          </button>
          @if($subject->active)
            <button name="active" value="0" style="height: 30px; width: 30px;"
                    class="btn btn-sm btn-outline-warning p-1">
              <i class="material-icons" style="font-size: 20px">visibility_off</i>
            </button>
          @else
            <button name="active" value="1" style="height: 30px; width: 30px;"
                    class="btn btn-sm btn-outline-warning p-1">
              <i class="material-icons" style="font-size: 20px">visibility</i>
            </button>
          @endif
        </div>
      </div>
      <div class="collapse" id="updateSubject-{{ $subject->id }}" data-parent="#subjects">
        <div class="card-body">
          @csrf
          @method('PUT')
          <input type="hidden" name="id" value="{{ $subject->id }}">
          <div class="form-group">
            <label for="name">Nombre:</label>
            <input type="text" name="name"
                   id="name"
                   class="form-control" value="{{ $subject->name }}" required>
          </div>
          <div class="form-group">
            <label for="user_id">Profesor:</label>
            <select name="user_id" id="user_id"
                    class="form-control" required>
              <option value="">Seleccione un profesor</option>
              @foreach($teachers as $user)
                <option value="{{ $user->id }}" {{ $subject->user_id === $user->id ? 'selected' : '' }}>
                  {{ $user->name }}
                </option>
              @endforeach
            </select>
          </div>
        </div>
        <div class="card-footer">
          <button class="btn btn-primary" type="submit">Guardar cambios</button>
        </div>
      </div>
    </form>
  @endforeach
</div>

@include('modals.subject', ['course' => $courseId,'teachers' => $teachers])
