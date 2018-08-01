<div class="modal fade" id="userModal" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form class="modal-content" method="post"
          action="{{route('users.store')}}">
      @csrf
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Añadir usuario</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        @if($errors->any())
          <div class="alert alert-danger">
            <b>Existen varios errores:</b>
            <ul>
              @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif
        <div class="form-group">
          <label for="name">Nombre completo:</label>
          <input type="text" class="form-control" name="name" id="name" value="{{ old('name') }}" required>
        </div>
        <div class="form-group">
          <label for="identity">Nº de cédula:</label>
          <input type="text" maxlength="10" class="form-control" name="identity" id="identity"
                 value="{{ old('identity') }}" required>
        </div>
        <div class="form-group">
          <label for="email">Correo electrónico:</label>
          <input type="email" class="form-control" name="email" id="email" value="{{ old('email') }}" required>
        </div>
        <div class="form-group">
          <label for="password">Contraseña:</label>
          <input type="password" class="form-control" name="password" id="password" required>
        </div>
        <div class="form-group">
          <label for="password_confirmation">Repita la contraseña:</label>
          <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" required>
        </div>
        <div class="custom-control custom-checkbox">
          <input type="checkbox" id="change_password_on_next_login1"
                 name="change_password_on_next_login" class="custom-control-input">
          <label class="custom-control-label" for="change_password_on_next_login1">Solicitar cambio de contraseña al
            próximo inicio de sesión</label>
        </div>
        <div class="custom-control custom-checkbox">
          <input type="checkbox" id="is_admin" name="is_admin" class="custom-control-input">
          <label class="custom-control-label" for="is_admin">Conceder permisos de administrador</label>
        </div>
      </div>
      <div class="modal-footer">
        <button type="reset" class="btn btn-secondary" data-dismiss="modal">{{__('Close')}}</button>
        <button type="submit" class="btn btn-primary">{{__('Save')}}</button>
      </div>
    </form>
  </div>
</div>