@extends('layouts.master')

@section('tabs_menu')
    <li class="c-header-nav-item px-3"><a class="c-header-nav-link" href="{{ route('maint.u.permission.index') }}"> Permission</a></li>
    <li class="c-header-nav-item px-3"><a class="c-header-nav-link" href="{{ route('maint.u.role.index') }}"> Role</a></li>
    <li class="c-header-nav-item px-3"><a class="c-header-nav-link" href="{{ route('maint.u.user.index') }}"> User</a></li>
@endsection

@section('content')
    @yield('tab')
@endsection
