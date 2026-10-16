@extends('layouts.app')

@section('content')
    <div class="contenedor admin">
        @include('partials.admin-menu')

        <div class="admin__principal">
            @yield('admin')
        </div>
    </div>
@endsection
