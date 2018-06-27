@inject('subjects','App\Repositories\SubjectsRepository')
@inject('schedules','App\Repositories\SchedulesRepository')
@php($subjectsInCourse = $subjects->byCourse($course))
<div id="classSchedule" class="tab-pane active accordion">
    @foreach(['Monday','Tuesday','Wednesday','Thursday','Friday'] as $day)
        @php($schedulesByCourseAndDay = $schedules->byCourseAndDay($course, $day))
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h5 class="mb-0">
                    {{ __($day) }}
                    <small class="text-muted">{{$schedulesByCourseAndDay->count()}} {{__('Subjects')}}</small>
                </h5>
                <button type="submit" class="close collapsed" data-toggle="collapse" data-target="#day-{{$day}}">
                    <i class="material-icons">visibility</i>
                </button>
            </div>
            <div class="collapse" id="day-{{$day}}" data-parent="#classSchedule">
                <div class="list-group list-group-flush">
                    <form class="list-group-item d-flex justify-content-between" method="post"
                          action="{{ route('courses.classSchedule.store', ['courseId' => $course]) }}">
                        @csrf
                        <input type="hidden" name="day" value="{{ $day }}">
                        <div class="form-group">
                            <label for="subject">{{__('Subject')}}</label>
                            <select name="subject" class="form-control" id="subject" required>
                                <option></option>
                                @foreach($subjectsInCourse as $subject)
                                    <option value="{{$subject->id}}">{{$subject->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="start">{{__('Start time')}}</label>
                            <input type="time" class="form-control" name="start" id="start" required>
                        </div>
                        <div class="form-group">
                            <label for="end">{{__('End time')}}</label>
                            <input type="time" class="form-control" name="end" id="end" required>
                        </div>
                        <button class="btn ml-3 btn-sm" type="submit">
                            <i class="material-icons d-block mb-2">add</i>
                            {{__('Add')}}
                        </button>
                    </form>
                    @forelse($schedulesByCourseAndDay as $schedule)
                        <div class="list-group-item">
                            <form method="post"
                                  action="{{ route('courses.classSchedule.delete', ['courseId' => $course]) }}">
                                @csrf
                                @method('delete')
                                <input type="hidden" name="schedule" value="{{$schedule->id}}">
                                <button type="submit" class="close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                {{ $schedule->subject->name }}
                            </form>
                            <small class="text-muted">{{$schedule->subject->teacher->name}}</small>
                            <p>{{$schedule->start}} - {{$schedule->end}}</p>
                        </div>
                    @empty
                        <div class="list-group-item">Aun no se asignan las horas de clase</div>
                    @endforelse
                </div>
            </div>
        </div>
    @endforeach
</div>