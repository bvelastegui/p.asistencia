@extends('layouts.app')
@section('content')
  <div class="container">
    <h1 class="text-center mb-5">Usted cuenta con varios perfiles, a cual desea ingresar</h1>
    <div class="card-columns" style="column-count: 2">
      <div class="card">
        <div class="card-body text-center">
          <i class="display-1 material-icons">person</i>
        </div>
        <div class="card-footer text-center">
          <a href="{{ route('schedules.index') }}">Ingresar como profesor</a>
        </div>
      </div>
      <div class="card">
        <div class="card-body text-center">
          <i class="display-1 material-icons">how_to_reg</i>
        </div>
        <div class="card-footer text-center">
          <a href="{{ route('admin.index') }}">Ingresar como adminsitrador</a>
        </div>
      </div>
    </div>
  </div>
@endsection
