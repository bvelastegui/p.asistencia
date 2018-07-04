@extends('layouts.app')

@section('content')
    <div class="container-fluid">
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
                            <div class="list-group-item d-flex justify-content-between{{ !is_null($selected_user) && $selected_user->id == $user->id ? ' active': '' }}">
                                <div>
                                    <h5 class="mb-0">{{ $user->name }}</h5>
                                    <p>{{ $user->identity }}</p>
                                </div>
                                <div>
                                    <a href="{{ route('users.index', ['user' => $user->id]) }}"
                                       class="btn btn-outline-secondary btn-sm" style="height: 32px">
                                        <i class="material-icons">settings</i>
                                    </a>
                                    @if($user->role !== 'admin')
                                        <form action="{{ route('users.update', ['user' => $user->id]) }}" method="post">
                                            @csrf
                                            @method('put')
                                            @if($user->active)
                                                <button title="Desactivar usuario" class="btn btn-sm btn-outline-danger"
                                                        style="height: 32px" type="submit" name="active" value="0">
                                                    <i class="material-icons">visibility_off</i>
                                                </button>
                                            @else
                                                <button title="Activar usuario" style="height: 32px;"
                                                        class="btn btn-outline-success btn-sm"
                                                        type="submit" name="active" value="1">
                                                    <i class="material-icons">visibility</i>
                                                </button>
                                            @endif
                                        </form>
                                    @endif
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
                                    onclick="window.location = '/users'">
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