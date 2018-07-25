@extends('layouts.app')
@section('nav')
  <ul class="navbar-nav mr-auto">
    <li class="nav-item">
      <a href="{{ route('admin.index') }}"
         class="nav-link{{ request()->route()->getName() === 'admin.index' ? ' active': ''}}">Inicio</a>
    </li>
    <li class="nav-item">
      <a href="{{ route('courses.index') }}"
         class="nav-link{{ request()->route()->getName() === 'courses.index' ? ' active': '' }}">Cursos</a>
    </li>
    <li class="nav-item">
      <a href="{{ route('users.index') }}" class="nav-link">Usuarios</a>
    </li>
  </ul>
@stop