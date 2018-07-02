@inject('students','App\Repositories\StudentsRepository')

<div id="students" class="tab-pane active">
    <table class="table">
        <thead>
        <tr>
            <th>Nº</th>
            <th>{{__('Name')}}</th>
            <th>{{__('Last Name')}}</th>
            <th class="text-right">
                <a href="#studentModal" data-toggle="modal" class="btn btn-sm btn-outline-secondary">
                    {{__('Add student')}}
                </a>
            </th>
        </tr>
        </thead>
        <tbody>
        @foreach($students->byCourse($course) as $k => $student)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $student->name }}</td>
                <td>{{ $student->last_name }}</td>
                <td class="text-right">
                    <button style="height: 30px; width: 30px;" type="button" class="btn btn-sm btn-outline-primary p-1">
                        <i class="material-icons" style="font-size: 20px">edit</i>
                    </button>
                    @if($student->active)
                        <button style="height: 30px; width: 30px;" type="button"
                                class="btn btn-sm btn-outline-warning p-1">
                            <i class="material-icons" style="font-size: 20px">visibility_off</i>
                        </button>
                    @else
                        <button style="height: 30px; width: 30px;" type="button"
                                class="btn btn-sm btn-outline-success p-1">
                            <i class="material-icons" style="font-size: 20px">visibility</i>
                        </button>
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

@include('modals.student', ['course' => $courseId])