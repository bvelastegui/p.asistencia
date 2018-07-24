<!-- Course Modal -->
@php
  /** @var $errors \Illuminate\Support\ViewErrorBag */
@endphp
@if(session()->has('error1'))
  <script>
      document.addEventListener('DOMContentLoaded', function () {
          $('#createCourse').trigger('click')
      });
  </script>
@endif
<div class="modal fade" id="courseModal" role="dialog" aria-labelledby="courseModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form class="modal-content" method="post" action="{{route('courses.store')}}">
      @csrf
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">{{__('Add course')}}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        @if($errors->any())
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Existen varios errores</strong>
            <ul>
              @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
        @endif
        <div class="form-group">
          <label for="name">{{__('Name')}}:</label>
          <input type="text" class="form-control" name="name" id="name" value="{{ old('name') }}" required>
        </div>
        <div class="form-group">
          <label for="level">{{__('Level')}}:</label>
          <input type="text" class="form-control" name="level" id="level" value="{{ old('level') }}" required>
        </div>
        <div class="form-group">
          <label for="period">Periodo:</label>
          <input type="text" class="form-control" name="period" id="period" value="{{ old('period') }}" required>
        </div>
        <div class="form-group">
          <label for="code">{{__('Code')}}:</label>
          <input type="text" class="form-control" name="code" id="code" value="{{ old('code') }}" required>
        </div>
      </div>
      <div class="modal-footer">
        <button type="reset" class="btn btn-secondary" data-dismiss="modal">{{__('Close')}}</button>
        <button type="submit" class="btn btn-primary">{{__('Save')}}</button>
      </div>
    </form>
  </div>
</div>
<script>
    window.addEventListener('DOMContentLoaded', function () {
        $('#name').on('change', function () {
            let code = $('#code').val();
            if (code.length) {
                let part1 = code.substring(0, 3);
                let part2 = $(this).val().substring(0, 3);
                $('#code').val(part1 + ' ' + part2);
            }
        });

        $('#level').on('change', function () {
            let part1 = $(this).val().substring(0, 3);
            let part2 = $('#name').val().substring(0, 3);
            $('#code').val(part1 + ' ' + part2);
        })
    })
</script>