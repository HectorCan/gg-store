@extends('layouts.master')

@section('tabs_menu')
    <li class="c-header-nav-item px-3"><a class="c-header-nav-link" href="#"> Permission</a></li>
    <li class="c-header-nav-item px-3"><a class="c-header-nav-link" href="#"> Role</a></li>
    <li class="c-header-nav-item px-3"><a class="c-header-nav-link" href="#"> User</a></li>
@endsection

@section('content')
    @yield('tab')
@endsection
