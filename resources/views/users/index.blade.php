@extends('layouts.admin')

@section('content')
  <div class="{{ is_null($selected_user) ? 'container' : 'container-fluid'  }}">
    <div class="row">
      <div class="{{ is_null($selected_user) ? 'col-md-12': 'col-md-3' }}">
        <div class="card">
          <div class="list-group list-group-flush">
            <div class="list-group-item">
              <button class="btn btn-secondary btn-block" data-toggle="modal" data-target="#userModal">
                Añadir usuario
              </button>
            </div>
            @foreach($users as $user)
              <div
                  class="list-group-item d-flex justify-content-between{{ !is_null($selected_user) && $selected_user->id == $user->id ? ' active': '' }}">
                <div class="d-flex justify-content-start">
                  @if($user->role === 'admin')
                    <i class="material-icons mr-3" style="font-size: 40px!important; ">how_to_reg</i>
                  @endif
                  <div>
                    <h5 class="mb-0">
                      {{ $user->name }}
                    </h5>
                    <p>{{ $user->identity }}</p>
                  </div>
                </div>
                <div class="text-right">
                  <a href="{{ route('users.index', ['user' => $user->id]) }}"
                     class="btn btn-secondary btn-sm d-flex justify-content-start">
                    <i class="mr-2 material-icons">edit</i>
                    <span class="p-1">Editar usuario</span>
                  </a>
                  <form action="{{ route('users.update', ['user' => $user->id]) }}" method="post">
                    @csrf
                    @method('put')
                    @if($user->active)
                      <button title="Desactivar usuario" class="btn btn-sm btn-danger d-flex justify-content-start mt-2"
                               type="submit" name="active" value="0">
                        <i class="mr-2 material-icons">visibility_off</i>
                        <span class="p-1">Deshabilitar usuario</span>
                      </button>
                    @else
                      <button title="Activar usuario"
                              class="btn btn-success btn-sm d-flex justify-content-start"
                              type="submit" name="active" value="1">
                        <i class="material-icons">visibility</i>
                        <span class="p-1">Habilitar usuario</span>
                      </button>
                    @endif
                  </form>
                </div>
              </div>
            @endforeach
          </div>
        </div>
      </div>
      @if(!is_null($selected_user))
        <div class="col-md-9">
          @if(session()->has('success'))
            <div class="alert alert-success">
              {{session()->get('success')}}
            </div>
          @endif
          @if($errors->any())
            <div class="alert alert-danger">
              <ul>
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          @endif
          <form class="card" method="post">
            <div class="card-header">
              Editar usuario
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"
                      onclick="window.location = '{{ route('users.index') }}'">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            @csrf
            @method('put')
            <div class="card-body">
              @if($selected_user->change_password_on_next_login)
                <div class="alert alert-dismiss alert-info">
                  <h5 class="mb-0">Cambio de contraseña pendiente</h5>
                  <p>El usuario tiene pendiente el cambio de contraseña</p>
                </div>
              @endif
              <div class="form-group">
                <label for="identity">N° de cédula:</label>
                <input type="text" name="identity" maxlength="10" id="identity" class="form-control"
                       value="{{ $selected_user->identity }}">
              </div>
              <div class="form-group">
                <label for="email">Correo electrónico:</label>
                <input type="text" name="email" id="email" class="form-control"
                       value="{{ $selected_user->email }}">
              </div>
              <div class="form-group">
                <label for="name">Nombre:</label>
                <input type="text" name="name" id="name" class="form-control"
                       value="{{ $selected_user->name }}">
              </div>
              <div class="form-group">
                <label for="password">Contraseña:</label>
                <input type="password" name="password" id="password" class="form-control">
              </div>
              <div class="form-group">
                <label for="password_confirmation">Repita la contraseña:</label>
                <input type="password" name="password_confirmation" id="password_confirmation"
                       class="form-control">
              </div>
              <div class="custom-control custom-checkbox">
                <input type="checkbox" id="change_password_on_next_login"
                       name="change_password_on_next_login" class="custom-control-input">
                <label class="custom-control-label" for="change_password_on_next_login">Solicitar cambio
                  de contraseña al próximo inicio de sesión</label>
              </div>
              <div class="custom-control custom-checkbox">
                <input type="checkbox" id="is_admin1" name="is_admin"
                       class="custom-control-input" {{ $selected_user->is_admin ? 'checked':'' }}>
                <label class="custom-control-label" for="is_admin1">Conceder permisos de administrador</label>
              </div>
            </div>
            <div class="card-footer">
              @if($selected_user->role === 'admin')
                <button disabled class="btn btn-sm btn-info">
                  Guardar los cambios
                </button>
                <span class="text-danger">No pude modificar a otro administrador</span>
              @else
                <button class="btn btn-sm btn-info">
                  Guardar los cambios
                </button>
              @endif
            </div>
          </form>
        </div>
      @endif
    </div>
  </div>
  @include('modals.user')
@endsection