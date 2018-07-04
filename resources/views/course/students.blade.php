@inject('students','App\Repositories\StudentsRepository')

<div id="students" class="tab-pane active accordion">
    <div class="text-right mb-3">
        <a href="#studentModal" data-toggle="modal" class="btn btn-sm btn-outline-secondary">
            {{__('Add student')}}
        </a>
    </div>
    @foreach($students->byCourse($course) as $k => $student)
        <form class="card" method="post" action="{{ route('courses.students.update',['course' => $courseId]) }}">
            <div class="card-header d-flex justify-content-between bg-transparent">
                <div><b>{{ $loop->iteration }}.</b> {{ $student->last_name }} {{ $student->name }}</div>
                <div>
                    <button style="height: 30px; width: 30px;"
                            type="button"
                            data-toggle="collapse"
                            data-target="#updateStudent-{{$student->id}}"
                            class="btn btn-sm btn-outline-primary p-1">
                        <i class="material-icons" style="font-size: 20px">edit</i>
                    </button>
                    @if($student->active)
                        <button style="height: 30px; width: 30px;"
                                type="submit" name="active" value="0"
                                title="Desactivar alumno"
                                class="btn btn-sm btn-outline-warning p-1">
                            <i class="material-icons" style="font-size: 20px">visibility_off</i>
                        </button>
                    @else
                        <button style="height: 30px; width: 30px;"
                                type="submit" name="active" value="1"
                                title="Activar alumno"
                                class="btn btn-sm btn-outline-success p-1">
                            <i class="material-icons" style="font-size: 20px">visibility</i>
                        </button>
                    @endif
                </div>
            </div>
            <div class="collapse" id="updateStudent-{{$student->id}}" data-parent="#students">
                <div class="card-body">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id" value="{{ $student->id }}">
                    <div class="form-group">
                        <label for="name">Nombre:</label>
                        <input type="text" name="name" id="name" class="form-control"
                               value="{{ $student->name }}">
                    </div>
                    <div class="form-group">
                        <label for="last_name">Nombre:</label>
                        <input type="text" name="last_name" id="last_name" class="form-control"
                               value="{{ $student->last_name }}">
                    </div>
                </div>
                <div class="card-footer">
                    <button class="btn btn-primary" type="submit">Guardar cambios</button>
                </div>
            </div>
        </form>
    @endforeach
</div>

@include('modals.student', ['course' => $courseId])