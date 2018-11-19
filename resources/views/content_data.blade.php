@extends('layouts.app')

@section('content')

    <div id="wrapper">
        @include('layouts.sidebar')
        @yield('data_content')
        <!-- /.content-wrapper -->
    </div>
@endsection
