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
                    {{__('Add')}}
                </a>
            </th>
        </tr>
        </thead>
        <tbody>
        @foreach($students->byCourse($course) as $k => $student)
            <tr>
                <td>{{($k + 1)}}</td>
                <td>{{ $student->name }}</td>
                <td>{{ $student->lastName }}</td>
                <td class="text-right">
                    <a href="/students/{{$student->id}}/delete">
                        <i class="material-icons" style="color: var(--danger)">delete_forever</i>
                    </a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

@include('modals.student', ['course' => $courseId])