@inject('subjects','App\Repositories\SubjectsRepository')

<div id="subjects" class="tab-pane active">
    <table class="table">
        <thead>
        <tr>
            <th>Nº</th>
            <th>{{__('Name')}}</th>
            <th>{{__('Teacher')}}</th>
            <th class="text-right">
                <a href="#subjectModal" data-toggle="modal"
                   class="btn btn-sm btn-outline-secondary">{{__('Add')}}</a>
            </th>
        </tr>
        </thead>
        <tbody>
        @foreach($subjects->byCourse($course) as $subject)
            <tr>
                <td>{{ $loop->count }}</td>
                <td>{{ $subject->name }}</td>
                <td>{{ $subject->teacher->name }}</td>
                <td class="text-right">
                    <a href="/students/{{$subject->id}}/delete">
                        <i class="material-icons" style="color: var(--warning)">settings</i>
                    </a>
                    <a href="/students/{{$subject->id}}/delete">
                        <i class="material-icons" style="color: var(--danger)">delete_forever</i>
                    </a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

@include('modals.subject', ['course' => $courseId])
