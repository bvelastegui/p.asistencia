@inject('users', 'App\Repositories\UsersRepository' )

<div class="modal fade" id="subjectModal" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form class="modal-content" method="post" action="{{route('courses.subjects.store', ['courseId' => $course])}}">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{__('Add subject')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="name">{{__('Name')}}:</label>
                    <input type="text" class="form-control" name="name" id="name" required>
                </div>
                <div class="form-group">
                    <label for="teacher">{{__('Teacher')}}:</label>
                    <select name="teacher" class="form-control" id="teacher" required>
                        <option></option>
                        @foreach($users->teachers() as $teacher)
                            <option value="{{$teacher->id}}">{{$teacher->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="reset" class="btn btn-secondary" data-dismiss="modal">{{__('Close')}}</button>
                <button type="submit" class="btn btn-primary">{{__('Save')}}</button>
            </div>
        </form>
    </div>
</div>